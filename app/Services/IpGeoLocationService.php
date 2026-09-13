<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IpGeoLocationService
{
    /**
     * @param  array<int, string>  $ips
     * @return array<string, object>
     */
    public function lookupMany(array $ips): array
    {
        $unique = collect($ips)
            ->filter(fn ($ip) => is_string($ip) && $ip !== '' && $ip !== '-')
            ->unique()
            ->values();

        $result = [];
        $missing = [];

        foreach ($unique as $ip) {
            if ($this->isPrivateIp($ip)) {
                $result[$ip] = $this->makeLocation('خادم / شبكة داخلية', null, null, null);
                continue;
            }

            $cached = Cache::get($this->cacheKey($ip));
            if ($cached) {
                $result[$ip] = (object) $cached;
                continue;
            }

            $missing[] = $ip;
        }

        foreach (array_chunk($missing, 50) as $chunk) {
            foreach ($this->fetchBatch($chunk) as $ip => $location) {
                Cache::put($this->cacheKey($ip), (array) $location, now()->addDay());
                $result[$ip] = $location;
            }
        }

        return $result;
    }

    public function lookup(string $ip): object
    {
        return $this->lookupMany([$ip])[$ip] ?? $this->unknown();
    }

    /**
     * @param  array<int, string>  $ips
     * @return array<string, object>
     */
    private function fetchBatch(array $ips): array
    {
        $fallback = [];
        foreach ($ips as $ip) {
            $fallback[$ip] = $this->unknown();
        }

        try {
            $response = Http::timeout(3)
                ->acceptJson()
                ->post('http://ip-api.com/batch?fields=status,message,country,regionName,city,isp,query', $ips);

            if (!$response->successful()) {
                return $fallback;
            }

            foreach ($response->json() ?? [] as $row) {
                $ip = $row['query'] ?? null;
                if (!$ip) {
                    continue;
                }

                if (($row['status'] ?? '') !== 'success') {
                    $fallback[$ip] = $this->unknown();
                    continue;
                }

                $parts = array_filter([
                    $row['city'] ?? null,
                    $row['regionName'] ?? null,
                    $row['country'] ?? null,
                ]);

                $fallback[$ip] = $this->makeLocation(
                    $parts ? implode('، ', $parts) : 'غير معروف',
                    $row['city'] ?? null,
                    $row['country'] ?? null,
                    $row['isp'] ?? null
                );
            }
        } catch (\Throwable $e) {
            Log::warning('IP geo lookup failed.', ['message' => $e->getMessage()]);
        }

        return $fallback;
    }

    private function isPrivateIp(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }

    private function cacheKey(string $ip): string
    {
        return 'geoip:' . $ip;
    }

    private function unknown(): object
    {
        return $this->makeLocation('غير معروف', null, null, null);
    }

    private function makeLocation(?string $label, ?string $city, ?string $country, ?string $isp): object
    {
        return (object) [
            'label'   => $label ?: 'غير معروف',
            'city'    => $city,
            'country' => $country,
            'isp'     => $isp,
        ];
    }
}
