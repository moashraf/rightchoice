# remove_inserts.ps1
# Streams a large SQL dump and removes top-level INSERT statements.
# Updated script: keep at most 5 INSERT statements per table
param(
    [string]$InputPath = "C:\ashraf\rightchoice\public\rightchoiceco_rightchoiceco.sql",
    [string]$OutputPath = "C:\ashraf\rightchoice\public\rightchoiceco_rightchoiceco_limit-5-inserts.sql",
    [string]$BackupPath = "C:\ashraf\rightchoice\public\rightchoiceco_rightchoiceco.sql.bak",
    [int]$MaxPerTable = 5
)
Write-Host "Backup: copying $InputPath -> $BackupPath"
Copy-Item -Path $InputPath -Destination $BackupPath -Force

$sr = [System.IO.File]::OpenText($InputPath)
$sw = New-Object System.IO.StreamWriter($OutputPath, $false, [System.Text.Encoding]::UTF8)

$delimiter = ";"
$delLen = $delimiter.Length
$matchIndex = 0
$inSingle = $false
$inDouble = $false
$inBacktick = $false
$inLineComment = $false
$inBlockComment = $false
$sb = New-Object System.Text.StringBuilder

# Replace statement-based INSERT limiting with row-based limiting (keep up to $MaxPerTable rows per table)

# counts per table
$counts = @{}

function Normalize-TableName($raw) {
    if ([string]::IsNullOrWhiteSpace($raw)) { return $null }
    $s = $raw.Trim()
    $s = $s -replace '^[\(\`\"]+','' -replace '[\`\"\)]+$',''
    if ($s -match '\.') {
        $parts = $s.Split('.')
        $tbl = $parts[-1]
    } else { $tbl = $s }
    $tbl = $tbl -replace '`',''
    return $tbl.ToLowerInvariant()
}

function Process-InsertStatement($statementText) {
    # If not an INSERT, return as-is
    if (-not ($statementText -match '(?si)^\s*INSERT')) { return $statementText }

    # Try to extract table name
    if ($statementText -match '(?si)^\s*INSERT(?:\s+IGNORE)?(?:\s+INTO)?\s+([^\s\(]+)') {
        $rawTbl = $matches[1]
    } elseif ($statementText -match '(?si)^\s*INSERT\s+([^\s\(]+)') {
        $rawTbl = $matches[1]
    } else {
        $rawTbl = $null
    }
    $tbl = Normalize-TableName $rawTbl
    if (-not $tbl) { $tbl = '__unknown__' }
    if (-not $counts.ContainsKey($tbl)) { $counts[$tbl] = 0 }

    # Find VALUES keyword position (case-insensitive)
    $m = [regex]::Match($statementText, '(?si)\bVALUES\b')
    if (-not $m.Success) {
        # no VALUES (could be INSERT ... SELECT) - treat as one row-equivalent: count as 1 if under limit
        if ($counts[$tbl] -lt $MaxPerTable) { $counts[$tbl] = $counts[$tbl] + 1; return $statementText } else { return '' }
    }
    $valuesPos = $m.Index + $m.Length
    $prefix = $statementText.Substring(0, $valuesPos)
    $rest = $statementText.Substring($valuesPos)

    # Parse tuples from $rest: top-level comma-separated parenthesized groups
    $tuples = @()
    $sb = New-Object System.Text.StringBuilder
    $depth = 0
    $inS = $false; $inD = $false; $inB = $false
    for ($i=0; $i -lt $rest.Length; $i++) {
        $c = $rest[$i]
        $sb.Append($c) | Out-Null
        # handle quote states
        if ($inS) {
            if ($c -eq "'") {
                # check escaped ''
                if ($i+1 -lt $rest.Length -and $rest[$i+1] -eq "'") { $sb.Append($rest[$i+1]) | Out-Null; $i++; continue }
                else { $inS = $false; continue }
            }
            continue
        }
        if ($inD) {
            if ($c -eq '"') {
                if ($i+1 -lt $rest.Length -and $rest[$i+1] -eq '"') { $sb.Append($rest[$i+1]) | Out-Null; $i++; continue }
                else { $inD = $false; continue }
            }
            continue
        }
        if ($inB) {
            if ($c -eq '`') {
                if ($i+1 -lt $rest.Length -and $rest[$i+1] -eq '`') { $sb.Append($rest[$i+1]) | Out-Null; $i++; continue }
                else { $inB = $false; continue }
            }
            continue
        }
        if ($c -eq "'") { $inS = $true; continue }
        if ($c -eq '"') { $inD = $true; continue }
        if ($c -eq '`') { $inB = $true; continue }

        if ($c -eq '(') { $depth++ }
        elseif ($c -eq ')') {
            if ($depth -gt 0) { $depth-- }
            if ($depth -eq 0) {
                # tuple complete
                $tupleText = $sb.ToString().Trim()
                $tuples += $tupleText
                $sb = New-Object System.Text.StringBuilder
                # skip following whitespace and optional comma (separator will be handled by outer loop building)
                # continue parsing
            }
        }
    }

    if ($tuples.Count -eq 0) {
        # no tuples parsed - fallback to count-as-statement
        if ($counts[$tbl] -lt $MaxPerTable) { $counts[$tbl] = $counts[$tbl] + 1; return $statementText } else { return '' }
    }

    $keep = @()
    foreach ($t in $tuples) {
        if ($counts[$tbl] -lt $MaxPerTable) { $keep += $t; $counts[$tbl] = $counts[$tbl] + 1 } else { break }
    }

    if ($keep.Count -eq 0) { return '' }

    # Reconstruct statement: prefix + ' ' + joined tuples
    $newRest = ' ' + ($keep -join ',')
    $newStmt = $prefix + $newRest
    return $newStmt
}

function Write-Statement($statementText, $delim) {
    if ([string]::IsNullOrWhiteSpace($statementText)) { return }
    # detect DELIMITER statement
    if ($statementText -match '(?i)^\s*DELIMITER\b') {
        $sw.Write($statementText)
        if ($delim) { $sw.Write($delim) }
        $sw.Write("`r`n")
        if ($statementText -match '(?i)^\s*DELIMITER\s+(\S+)') { $newDel = $matches[1]; $delimiter = $newDel; $delLen = $delimiter.Length }
        return
    }

    if ($statementText -match '(?si)^\s*INSERT') {
        $processed = Process-InsertStatement $statementText
        if (-not [string]::IsNullOrWhiteSpace($processed)) {
            $sw.Write($processed)
            if ($delim) { $sw.Write($delim) }
            $sw.Write("`r`n")
        } else {
            # skipped entirely
        }
        return
    }

    # default: write
    $sw.Write($statementText)
    if ($delim) { $sw.Write($delim) }
    $sw.Write("`r`n")
}

# read char-by-char
while (($int = $sr.Read()) -ne -1) {
    $ch = [char]$int
    $sb.Append($ch) | Out-Null

    # handle line comment end
    if ($inLineComment) {
        if ($ch -eq "`n") { $inLineComment = $false }
        continue
    }
    # handle block comment
    if ($inBlockComment) {
        $prev = if ($sb.Length -ge 2) { [char]$sb[$sb.Length-2] } else { '\0' }
        if ($prev -eq '*' -and $ch -eq '/') { $inBlockComment = $false }
        continue
    }
    # handle string escapes for single quotes
    if ($inSingle) {
        if ($ch -eq "'") {
            $peek = $sr.Peek()
            if ($peek -ne -1 -and [char]$peek -eq "'") {
                $next = [char]$sr.Read()
                $sb.Append($next) | Out-Null
                continue
            } else {
                $inSingle = $false
                continue
            }
        }
        continue
    }
    if ($inDouble) {
        if ($ch -eq '"') {
            $peek = $sr.Peek()
            if ($peek -ne -1 -and [char]$peek -eq '"') {
                $next = [char]$sr.Read()
                $sb.Append($next) | Out-Null
                continue
            } else {
                $inDouble = $false
                continue
            }
        }
        continue
    }
    if ($inBacktick) {
        if ($ch -eq '`') {
            $peek = $sr.Peek()
            if ($peek -ne -1 -and [char]$peek -eq '`') {
                $next = [char]$sr.Read()
                $sb.Append($next) | Out-Null
                continue
            } else {
                $inBacktick = $false
                continue
            }
        }
        continue
    }

    # not in any string/comment: detect comment starts
    if ($ch -eq '-') {
        $peek = $sr.Peek()
        if ($peek -ne -1 -and [char]$peek -eq '-') {
            $inLineComment = $true
            $next = [char]$sr.Read()
            $sb.Append($next) | Out-Null
            continue
        }
    }
    if ($ch -eq '#') { $inLineComment = $true; continue }
    if ($ch -eq '/' ) {
        $peek = $sr.Peek()
        if ($peek -ne -1 -and [char]$peek -eq '*') {
            $inBlockComment = $true
            $next = [char]$sr.Read()
            $sb.Append($next) | Out-Null
            continue
        }
    }
    if ($ch -eq "'") { $inSingle = $true; continue }
    if ($ch -eq '"') { $inDouble = $true; continue }
    if ($ch -eq '`') { $inBacktick = $true; continue }

    # delimiter matching (only when not in quotes/comments)
    if ($delimiter.Length -gt 0) {
        if ($ch -eq $delimiter[$matchIndex]) {
            $matchIndex++
            if ($matchIndex -eq $delimiter.Length) {
                $len = $sb.Length
                $stmtLen = $len - $delimiter.Length
                $statementText = $sb.ToString(0, [int]$stmtLen)
                Write-Statement $statementText $delimiter
                # reset
                $sb = New-Object System.Text.StringBuilder
                $matchIndex = 0
            }
        } else {
            if ($ch -eq $delimiter[0]) { $matchIndex = 1 } else { $matchIndex = 0 }
        }
    }
}

# flush any remaining content
if ($sb.Length -gt 0) {
    $remaining = $sb.ToString()
    Write-Statement $remaining ''
}

$sr.Close(); $sw.Close()

Write-Host "Processing complete. Output: $OutputPath"

# Validation: count inserts per table in output
function Count-InsertsPerTable($path) {
    $r = [System.IO.File]::OpenText($path)
    $s = New-Object System.Text.StringBuilder
    $inS = $false; $inD = $false; $inB = $false; $inLC = $false; $inBC = $false
    $del = ';'; $mIdx = 0
    $ht = @{}
    while (($i = $r.Read()) -ne -1) {
        $c = [char]$i
        $s.Append($c) | Out-Null
        if ($inLC) { if ($c -eq "`n") { $inLC = $false } ; continue }
        if ($inBC) { $prev = if ($s.Length -ge 2) { [char]$s[$s.Length-2] } else { '\0' }; if ($prev -eq '*' -and $c -eq '/') { $inBC = $false } ; continue }
        if ($inS) { if ($c -eq "'") { $peek=$r.Peek(); if ($peek -ne -1 -and [char]$peek -eq "'") { $n=[char]$r.Read(); $s.Append($n)|Out-Null } else { $inS=$false } } ; continue }
        if ($inD) { if ($c -eq '"') { $peek=$r.Peek(); if ($peek -ne -1 -and [char]$peek -eq '"') { $n=[char]$r.Read(); $s.Append($n)|Out-Null } else { $inD=$false } } ; continue }
        if ($inB) { if ($c -eq '`') { $peek=$r.Peek(); if ($peek -ne -1 -and [char]$peek -eq '`') { $n=[char]$r.Read(); $s.Append($n)|Out-Null } else { $inB=$false } } ; continue }
        if ($c -eq '-') { $p=$r.Peek(); if ($p -ne -1 -and [char]$p -eq '-') { $inLC=$true; $n=[char]$r.Read(); $s.Append($n)|Out-Null; continue } }
        if ($c -eq '#') { $inLC=$true; continue }
        if ($c -eq '/') { $p=$r.Peek(); if ($p -ne -1 -and [char]$p -eq '*') { $inBC=$true; $n=[char]$r.Read(); $s.Append($n)|Out-Null; continue } }
        if ($c -eq "'") { $inS=$true; continue }
        if ($c -eq '"') { $inD=$true; continue }
        if ($c -eq '`') { $inB=$true; continue }
        if ($c -eq ';') {
            $st = $s.ToString()
            if ($st -match '(?si)^\s*INSERT') {
                if ($st -match '(?si)INSERT(?:\s+IGNORE)?\s+INTO\s+([^\s\(;]+)') {
                    $raw = $matches[1]; $tbl = Normalize-TableName $raw
                    if ($tbl) { if (-not $ht.ContainsKey($tbl)) { $ht[$tbl]=0 } ; $ht[$tbl] = $ht[$tbl] + 1 }
                }
            }
            $s = New-Object System.Text.StringBuilder
        }
    }
    if ($s.Length -gt 0) {
        $st = $s.ToString()
        if ($st -match '(?si)^\s*INSERT') {
            if ($st -match '(?si)INSERT(?:\s+IGNORE)?\s+INTO\s+([^\s\(;]+)') {
                $raw = $matches[1]; $tbl = Normalize-TableName $raw
                if ($tbl) { if (-not $ht.ContainsKey($tbl)) { $ht[$tbl]=0 } ; $ht[$tbl] = $ht[$tbl] + 1 }
            }
        }
    }
    $r.Close()
    return $ht
}

$countsOut = Count-InsertsPerTable $OutputPath
Write-Host "Insert counts per table in output:"
foreach ($k in $countsOut.Keys) { Write-Host "$k : $($countsOut[$k])" }
$exceeded = $false
foreach ($k in $countsOut.Keys) { if ($countsOut[$k] -gt $MaxPerTable) { $exceeded = $true } }
if (-not $exceeded) { Write-Host "SUCCESS: No table has more than $MaxPerTable INSERT statements." } else { Write-Host "WARNING: Some tables exceed the limit." }

# After processing and validation, write counts per table (rows kept) to JSON for verification
$reportPath = "C:\ashraf\rightchoice\public\insert_counts_final.json"
$reportObjs = @()
foreach ($k in $counts.Keys) { $reportObjs += [pscustomobject]@{ table = $k; rows = $counts[$k] } }
$reportObjs | ConvertTo-Json | Out-File -FilePath $reportPath -Encoding utf8
Write-Host "Wrote report to: $reportPath"
Write-Host "Tables processed: $($counts.Keys.Count)"
foreach ($k in $counts.Keys | Sort-Object) { Write-Host "$k : $($counts[$k])" }

# End of script
