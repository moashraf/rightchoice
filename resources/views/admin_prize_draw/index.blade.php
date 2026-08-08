@extends('layouts.admin')

@section('title', 'سحب جائزة المشتركين')

@section('content')
    <div class="container-fluid rc-draw-page" dir="rtl">
        <div class="rc-draw-hero">
            <div>
                <span class="rc-draw-eyebrow"><i class="fas fa-gift"></i> سحب الجوائز</span>
                <h1>عجلة اختيار فائز من المشتركين</h1>
                <p>السحب متاح فقط للمستخدمين أصحاب <strong>الباقات المدفوعة والمفعلة</strong>، والاختيار النهائي يتم من السيرفر بشكل عشوائي.</p>
            </div>
            <div class="rc-draw-counter">
                <small>المؤهلون للسحب</small>
                <strong>{{ $participants->count() }}</strong>
                <span>مشترك</span>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 mb-4">
                <div class="card rc-draw-card rc-draw-wheel-card">
                    <div class="card-body">
                        <div class="rc-wheel-stage">
                            <div class="rc-wheel-pointer" aria-hidden="true">
                                <span></span>
                            </div>
                            <div class="rc-wheel-ring">
                                <canvas id="subscriberPrizeWheel" width="720" height="720" aria-label="عجلة المشتركين"></canvas>
                                <div class="rc-wheel-center">
                                    <i class="fas fa-home"></i>
                                    <span>Right<br>Choice</span>
                                </div>
                            </div>
                        </div>

                        <div class="rc-draw-actions">
                            <button
                                type="button"
                                id="startPrizeDraw"
                                class="btn rc-spin-button"
                                {{ $participants->isEmpty() ? 'disabled' : '' }}
                            >
                                <i class="fas fa-sync-alt"></i>
                                <span>ابدأ السحب</span>
                            </button>
                            <p id="drawStatus" class="rc-draw-status">
                                {{ $participants->isEmpty()
                                    ? 'لا يوجد مشتركون مؤهلون للسحب حالياً.'
                                    : 'اضغط على الزر لبدء السحب العشوائي.' }}
                            </p>
                        </div>

                        <div id="winnerCard" class="rc-winner-card" hidden>
                            <div class="rc-winner-confetti" aria-hidden="true">🎉</div>
                            <div class="rc-winner-icon"><i class="fas fa-trophy"></i></div>
                            <div>
                                <span>الفائز بالجائزة</span>
                                <h2 id="winnerName">—</h2>
                                <p id="winnerPackage">—</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 mb-4">
                <div class="card rc-draw-card rc-participants-card">
                    <div class="card-header">
                        <div>
                            <span>قائمة السحب</span>
                            <h3>المشتركون المؤهلون</h3>
                        </div>
                        <span class="badge badge-success">{{ $participants->count() }}</span>
                    </div>
                    <div class="card-body p-0">
                        @if($participants->isEmpty())
                            <div class="rc-participants-empty">
                                <i class="fas fa-user-clock"></i>
                                <strong>لا يوجد مشاركون</strong>
                                <p>يظهر هنا المستخدمون أصحاب الباقات المدفوعة المفعلة.</p>
                            </div>
                        @else
                            <div class="rc-participants-list">
                                @foreach($participants as $participant)
                                    <div class="rc-participant-item" data-participant-id="{{ $participant['id'] }}">
                                        <div class="rc-participant-avatar">
                                            {{ mb_strtoupper(mb_substr($participant['name'], 0, 1)) }}
                                        </div>
                                        <div class="rc-participant-copy">
                                            <strong>{{ $participant['name'] }}</strong>
                                            <span>{{ $participant['package'] ?: 'باقة مدفوعة' }}</span>
                                        </div>
                                        <small>#{{ $participant['id'] }}</small>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="card-footer rc-draw-rules">
                        <div><i class="fas fa-check-circle"></i> باقة مدفوعة</div>
                        <div><i class="fas fa-check-circle"></i> اشتراك مفعل</div>
                        <div><i class="fas fa-check-circle"></i> فرصة واحدة لكل مستخدم</div>
                    </div>
                </div>

                <div class="rc-draw-security-note">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <strong>السحب لا يتم من المتصفح</strong>
                        <p>السيرفر يحدد الفائز أولاً باستخدام اختيار عشوائي آمن، وبعدها العجلة تتحرك بصرياً لاسم الفائز.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_css')
<style>
    .rc-draw-page {
        --draw-navy: #073F73;
        --draw-blue: #0B5F9F;
        --draw-green: #18C7A1;
        --draw-orange: #F47D35;
        --draw-ink: #16364f;
        --draw-muted: #718698;
        padding: 24px 18px 40px;
        color: var(--draw-ink);
    }

    .rc-draw-page,
    .rc-draw-page * { box-sizing: border-box; }

    .rc-draw-hero {
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 24px;
        padding: 28px 32px;
        border-radius: 24px;
        color: #fff;
        background:
            radial-gradient(circle at 12% 20%, rgba(24,199,161,.23), transparent 30%),
            linear-gradient(135deg, #052f51, var(--draw-navy) 55%, var(--draw-blue));
        box-shadow: 0 20px 45px rgba(7,63,115,.17);
    }

    .rc-draw-hero::after {
        content: '';
        position: absolute;
        width: 260px;
        height: 260px;
        left: -120px;
        bottom: -180px;
        border-radius: 50%;
        background: rgba(244,125,53,.24);
    }

    .rc-draw-hero > * { position: relative; z-index: 1; }
    .rc-draw-eyebrow { display: inline-flex; align-items: center; gap: 7px; margin-bottom: 8px; color: #8cebd4; font-size: 12px; font-weight: 800; }
    .rc-draw-hero h1 { margin: 0 0 8px; color: #fff; font-size: 28px; font-weight: 900; }
    .rc-draw-hero p { max-width: 760px; margin: 0; color: rgba(255,255,255,.78); line-height: 1.8; font-size: 13px; }
    .rc-draw-hero p strong { color: #fff; }

    .rc-draw-counter {
        min-width: 145px;
        padding: 15px 18px;
        border-radius: 19px;
        text-align: center;
        background: rgba(255,255,255,.1);
        border: 1px solid rgba(255,255,255,.16);
        backdrop-filter: blur(8px);
    }
    .rc-draw-counter small, .rc-draw-counter span { display: block; color: rgba(255,255,255,.73); font-weight: 700; }
    .rc-draw-counter strong { display: block; margin: 2px 0; color: #fff; font-size: 34px; line-height: 1.1; font-weight: 900; }

    .rc-draw-card { border: 0; border-radius: 24px; box-shadow: 0 18px 45px rgba(22,54,79,.08); overflow: hidden; }
    .rc-draw-wheel-card .card-body { padding: 28px; }

    .rc-wheel-stage {
        position: relative;
        width: min(100%, 630px);
        margin: 0 auto;
        padding: 24px;
    }

    .rc-wheel-ring {
        position: relative;
        width: 100%;
        aspect-ratio: 1 / 1;
        padding: 10px;
        border-radius: 50%;
        background: linear-gradient(145deg, #fff, #dfe8ee);
        box-shadow:
            0 25px 55px rgba(7,63,115,.17),
            inset 0 0 0 4px rgba(7,63,115,.08);
    }

    #subscriberPrizeWheel {
        display: block;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        transform: rotate(0deg);
        will-change: transform;
        filter: drop-shadow(0 8px 16px rgba(0,0,0,.12));
    }

    .rc-wheel-center {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 94px;
        height: 94px;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        color: #fff;
        text-align: center;
        background: linear-gradient(135deg, var(--draw-navy), var(--draw-blue));
        border: 7px solid #fff;
        box-shadow: 0 10px 24px rgba(4,44,78,.28);
        pointer-events: none;
    }
    .rc-wheel-center i { color: #7ce5ca; font-size: 18px; }
    .rc-wheel-center span { font-size: 11px; line-height: 1.05; font-weight: 900; }

    .rc-wheel-pointer {
        position: absolute;
        z-index: 8;
        top: 3px;
        left: 50%;
        width: 56px;
        height: 68px;
        transform: translateX(-50%);
        display: flex;
        justify-content: center;
        pointer-events: none;
        filter: drop-shadow(0 8px 8px rgba(0,0,0,.18));
    }
    .rc-wheel-pointer::before {
        content: '';
        position: absolute;
        top: 0;
        width: 37px;
        height: 37px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--draw-orange), #de5429);
        border: 5px solid #fff;
    }
    .rc-wheel-pointer span {
        position: absolute;
        top: 27px;
        width: 0;
        height: 0;
        border-left: 17px solid transparent;
        border-right: 17px solid transparent;
        border-top: 31px solid var(--draw-orange);
    }

    .rc-draw-actions { margin-top: 10px; text-align: center; }
    .rc-spin-button {
        min-width: 220px;
        min-height: 54px;
        border: 0;
        border-radius: 17px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: #fff !important;
        background: linear-gradient(135deg, var(--draw-orange), #df5529);
        box-shadow: 0 14px 30px rgba(244,125,53,.28);
        font-size: 15px;
        font-weight: 900;
        transition: transform .2s ease, box-shadow .2s ease, opacity .2s ease;
    }
    .rc-spin-button:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 18px 35px rgba(244,125,53,.36); }
    .rc-spin-button:disabled { opacity: .55; cursor: not-allowed; }
    .rc-spin-button.is-spinning i { animation: rcAdminSpin .9s linear infinite; }
    @keyframes rcAdminSpin { to { transform: rotate(360deg); } }

    .rc-draw-status { min-height: 20px; margin: 11px 0 0; color: var(--draw-muted); font-size: 12px; font-weight: 600; }

    .rc-winner-card {
        position: relative;
        overflow: hidden;
        max-width: 590px;
        margin: 24px auto 0;
        padding: 19px 22px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        text-align: right;
        background: linear-gradient(135deg, rgba(24,199,161,.13), rgba(11,95,159,.08));
        border: 1px solid rgba(24,199,161,.32);
        animation: rcWinnerEnter .45s ease-out both;
    }
    @keyframes rcWinnerEnter { from { opacity: 0; transform: translateY(12px) scale(.98); } to { opacity: 1; transform: none; } }
    .rc-winner-confetti { position: absolute; left: 16px; top: 10px; font-size: 32px; opacity: .9; }
    .rc-winner-icon { width: 56px; height: 56px; flex: 0 0 56px; border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; color: #fff; background: linear-gradient(135deg, #f6b629, var(--draw-orange)); font-size: 24px; box-shadow: 0 10px 22px rgba(244,125,53,.23); }
    .rc-winner-card span { color: #168a70; font-size: 11px; font-weight: 900; }
    .rc-winner-card h2 { margin: 2px 0 3px; color: var(--draw-navy); font-size: 22px; font-weight: 900; }
    .rc-winner-card p { margin: 0; color: var(--draw-muted); font-size: 12px; font-weight: 700; }

    .rc-participants-card .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 22px;
        border-bottom: 1px solid #edf2f5;
        background: #fff;
    }
    .rc-participants-card .card-header span:not(.badge) { color: var(--draw-orange); font-size: 10px; font-weight: 900; }
    .rc-participants-card .card-header h3 { margin: 2px 0 0; color: var(--draw-navy); font-size: 18px; font-weight: 900; }
    .rc-participants-card .card-header .badge { min-width: 37px; padding: 7px 9px; border-radius: 999px; font-size: 12px; }

    .rc-participants-list { max-height: 510px; overflow-y: auto; }
    .rc-participant-item { display: flex; align-items: center; gap: 11px; padding: 13px 18px; border-bottom: 1px solid #f0f3f5; transition: background .18s ease; }
    .rc-participant-item:hover, .rc-participant-item.is-winner { background: rgba(24,199,161,.08); }
    .rc-participant-item.is-winner { box-shadow: inset -4px 0 0 var(--draw-green); }
    .rc-participant-avatar { width: 38px; height: 38px; flex: 0 0 38px; border-radius: 13px; display: inline-flex; align-items: center; justify-content: center; color: #fff; background: linear-gradient(135deg, var(--draw-blue), var(--draw-navy)); font-size: 14px; font-weight: 900; }
    .rc-participant-copy { min-width: 0; flex: 1; }
    .rc-participant-copy strong, .rc-participant-copy span { display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .rc-participant-copy strong { color: var(--draw-ink); font-size: 13px; font-weight: 850; }
    .rc-participant-copy span { margin-top: 2px; color: var(--draw-muted); font-size: 10px; font-weight: 600; }
    .rc-participant-item > small { color: #a0adb7; font-size: 9px; }

    .rc-draw-rules { display: grid; gap: 7px; padding: 15px 20px; color: #4d6679; background: #f8fafb; font-size: 11px; font-weight: 700; }
    .rc-draw-rules i { margin-left: 5px; color: var(--draw-green); }

    .rc-participants-empty { padding: 45px 25px; text-align: center; }
    .rc-participants-empty i { display: block; margin-bottom: 13px; color: #c0cbd3; font-size: 34px; }
    .rc-participants-empty strong { display: block; margin-bottom: 5px; color: var(--draw-ink); font-size: 15px; }
    .rc-participants-empty p { margin: 0; color: var(--draw-muted); font-size: 11px; }

    .rc-draw-security-note { display: flex; align-items: flex-start; gap: 12px; margin-top: 16px; padding: 17px 18px; border-radius: 18px; color: #315169; background: #eaf4fb; border: 1px solid #cfe5f4; }
    .rc-draw-security-note > i { margin-top: 3px; color: var(--draw-blue); font-size: 18px; }
    .rc-draw-security-note strong { display: block; margin-bottom: 4px; color: var(--draw-navy); font-size: 12px; }
    .rc-draw-security-note p { margin: 0; color: #668095; line-height: 1.65; font-size: 10px; }

    @media (max-width: 767.98px) {
        .rc-draw-page { padding: 16px 5px 30px; }
        .rc-draw-hero { align-items: flex-start; flex-direction: column; padding: 23px; border-radius: 19px; }
        .rc-draw-hero h1 { font-size: 23px; }
        .rc-draw-counter { width: 100%; }
        .rc-draw-wheel-card .card-body { padding: 15px; }
        .rc-wheel-stage { padding: 18px 4px 5px; }
        .rc-wheel-center { width: 70px; height: 70px; border-width: 5px; }
        .rc-wheel-center i { display: none; }
        .rc-wheel-pointer { top: -3px; transform: translateX(-50%) scale(.82); }
        .rc-spin-button { width: 100%; min-width: 0; }
    }

    @media (prefers-reduced-motion: reduce) {
        .rc-draw-page * { animation-duration: .01ms !important; animation-iteration-count: 1 !important; }
    }
</style>
@endpush

@push('page_scripts')
<script>
    (function () {
        var participants = @json($participants->values());
        var canvas = document.getElementById('subscriberPrizeWheel');
        var spinButton = document.getElementById('startPrizeDraw');
        var statusNode = document.getElementById('drawStatus');
        var winnerCard = document.getElementById('winnerCard');
        var winnerName = document.getElementById('winnerName');
        var winnerPackage = document.getElementById('winnerPackage');
        var csrfToken = document.querySelector('meta[name="csrf-token"]');
        var currentRotation = 0;
        var spinning = false;
        var palette = ['#0B5F9F', '#18C7A1', '#F47D35', '#073F73', '#4B8FC2', '#13A988', '#E86635', '#275A7D'];

        if (!canvas || !canvas.getContext) {
            if (statusNode) statusNode.textContent = 'المتصفح لا يدعم رسم العجلة.';
            if (spinButton) spinButton.disabled = true;
            return;
        }

        var ctx = canvas.getContext('2d');
        var size = canvas.width;
        var center = size / 2;
        var radius = center - 18;

        function drawEmptyWheel() {
            ctx.clearRect(0, 0, size, size);
            ctx.beginPath();
            ctx.arc(center, center, radius, 0, Math.PI * 2);
            ctx.fillStyle = '#eef3f6';
            ctx.fill();
            ctx.strokeStyle = '#d5e0e7';
            ctx.lineWidth = 8;
            ctx.stroke();
            ctx.fillStyle = '#7d91a0';
            ctx.font = '700 28px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('لا يوجد مشتركون', center, center - 70);
        }

        function fitLabel(text, maxLength) {
            if (!text) return 'مستخدم';
            text = String(text).trim();
            return text.length > maxLength ? text.slice(0, maxLength - 1) + '…' : text;
        }

        function drawWheel() {
            if (!participants.length) {
                drawEmptyWheel();
                return;
            }

            ctx.clearRect(0, 0, size, size);
            var arc = (Math.PI * 2) / participants.length;
            var compactLabels = participants.length > 24;

            participants.forEach(function (participant, index) {
                var start = -Math.PI / 2 + index * arc;
                var end = start + arc;

                ctx.beginPath();
                ctx.moveTo(center, center);
                ctx.arc(center, center, radius, start, end);
                ctx.closePath();
                ctx.fillStyle = palette[index % palette.length];
                ctx.fill();
                ctx.strokeStyle = 'rgba(255,255,255,.82)';
                ctx.lineWidth = participants.length > 35 ? 1 : 2.4;
                ctx.stroke();

                if (compactLabels && index % Math.ceil(participants.length / 24) !== 0) {
                    return;
                }

                ctx.save();
                ctx.translate(center, center);
                ctx.rotate(start + arc / 2);
                ctx.textAlign = 'right';
                ctx.textBaseline = 'middle';
                ctx.fillStyle = '#ffffff';
                ctx.font = participants.length > 18 ? '700 16px Arial' : '800 19px Arial';
                ctx.shadowColor = 'rgba(0,0,0,.22)';
                ctx.shadowBlur = 3;
                ctx.fillText(fitLabel(participant.name, participants.length > 18 ? 11 : 15), radius - 34, 0);
                ctx.restore();
            });

            ctx.beginPath();
            ctx.arc(center, center, radius, 0, Math.PI * 2);
            ctx.strokeStyle = '#ffffff';
            ctx.lineWidth = 9;
            ctx.stroke();
        }

        function highlightWinner(userId) {
            document.querySelectorAll('.rc-participant-item').forEach(function (item) {
                item.classList.toggle('is-winner', Number(item.getAttribute('data-participant-id')) === Number(userId));
            });

            var winnerRow = document.querySelector('.rc-participant-item.is-winner');
            if (winnerRow && winnerRow.scrollIntoView) {
                winnerRow.scrollIntoView({behavior: 'smooth', block: 'nearest'});
            }
        }

        function showWinner(winner) {
            winnerName.textContent = winner.name || ('مستخدم #' + winner.id);
            winnerPackage.textContent = 'الباقة: ' + (winner.package || 'باقة مدفوعة');
            winnerCard.hidden = false;
            highlightWinner(winner.id);
            statusNode.textContent = 'تم اختيار الفائز بنجاح.';
        }

        function animateToWinner(winner) {
            var winnerIndex = participants.findIndex(function (participant) {
                return Number(participant.id) === Number(winner.id);
            });

            if (winnerIndex < 0) {
                statusNode.textContent = 'تم اختيار فائز، لكن قائمة العجلة تحتاج إلى تحديث. أعد تحميل الصفحة.';
                spinning = false;
                spinButton.disabled = false;
                spinButton.classList.remove('is-spinning');
                return;
            }

            var segmentDegrees = 360 / participants.length;
            var winnerCenterDegrees = (winnerIndex + 0.5) * segmentDegrees;
            var desiredRotation = (360 - (winnerCenterDegrees % 360)) % 360;
            var normalizedCurrent = ((currentRotation % 360) + 360) % 360;
            var alignmentDelta = (desiredRotation - normalizedCurrent + 360) % 360;
            var extraTurns = 7 * 360;
            var targetRotation = currentRotation + extraTurns + alignmentDelta;

            canvas.style.transition = 'transform 5.6s cubic-bezier(.12,.72,.08,1)';

            window.requestAnimationFrame(function () {
                canvas.style.transform = 'rotate(' + targetRotation + 'deg)';
            });

            var finished = false;
            function finishAnimation() {
                if (finished) return;
                finished = true;
                currentRotation = targetRotation;
                spinning = false;
                spinButton.disabled = false;
                spinButton.classList.remove('is-spinning');
                showWinner(winner);
            }

            canvas.addEventListener('transitionend', finishAnimation, {once: true});
            window.setTimeout(finishAnimation, 6000);
        }

        function startDraw() {
            if (spinning || !participants.length) return;

            spinning = true;
            spinButton.disabled = true;
            spinButton.classList.add('is-spinning');
            winnerCard.hidden = true;
            highlightWinner(null);
            statusNode.textContent = 'جاري اختيار الفائز من المشتركين المؤهلين...';

            fetch(@json(route('sitemanagement.prize-draw.draw')), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken ? csrfToken.getAttribute('content') : ''
                },
                credentials: 'same-origin',
                body: JSON.stringify({})
            })
            .then(function (response) {
                return response.json().then(function (data) {
                    if (!response.ok) {
                        throw new Error(data.message || 'تعذر تنفيذ السحب.');
                    }
                    return data;
                });
            })
            .then(function (data) {
                statusNode.textContent = 'تم تحديد الفائز... العجلة بتدور الآن.';
                animateToWinner(data.winner);
            })
            .catch(function (error) {
                spinning = false;
                spinButton.disabled = false;
                spinButton.classList.remove('is-spinning');
                statusNode.textContent = error.message || 'حدث خطأ أثناء السحب.';
            });
        }

        drawWheel();

        if (spinButton) {
            spinButton.addEventListener('click', startDraw);
        }
    })();
</script>
@endpush
