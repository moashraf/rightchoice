<x-layout>
    {{-- ============================================================
         صياد العقارات - Property Hunter Game
         Embedded inside the website layout
         ============================================================ --}}

    <style>
        /* ===== GAME SCOPED STYLES ===== */
        /* All prefixed with .game-wrapper to avoid layout conflicts */

        .game-wrapper {
            --g-primary: #2563eb;
            --g-primary-dark: #1d4ed8;
            --g-success: #10b981;
            --g-danger: #ef4444;
            --g-warning: #f59e0b;
            --g-bg: #0f172a;
            --g-bg-light: #1e293b;
            --g-card: #334155;
            --g-text: #f1f5f9;
            --g-text-muted: #94a3b8;
            --g-radius: 14px;

            position: relative;
            width: 100%;
            min-height: 85vh;
            background: var(--g-bg);
            color: var(--g-text);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            user-select: none;
            -webkit-user-select: none;
            overflow: hidden;
            border-radius: 0;
        }

        /* --- Screens --- */
        .game-wrapper .g-screen {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: opacity 0.4s ease;
        }

        .game-wrapper .g-screen.g-hidden {
            display: none;
            opacity: 0;
        }

        /* --- Buttons --- */
        .game-wrapper .g-btn {
            display: inline-block;
            padding: 14px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            font-family: inherit;
            text-decoration: none;
        }

        .game-wrapper .g-btn:active {
            transform: scale(0.95);
        }

        .game-wrapper .g-btn-primary {
            background: linear-gradient(135deg, var(--g-primary), #7c3aed);
            color: #fff;
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.4);
        }

        .game-wrapper .g-btn-primary:hover {
            box-shadow: 0 6px 28px rgba(37, 99, 235, 0.55);
            transform: translateY(-2px);
            color: #fff;
            text-decoration: none;
        }

        .game-wrapper .g-btn-secondary {
            background: var(--g-bg-light);
            color: var(--g-text);
            margin-top: 10px;
            border: 1px solid var(--g-card);
        }

        .game-wrapper .g-btn-secondary:hover {
            background: var(--g-card);
            color: var(--g-text);
            text-decoration: none;
        }


        /* ===== START SCREEN ===== */
        .game-wrapper .g-start-content {
            text-align: center;
            padding: 30px 24px;
            max-width: 440px;
            width: 90%;
        }

        .game-wrapper .g-logo-icon {
            font-size: 4rem;
            margin-bottom: 10px;
            animation: gFloat 2.5s ease-in-out infinite;
        }

        @keyframes gFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .game-wrapper .g-start-content h1 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 2px;
            background: linear-gradient(135deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .game-wrapper .g-subtitle {
            font-size: 1rem;
            color: var(--g-text-muted);
            margin-bottom: 16px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .game-wrapper .g-description {
            font-size: 0.95rem;
            color: var(--g-text-muted);
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .game-wrapper .g-how-to-play {
            background: var(--g-bg-light);
            border-radius: var(--g-radius);
            padding: 16px;
            margin-bottom: 24px;
            border: 1px solid var(--g-card);
        }

        .game-wrapper .g-how-to-play h3 {
            font-size: 0.9rem;
            color: var(--g-text-muted);
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .game-wrapper .g-rules {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .game-wrapper .g-rule {
            padding: 8px 6px;
            border-radius: 10px;
            font-size: 0.82rem;
            text-align: center;
            line-height: 1.5;
        }

        .game-wrapper .g-rule.good {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .game-wrapper .g-rule.bad {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            grid-column: span 3;
        }


        /* ===== HUD ===== */
        .game-wrapper .g-hud {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 12px 20px;
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 50;
            border-bottom: 1px solid var(--g-card);
        }

        .game-wrapper .g-hud-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 70px;
        }

        .game-wrapper .g-hud-label {
            font-size: 0.7rem;
            color: var(--g-text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .game-wrapper .g-hud-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--g-text);
            transition: transform 0.15s ease;
        }

        .game-wrapper .g-hud-value.pop {
            transform: scale(1.3);
            color: var(--g-success);
        }

        .game-wrapper .g-hud-value.pop-bad {
            transform: scale(1.3);
            color: var(--g-danger);
        }

        .game-wrapper .g-hud-value.timer-warn {
            color: var(--g-danger);
            animation: gPulse 0.6s ease infinite;
        }

        @keyframes gPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.15); }
        }

        .game-wrapper .g-combo-text {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--g-warning);
            text-shadow: 0 0 12px rgba(245, 158, 11, 0.5);
        }

        /* Level banner */
        .game-wrapper .g-level-banner {
            position: absolute;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--g-primary), #7c3aed);
            color: #fff;
            padding: 10px 30px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 700;
            z-index: 55;
            box-shadow: 0 4px 24px rgba(37, 99, 235, 0.4);
            animation: gBannerIn 0.4s ease;
        }

        .game-wrapper .g-level-banner.g-hidden {
            display: none;
        }

        @keyframes gBannerIn {
            from { opacity: 0; transform: translateX(-50%) translateY(-20px) scale(0.8); }
            to { opacity: 1; transform: translateX(-50%) translateY(0) scale(1); }
        }


        /* ===== GAME BOARD ===== */
        .game-wrapper .g-board {
            position: absolute;
            top: 70px;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            background:
                radial-gradient(circle at 20% 50%, rgba(37, 99, 235, 0.05), transparent 50%),
                radial-gradient(circle at 80% 30%, rgba(124, 58, 237, 0.05), transparent 50%),
                var(--g-bg);
        }

        .game-wrapper .g-board::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(51, 65, 85, 0.15) 1px, transparent 1px),
                linear-gradient(90deg, rgba(51, 65, 85, 0.15) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }


        /* ===== PROPERTY ITEMS ===== */
        .game-wrapper .g-property {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.1s ease;
            animation: gPropSpawn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 20;
            -webkit-tap-highlight-color: transparent;
        }

        @keyframes gPropSpawn {
            from { opacity: 0; transform: scale(0.3); }
            to { opacity: 1; transform: scale(1); }
        }

        .game-wrapper .g-property:active {
            transform: scale(0.85);
        }

        .game-wrapper .g-property-emoji {
            font-size: 2.8rem;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
            transition: filter 0.15s ease;
        }

        .game-wrapper .g-property-label {
            font-size: 0.7rem;
            color: var(--g-text-muted);
            margin-top: 2px;
            font-weight: 600;
            pointer-events: none;
            text-shadow: 0 1px 4px rgba(0,0,0,0.8);
            white-space: nowrap;
        }

        .game-wrapper .g-property-points {
            font-size: 0.75rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 10px;
            margin-top: 2px;
            pointer-events: none;
        }

        .game-wrapper .g-property-points.good {
            background: rgba(16, 185, 129, 0.2);
            color: var(--g-success);
        }

        .game-wrapper .g-property-points.bad {
            background: rgba(239, 68, 68, 0.2);
            color: var(--g-danger);
        }

        .game-wrapper .g-property.collected {
            animation: gCollected 0.4s ease forwards;
            pointer-events: none;
        }

        @keyframes gCollected {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.3); }
            100% { transform: scale(0); opacity: 0; }
        }

        .game-wrapper .g-property.missed {
            animation: gMissed 0.3s ease forwards;
            pointer-events: none;
        }

        @keyframes gMissed {
            to { opacity: 0; transform: translateY(30px) scale(0.5); }
        }

        .game-wrapper .g-property.bad-clicked {
            animation: gBadClick 0.4s ease forwards;
            pointer-events: none;
        }

        @keyframes gBadClick {
            0% { transform: scale(1); }
            25% { transform: rotate(-10deg) scale(1.1); }
            50% { transform: rotate(10deg) scale(1.1); }
            100% { transform: scale(0); opacity: 0; }
        }

        /* Floating score */
        .game-wrapper .g-float-score {
            position: absolute;
            font-size: 1.2rem;
            font-weight: 800;
            pointer-events: none;
            z-index: 30;
            animation: gFloatUp 0.8s ease forwards;
        }

        .game-wrapper .g-float-score.positive {
            color: var(--g-success);
            text-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
        }

        .game-wrapper .g-float-score.negative {
            color: var(--g-danger);
            text-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
        }

        @keyframes gFloatUp {
            0% { opacity: 1; transform: translateY(0) scale(1); }
            100% { opacity: 0; transform: translateY(-60px) scale(1.4); }
        }


        /* ===== END SCREEN ===== */
        .game-wrapper .g-end-content {
            text-align: center;
            padding: 30px 24px;
            max-width: 400px;
            width: 90%;
            animation: gEndIn 0.5s ease;
        }

        @keyframes gEndIn {
            from { opacity: 0; transform: scale(0.85); }
            to { opacity: 1; transform: scale(1); }
        }

        .game-wrapper .g-end-icon {
            font-size: 4rem;
            margin-bottom: 12px;
        }

        .game-wrapper .g-end-content h2 {
            font-size: 1.8rem;
            margin-bottom: 4px;
        }

        .game-wrapper .g-end-subtitle {
            color: var(--g-text-muted);
            margin-bottom: 24px;
        }

        .game-wrapper .g-final-stats {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .game-wrapper .g-stat-box {
            background: var(--g-bg-light);
            border: 1px solid var(--g-card);
            border-radius: var(--g-radius);
            padding: 16px 20px;
            min-width: 90px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .game-wrapper .g-stat-num {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--g-primary);
        }

        .game-wrapper .g-stat-label {
            font-size: 0.75rem;
            color: var(--g-text-muted);
            margin-top: 4px;
        }

        .game-wrapper .g-end-rank {
            background: var(--g-bg-light);
            border: 1px solid var(--g-card);
            border-radius: 50px;
            padding: 10px 20px;
            margin-bottom: 24px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .game-wrapper .g-rank-badge {
            font-size: 1.4rem;
        }

        .game-wrapper .g-rank-text {
            font-size: 0.9rem;
            font-weight: 600;
        }


        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .game-wrapper .g-start-content h1 {
                font-size: 1.7rem;
            }

            .game-wrapper .g-logo-icon {
                font-size: 3rem;
            }

            .game-wrapper .g-rules {
                grid-template-columns: repeat(2, 1fr);
            }

            .game-wrapper .g-rule.bad {
                grid-column: span 2;
            }

            .game-wrapper .g-hud {
                gap: 12px;
                padding: 10px 12px;
            }

            .game-wrapper .g-hud-value {
                font-size: 1.2rem;
            }

            .game-wrapper .g-hud-label {
                font-size: 0.6rem;
            }

            .game-wrapper .g-property-emoji {
                font-size: 2.2rem;
            }

            .game-wrapper .g-btn {
                padding: 12px 32px;
                font-size: 1rem;
            }

            .game-wrapper .g-stat-box {
                padding: 12px 14px;
                min-width: 75px;
            }

            .game-wrapper .g-stat-num {
                font-size: 1.4rem;
            }

            .game-wrapper .g-final-stats {
                gap: 8px;
            }
        }
    </style>

    {{-- ============================================================
         Game Container
         ============================================================ --}}
    <div class="game-wrapper" id="gameWrapper">

        {{-- ===== Start Screen ===== --}}
        <div id="startScreen" class="g-screen">
            <div class="g-start-content">
                <div class="g-logo-icon">🏠</div>
                <h1>{{ App::isLocale('en') ? 'Property Hunter' : 'صياد العقارات' }}</h1>
                <p class="g-subtitle">{{ App::isLocale('en') ? 'Catch the best properties!' : 'Property Hunter' }}</p>
                <p class="g-description">
                    {{ App::isLocale('en')
                        ? 'Click on good properties before they disappear! Avoid broken buildings!'
                        : 'اضغط على العقارات الجيدة قبل ما تختفي! تجنب المباني المتهالكة!' }}
                </p>

                <div class="g-how-to-play">
                    <h3>{{ App::isLocale('en') ? 'How to Play' : 'طريقة اللعب' }}</h3>
                    <div class="g-rules">
                        <div class="g-rule good">🏢 {{ App::isLocale('en') ? 'Apartment' : 'شقة' }} = <strong>+10</strong></div>
                        <div class="g-rule good">🏠 {{ App::isLocale('en') ? 'House' : 'بيت' }} = <strong>+15</strong></div>
                        <div class="g-rule good">🏡 {{ App::isLocale('en') ? 'Villa' : 'فيلا' }} = <strong>+25</strong></div>
                        <div class="g-rule good">🏗️ {{ App::isLocale('en') ? 'Tower' : 'برج' }} = <strong>+30</strong></div>
                        <div class="g-rule good">🏰 {{ App::isLocale('en') ? 'Palace' : 'قصر' }} = <strong>+50</strong></div>
                        <div class="g-rule bad">🏚️ {{ App::isLocale('en') ? 'Ruined' : 'متهالك' }} = <strong>-20</strong></div>
                    </div>
                </div>

                <button class="g-btn g-btn-primary" onclick="PropertyGame.start()">
                    {{ App::isLocale('en') ? 'Start Game 🎮' : 'ابدأ اللعب 🎮' }}
                </button>
            </div>
        </div>

        {{-- ===== Game Screen ===== --}}
        <div id="gameScreen" class="g-screen g-hidden">
            <div class="g-hud">
                <div class="g-hud-item">
                    <span class="g-hud-label">{{ App::isLocale('en') ? 'Score' : 'النقاط' }}</span>
                    <span id="gScore" class="g-hud-value">0</span>
                </div>
                <div class="g-hud-item">
                    <span class="g-hud-label">{{ App::isLocale('en') ? 'Time' : 'الوقت' }}</span>
                    <span id="gTimer" class="g-hud-value">60</span>
                </div>
                <div class="g-hud-item">
                    <span class="g-hud-label">{{ App::isLocale('en') ? 'Level' : 'المستوى' }}</span>
                    <span id="gLevel" class="g-hud-value">1</span>
                </div>
                <div class="g-hud-item g-hidden" id="gComboDisplay">
                    <span class="g-combo-text" id="gComboText">x2</span>
                </div>
            </div>

            <div id="gLevelBanner" class="g-level-banner g-hidden">
                <span>{{ App::isLocale('en') ? 'Level' : 'المستوى' }} <span id="gLevelBannerNum">2</span> 🎉</span>
            </div>

            <div id="gBoard" class="g-board"></div>
        </div>

        {{-- ===== Game Over Screen ===== --}}
        <div id="endScreen" class="g-screen g-hidden">
            <div class="g-end-content">
                <div class="g-end-icon" id="gEndIcon">🏆</div>
                <h2 id="gEndTitle">{{ App::isLocale('en') ? 'Game Over!' : 'انتهت اللعبة!' }}</h2>
                <p class="g-end-subtitle" id="gEndSubtitle">{{ App::isLocale('en') ? 'Well done!' : 'أحسنت!' }}</p>

                <div class="g-final-stats">
                    <div class="g-stat-box">
                        <span class="g-stat-num" id="gFinalScore">0</span>
                        <span class="g-stat-label">{{ App::isLocale('en') ? 'Score' : 'النقاط' }}</span>
                    </div>
                    <div class="g-stat-box">
                        <span class="g-stat-num" id="gFinalLevel">1</span>
                        <span class="g-stat-label">{{ App::isLocale('en') ? 'Level' : 'المستوى' }}</span>
                    </div>
                    <div class="g-stat-box">
                        <span class="g-stat-num" id="gFinalCollected">0</span>
                        <span class="g-stat-label">{{ App::isLocale('en') ? 'Properties' : 'عقارات' }}</span>
                    </div>
                </div>

                <div class="g-end-rank" id="gEndRank">
                    <span class="g-rank-badge">🥇</span>
                    <span class="g-rank-text">{{ App::isLocale('en') ? 'Pro Broker!' : 'وسيط عقاري محترف!' }}</span>
                </div>

                <button class="g-btn g-btn-primary" onclick="PropertyGame.start()">
                    {{ App::isLocale('en') ? 'Play Again 🔄' : 'العب تاني 🔄' }}
                </button>
                <br>
                <button class="g-btn g-btn-secondary" onclick="PropertyGame.goHome()">
                    {{ App::isLocale('en') ? 'Main Menu' : 'الرئيسية' }}
                </button>
            </div>
        </div>

    </div>

    <script>
    /**
     * Property Hunter – Real Estate Browser Game
     * Embedded version (scoped inside .game-wrapper)
     */
    const PropertyGame = (() => {

        // ── Localization from Blade ──
        const isAr = {{ App::isLocale('en') ? 'false' : 'true' }};

        // ── Property types ──
        const PROPERTY_TYPES = [
            { emoji: '🏢', label: isAr ? 'شقة'   : 'Apartment', points: 10,  bad: false },
            { emoji: '🏠', label: isAr ? 'بيت'   : 'House',     points: 15,  bad: false },
            { emoji: '🏡', label: isAr ? 'فيلا'  : 'Villa',     points: 25,  bad: false },
            { emoji: '🏗️', label: isAr ? 'برج'   : 'Tower',     points: 30,  bad: false },
            { emoji: '🏰', label: isAr ? 'قصر'   : 'Palace',    points: 50,  bad: false },
            { emoji: '🏚️', label: isAr ? 'متهالك' : 'Ruined',   points: -20, bad: true  },
        ];

        // ── Config ──
        const CONFIG = {
            gameDuration: 60,
            baseSpawnInterval: 1800,
            minSpawnInterval: 500,
            baseLifetime: 3500,
            minLifetime: 1200,
            pointsPerLevel: 80,
            maxProperties: 8,
            badChanceBase: 0.12,
            badChancePerLevel: 0.03,
            comboWindow: 1500,
            boardPadding: 20,
            propertySize: 80,
        };

        // ── Ranks ──
        const RANKS = isAr ? [
            { min: 800, icon: '🏆', badge: '🥇', title: 'مطور عقاري أسطوري!', subtitle: 'أداء خرافي! 🔥' },
            { min: 500, icon: '🌟', badge: '🥈', title: 'وسيط عقاري محترف!', subtitle: 'ممتاز جداً!' },
            { min: 300, icon: '🏅', badge: '🥉', title: 'سمسار شاطر!', subtitle: 'أحسنت!' },
            { min: 100, icon: '👍', badge: '⭐', title: 'مبتدئ واعد', subtitle: 'كويس، كمّل تدريب!' },
            { min: 0,   icon: '😅', badge: '💪', title: 'لسه بتتعلم', subtitle: 'جرب تاني!' },
        ] : [
            { min: 800, icon: '🏆', badge: '🥇', title: 'Legendary Developer!', subtitle: 'Incredible! 🔥' },
            { min: 500, icon: '🌟', badge: '🥈', title: 'Pro Broker!', subtitle: 'Excellent!' },
            { min: 300, icon: '🏅', badge: '🥉', title: 'Smart Agent!', subtitle: 'Well done!' },
            { min: 100, icon: '👍', badge: '⭐', title: 'Promising Beginner', subtitle: 'Keep practicing!' },
            { min: 0,   icon: '😅', badge: '💪', title: 'Still Learning', subtitle: 'Try again!' },
        ];

        // ── State ──
        let state = {};

        // ── DOM ──
        const $ = id => document.getElementById(id);
        const $startScreen = $('startScreen');
        const $gameScreen  = $('gameScreen');
        const $endScreen   = $('endScreen');
        const $board       = $('gBoard');
        const $score       = $('gScore');
        const $timer       = $('gTimer');
        const $level       = $('gLevel');
        const $comboDisp   = $('gComboDisplay');
        const $comboText   = $('gComboText');
        const $levelBanner = $('gLevelBanner');
        const $levelNum    = $('gLevelBannerNum');

        // ── Screen management ──
        function showScreen(screen) {
            [$startScreen, $gameScreen, $endScreen].forEach(s => s.classList.add('g-hidden'));
            screen.classList.remove('g-hidden');
        }

        // ── Start ──
        function start() {
            state = {
                score: 0, level: 1, timeLeft: CONFIG.gameDuration,
                collected: 0, combo: 0, lastClickTime: 0,
                running: true, spawnTimer: null, clockTimer: null,
                properties: [],
            };
            $board.innerHTML = '';
            updateHUD();
            showScreen($gameScreen);
            state.clockTimer = setInterval(tick, 1000);
            scheduleNextSpawn();
        }

        // ── Clock ──
        function tick() {
            state.timeLeft--;
            $timer.textContent = state.timeLeft;
            if (state.timeLeft <= 10) {
                $timer.classList.add('timer-warn');
            } else {
                $timer.classList.remove('timer-warn');
            }
            if (state.timeLeft <= 0) endGame();
        }

        // ── Spawning ──
        function scheduleNextSpawn() {
            if (!state.running) return;
            const interval = Math.max(CONFIG.minSpawnInterval, CONFIG.baseSpawnInterval - (state.level - 1) * 180);
            const jitter = interval * (0.7 + Math.random() * 0.6);
            state.spawnTimer = setTimeout(() => {
                spawnProperty();
                scheduleNextSpawn();
            }, jitter);
        }

        function spawnProperty() {
            if (!state.running || state.properties.length >= CONFIG.maxProperties) return;

            const type = pickPropertyType();
            const pos = getRandomPosition();
            const lifetime = Math.max(CONFIG.minLifetime, CONFIG.baseLifetime - (state.level - 1) * 250);

            const el = document.createElement('div');
            el.className = 'g-property';
            el.style.left = pos.x + 'px';
            el.style.top = pos.y + 'px';

            const ptClass = type.bad ? 'bad' : 'good';
            const ptText = type.bad ? type.points : '+' + type.points;

            el.innerHTML = `
                <span class="g-property-emoji">${type.emoji}</span>
                <span class="g-property-label">${type.label}</span>
                <span class="g-property-points ${ptClass}">${ptText}</span>
            `;

            el.addEventListener('click', () => onPropertyClick(el, type));
            $board.appendChild(el);
            state.properties.push(el);

            el._removeTimer = setTimeout(() => removeProperty(el, 'missed'), lifetime);
        }

        function pickPropertyType() {
            const badChance = Math.min(0.45, CONFIG.badChanceBase + (state.level - 1) * CONFIG.badChancePerLevel);
            if (Math.random() < badChance) return PROPERTY_TYPES.find(t => t.bad);

            const goodTypes = PROPERTY_TYPES.filter(t => !t.bad);
            const weights = goodTypes.map(t => {
                if (t.points <= 10) return 40;
                if (t.points <= 15) return 30;
                if (t.points <= 25) return 18;
                if (t.points <= 30) return 9;
                return 3;
            });
            const total = weights.reduce((a, b) => a + b, 0);
            let rand = Math.random() * total;
            for (let i = 0; i < goodTypes.length; i++) {
                rand -= weights[i];
                if (rand <= 0) return goodTypes[i];
            }
            return goodTypes[0];
        }

        function getRandomPosition() {
            const boardRect = $board.getBoundingClientRect();
            const pad = CONFIG.boardPadding;
            const size = CONFIG.propertySize;
            const maxX = boardRect.width - size - pad * 2;
            const maxY = boardRect.height - size - pad * 2;
            let x, y, attempts = 0;
            do {
                x = pad + Math.random() * Math.max(0, maxX);
                y = pad + Math.random() * Math.max(0, maxY);
                attempts++;
            } while (attempts < 10 && isOverlapping(x, y, size));
            return { x, y };
        }

        function isOverlapping(x, y, size) {
            const minDist = size * 0.7;
            return state.properties.some(el => {
                const dx = x - parseFloat(el.style.left);
                const dy = y - parseFloat(el.style.top);
                return Math.sqrt(dx * dx + dy * dy) < minDist;
            });
        }

        // ── Clicking ──
        function onPropertyClick(el, type) {
            if (!state.running) return;
            clearTimeout(el._removeTimer);
            const now = Date.now();

            if (type.bad) {
                state.score = Math.max(0, state.score + type.points);
                state.combo = 0;
                showFloatingScore(el, type.points);
                removeProperty(el, 'bad-clicked');
                popHUD('bad');
            } else {
                state.collected++;
                state.combo = (now - state.lastClickTime < CONFIG.comboWindow) ? state.combo + 1 : 1;
                state.lastClickTime = now;

                const multiplier = Math.min(state.combo, 5);
                const earned = type.points * multiplier;
                state.score += earned;

                showFloatingScore(el, earned);
                removeProperty(el, 'collected');
                popHUD('good');

                if (multiplier > 1) showCombo(multiplier);
                checkLevelUp();
            }
            updateHUD();
        }

        function showFloatingScore(el, points) {
            const floater = document.createElement('div');
            floater.className = 'g-float-score ' + (points > 0 ? 'positive' : 'negative');
            floater.textContent = (points > 0 ? '+' : '') + points;
            floater.style.left = el.style.left;
            floater.style.top = el.style.top;
            $board.appendChild(floater);
            setTimeout(() => floater.remove(), 800);
        }

        function removeProperty(el, animClass) {
            el.classList.add(animClass);
            state.properties = state.properties.filter(p => p !== el);
            setTimeout(() => el.remove(), 500);
        }

        // ── HUD ──
        function updateHUD() {
            $score.textContent = state.score;
            $timer.textContent = state.timeLeft;
            $level.textContent = state.level;
        }

        function popHUD(type) {
            const cls = type === 'good' ? 'pop' : 'pop-bad';
            $score.classList.add(cls);
            setTimeout(() => $score.classList.remove(cls), 200);
        }

        function showCombo(mult) {
            $comboText.textContent = 'x' + mult;
            $comboDisp.classList.remove('g-hidden');
            clearTimeout($comboDisp._hideTimer);
            $comboDisp._hideTimer = setTimeout(() => $comboDisp.classList.add('g-hidden'), CONFIG.comboWindow + 200);
        }

        // ── Level ──
        function checkLevelUp() {
            const newLevel = Math.floor(state.score / CONFIG.pointsPerLevel) + 1;
            if (newLevel > state.level) {
                state.level = newLevel;
                $level.textContent = state.level;
                $levelNum.textContent = state.level;
                $levelBanner.classList.remove('g-hidden');
                setTimeout(() => $levelBanner.classList.add('g-hidden'), 2000);
            }
        }

        // ── Game Over ──
        function endGame() {
            state.running = false;
            clearInterval(state.clockTimer);
            clearTimeout(state.spawnTimer);
            state.properties.forEach(el => { clearTimeout(el._removeTimer); el.remove(); });
            state.properties = [];

            const rank = RANKS.find(r => state.score >= r.min) || RANKS[RANKS.length - 1];

            $('gFinalScore').textContent = state.score;
            $('gFinalLevel').textContent = state.level;
            $('gFinalCollected').textContent = state.collected;
            $('gEndIcon').textContent = rank.icon;
            $('gEndSubtitle').textContent = rank.subtitle;

            const rankEl = $('gEndRank');
            rankEl.querySelector('.g-rank-badge').textContent = rank.badge;
            rankEl.querySelector('.g-rank-text').textContent = rank.title;

            showScreen($endScreen);
        }

        // ── Navigation ──
        function goHome() {
            showScreen($startScreen);
        }

        return { start, goHome };
    })();
    </script>
</x-layout>
