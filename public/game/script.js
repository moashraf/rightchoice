/**
 * ============================================
 *  Property Hunter – Real Estate Browser Game
 * ============================================
 *
 *  Click good properties to collect points!
 *  Avoid broken/bad buildings.
 *  Difficulty increases every level.
 *
 *  Pure vanilla JS – no dependencies.
 * ============================================
 */

const Game = (() => {

    // ── Property types ──────────────────────────────────────────────
    // Each type has: emoji, Arabic label, points, and whether it's "bad"
    const PROPERTY_TYPES = [
        { emoji: '🏢', label: 'شقة',   labelEn: 'Apartment', points: 10,  bad: false },
        { emoji: '🏠', label: 'بيت',   labelEn: 'House',     points: 15,  bad: false },
        { emoji: '🏡', label: 'فيلا',  labelEn: 'Villa',     points: 25,  bad: false },
        { emoji: '🏗️', label: 'برج',   labelEn: 'Tower',     points: 30,  bad: false },
        { emoji: '🏰', label: 'قصر',   labelEn: 'Palace',    points: 50,  bad: false },
        { emoji: '🏚️', label: 'متهالك', labelEn: 'Ruined',   points: -20, bad: true  },
    ];

    // ── Game configuration ──────────────────────────────────────────
    const CONFIG = {
        gameDuration: 60,            // seconds
        baseSpawnInterval: 1800,     // ms between spawns at level 1
        minSpawnInterval: 500,       // fastest spawn rate
        baseLifetime: 3500,          // ms a property stays on screen at level 1
        minLifetime: 1200,           // shortest lifetime
        pointsPerLevel: 80,          // points needed to advance a level
        maxProperties: 8,            // max simultaneous properties on board
        badChanceBase: 0.12,         // base probability of a bad property
        badChancePerLevel: 0.03,     // increase per level
        comboWindow: 1500,           // ms window to keep combo alive
        boardPadding: 20,            // px padding from edges
        propertySize: 80,            // approximate size of a property element
    };

    // ── State ───────────────────────────────────────────────────────
    let state = {
        score: 0,
        level: 1,
        timeLeft: CONFIG.gameDuration,
        collected: 0,
        combo: 0,
        lastClickTime: 0,
        running: false,
        spawnTimer: null,
        clockTimer: null,
        properties: [],              // active property elements
    };

    // ── DOM references ──────────────────────────────────────────────
    const $startScreen = document.getElementById('startScreen');
    const $gameScreen  = document.getElementById('gameScreen');
    const $endScreen   = document.getElementById('endScreen');
    const $board       = document.getElementById('board');
    const $score       = document.getElementById('score');
    const $timer       = document.getElementById('timer');
    const $level       = document.getElementById('level');
    const $comboDisp   = document.getElementById('comboDisplay');
    const $comboText   = document.getElementById('comboText');
    const $levelBanner = document.getElementById('levelBanner');
    const $levelNum    = document.getElementById('levelBannerNum');


    // ==============================================================
    //  SCREEN MANAGEMENT
    // ==============================================================

    /** Show one screen, hide the rest */
    function showScreen(screen) {
        [$startScreen, $gameScreen, $endScreen].forEach(s => s.classList.add('hidden'));
        screen.classList.remove('hidden');
    }


    // ==============================================================
    //  GAME START
    // ==============================================================

    function start() {
        // Reset state
        state = {
            score: 0,
            level: 1,
            timeLeft: CONFIG.gameDuration,
            collected: 0,
            combo: 0,
            lastClickTime: 0,
            running: true,
            spawnTimer: null,
            clockTimer: null,
            properties: [],
        };

        // Clear board
        $board.innerHTML = '';

        // Update HUD
        updateHUD();

        // Show game screen
        showScreen($gameScreen);

        // Start clock (count down every second)
        state.clockTimer = setInterval(tick, 1000);

        // Start spawning properties
        scheduleNextSpawn();
    }


    // ==============================================================
    //  GAME CLOCK
    // ==============================================================

    /** Called every second */
    function tick() {
        state.timeLeft--;
        $timer.textContent = state.timeLeft;

        // Warning state when time is low
        if (state.timeLeft <= 10) {
            $timer.classList.add('timer-warn');
        } else {
            $timer.classList.remove('timer-warn');
        }

        // Game over
        if (state.timeLeft <= 0) {
            endGame();
        }
    }


    // ==============================================================
    //  SPAWNING
    // ==============================================================

    /** Schedule the next property spawn */
    function scheduleNextSpawn() {
        if (!state.running) return;

        // Interval decreases with level (game gets faster)
        const interval = Math.max(
            CONFIG.minSpawnInterval,
            CONFIG.baseSpawnInterval - (state.level - 1) * 180
        );

        // Add some randomness (±30%)
        const jitter = interval * (0.7 + Math.random() * 0.6);

        state.spawnTimer = setTimeout(() => {
            spawnProperty();
            scheduleNextSpawn(); // chain next spawn
        }, jitter);
    }

    /** Create a property on the board */
    function spawnProperty() {
        if (!state.running) return;

        // Don't exceed max on screen
        if (state.properties.length >= CONFIG.maxProperties) return;

        // Pick a random property type
        const type = pickPropertyType();

        // Calculate random position (avoid HUD area at top)
        const pos = getRandomPosition();

        // Calculate lifetime (decreases with level)
        const lifetime = Math.max(
            CONFIG.minLifetime,
            CONFIG.baseLifetime - (state.level - 1) * 250
        );

        // Create DOM element
        const el = document.createElement('div');
        el.className = 'property';
        el.style.left = pos.x + 'px';
        el.style.top = pos.y + 'px';

        const pointsClass = type.bad ? 'bad' : 'good';
        const pointsText = type.bad ? type.points : '+' + type.points;

        el.innerHTML = `
            <span class="property-emoji">${type.emoji}</span>
            <span class="property-label">${type.label}</span>
            <span class="property-points ${pointsClass}">${pointsText}</span>
        `;

        // Click handler
        el.addEventListener('click', () => onPropertyClick(el, type));

        // Add to board & track
        $board.appendChild(el);
        state.properties.push(el);

        // Auto-remove after lifetime (if not clicked)
        el._removeTimer = setTimeout(() => {
            removeProperty(el, 'missed');
        }, lifetime);
    }

    /** Pick a property type (bad properties become more common at higher levels) */
    function pickPropertyType() {
        const badChance = Math.min(
            0.45, // cap at 45%
            CONFIG.badChanceBase + (state.level - 1) * CONFIG.badChancePerLevel
        );

        const isBad = Math.random() < badChance;

        if (isBad) {
            // Return the bad type
            return PROPERTY_TYPES.find(t => t.bad);
        }

        // Pick a random good type; rarer types (higher points) appear less often
        const goodTypes = PROPERTY_TYPES.filter(t => !t.bad);

        // Weighted random: cheaper properties appear more often
        const weights = goodTypes.map(t => {
            if (t.points <= 10) return 40;
            if (t.points <= 15) return 30;
            if (t.points <= 25) return 18;
            if (t.points <= 30) return 9;
            return 3;
        });

        const totalWeight = weights.reduce((a, b) => a + b, 0);
        let rand = Math.random() * totalWeight;

        for (let i = 0; i < goodTypes.length; i++) {
            rand -= weights[i];
            if (rand <= 0) return goodTypes[i];
        }

        return goodTypes[0]; // fallback
    }

    /** Get a random position on the board avoiding overlaps */
    function getRandomPosition() {
        const boardRect = $board.getBoundingClientRect();
        const pad = CONFIG.boardPadding;
        const size = CONFIG.propertySize;

        // Available area
        const maxX = boardRect.width - size - pad * 2;
        const maxY = boardRect.height - size - pad * 2;

        let x, y;
        let attempts = 0;

        // Try to find a non-overlapping position
        do {
            x = pad + Math.random() * Math.max(0, maxX);
            y = pad + Math.random() * Math.max(0, maxY);
            attempts++;
        } while (attempts < 10 && isOverlapping(x, y, size));

        return { x, y };
    }

    /** Check if position overlaps with existing properties */
    function isOverlapping(x, y, size) {
        const minDist = size * 0.7;
        return state.properties.some(el => {
            const ex = parseFloat(el.style.left);
            const ey = parseFloat(el.style.top);
            const dx = x - ex;
            const dy = y - ey;
            return Math.sqrt(dx * dx + dy * dy) < minDist;
        });
    }


    // ==============================================================
    //  CLICKING / SCORING
    // ==============================================================

    /** Handle clicking a property */
    function onPropertyClick(el, type) {
        if (!state.running) return;

        // Clear auto-remove timer
        clearTimeout(el._removeTimer);

        const now = Date.now();

        if (type.bad) {
            // Clicked a bad property – lose points!
            state.score = Math.max(0, state.score + type.points);
            state.combo = 0;
            showFloatingScore(el, type.points);
            removeProperty(el, 'bad-clicked');
            popHUD('bad');
        } else {
            // Good property collected
            state.collected++;

            // Combo system: consecutive clicks within the time window
            if (now - state.lastClickTime < CONFIG.comboWindow) {
                state.combo++;
            } else {
                state.combo = 1;
            }

            state.lastClickTime = now;

            // Calculate points with combo multiplier
            const multiplier = Math.min(state.combo, 5); // cap at x5
            const earned = type.points * multiplier;
            state.score += earned;

            showFloatingScore(el, earned);
            removeProperty(el, 'collected');
            popHUD('good');

            // Show combo indicator
            if (multiplier > 1) {
                showCombo(multiplier);
            }

            // Check level up
            checkLevelUp();
        }

        updateHUD();
    }

    /** Show floating score text at the property's position */
    function showFloatingScore(el, points) {
        const floater = document.createElement('div');
        const positive = points > 0;
        floater.className = 'float-score ' + (positive ? 'positive' : 'negative');
        floater.textContent = (positive ? '+' : '') + points;
        floater.style.left = el.style.left;
        floater.style.top = el.style.top;

        $board.appendChild(floater);

        // Remove after animation
        setTimeout(() => floater.remove(), 800);
    }

    /** Remove a property element from the board */
    function removeProperty(el, animClass) {
        // Add exit animation class
        el.classList.add(animClass);

        // Remove from tracking array
        state.properties = state.properties.filter(p => p !== el);

        // Remove from DOM after animation
        setTimeout(() => el.remove(), 500);
    }


    // ==============================================================
    //  HUD UPDATES
    // ==============================================================

    function updateHUD() {
        $score.textContent = state.score;
        $timer.textContent = state.timeLeft;
        $level.textContent = state.level;
    }

    /** Quick pop animation on the score */
    function popHUD(type) {
        const cls = type === 'good' ? 'pop' : 'pop-bad';
        $score.classList.add(cls);
        setTimeout(() => $score.classList.remove(cls), 200);
    }

    /** Show combo multiplier */
    function showCombo(multiplier) {
        $comboText.textContent = 'x' + multiplier;
        $comboDisp.classList.remove('hidden');

        // Hide after combo window expires
        clearTimeout($comboDisp._hideTimer);
        $comboDisp._hideTimer = setTimeout(() => {
            $comboDisp.classList.add('hidden');
        }, CONFIG.comboWindow + 200);
    }


    // ==============================================================
    //  LEVEL SYSTEM
    // ==============================================================

    function checkLevelUp() {
        const newLevel = Math.floor(state.score / CONFIG.pointsPerLevel) + 1;

        if (newLevel > state.level) {
            state.level = newLevel;
            $level.textContent = state.level;

            // Show level-up banner
            $levelNum.textContent = state.level;
            $levelBanner.classList.remove('hidden');

            setTimeout(() => {
                $levelBanner.classList.add('hidden');
            }, 2000);
        }
    }


    // ==============================================================
    //  GAME OVER
    // ==============================================================

    function endGame() {
        state.running = false;

        // Stop timers
        clearInterval(state.clockTimer);
        clearTimeout(state.spawnTimer);

        // Clear all remaining properties
        state.properties.forEach(el => {
            clearTimeout(el._removeTimer);
            el.remove();
        });
        state.properties = [];

        // Determine rank based on score
        const rank = getRank(state.score);

        // Populate end screen
        document.getElementById('finalScore').textContent = state.score;
        document.getElementById('finalLevel').textContent = state.level;
        document.getElementById('finalCollected').textContent = state.collected;
        document.getElementById('endIcon').textContent = rank.icon;
        document.getElementById('endTitle').textContent = 'انتهت اللعبة!';
        document.getElementById('endSubtitle').textContent = rank.subtitle;

        const rankEl = document.getElementById('endRank');
        rankEl.querySelector('.rank-badge').textContent = rank.badge;
        rankEl.querySelector('.rank-text').textContent = rank.title;

        // Show end screen
        showScreen($endScreen);
    }

    /** Get rank based on final score */
    function getRank(score) {
        if (score >= 800) {
            return {
                icon: '🏆', badge: '🥇',
                title: 'مطور عقاري أسطوري!',
                subtitle: 'أداء خرافي! 🔥'
            };
        }
        if (score >= 500) {
            return {
                icon: '🌟', badge: '🥈',
                title: 'وسيط عقاري محترف!',
                subtitle: 'ممتاز جداً!'
            };
        }
        if (score >= 300) {
            return {
                icon: '🏅', badge: '🥉',
                title: 'سمسار شاطر!',
                subtitle: 'أحسنت!'
            };
        }
        if (score >= 100) {
            return {
                icon: '👍', badge: '⭐',
                title: 'مبتدئ واعد',
                subtitle: 'كويس، كمّل تدريب!'
            };
        }
        return {
            icon: '😅', badge: '💪',
            title: 'لسه بتتعلم',
            subtitle: 'جرب تاني!'
        };
    }


    // ==============================================================
    //  NAVIGATION
    // ==============================================================

    function goHome() {
        showScreen($startScreen);
    }


    // ==============================================================
    //  PUBLIC API
    // ==============================================================

    return {
        start,
        goHome,
    };

})();
