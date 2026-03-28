<x-layout>
    <style>
        :root {
            --smart-primary: #2563eb;
            --smart-primary-dark: #1d4ed8;
            --smart-bg: #f0f4f8;
            --smart-card-bg: #ffffff;
            --smart-user-msg: #2563eb;
            --smart-bot-msg: #ffffff;
            --smart-text: #1e293b;
            --smart-text-light: #64748b;
            --smart-border: #e2e8f0;
            --smart-success: #10b981;
            --smart-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }

        .smart-search-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px 15px;
            min-height: 80vh;
            display: flex;
            flex-direction: column;
        }

        .smart-search-header {
            text-align: center;
            padding: 30px 15px 20px;
        }

        .smart-search-header h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--smart-text);
            margin-bottom: 8px;
        }

        .smart-search-header p {
            color: var(--smart-text-light);
            font-size: 0.95rem;
            margin: 0;
        }

        .smart-search-header .header-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--smart-primary), #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.6rem;
            color: #fff;
        }

        /* Chat Area */
        .smart-chat-area {
            flex: 1;
            overflow-y: auto;
            padding: 10px 0;
            max-height: 55vh;
            scroll-behavior: smooth;
        }

        .smart-chat-area::-webkit-scrollbar {
            width: 5px;
        }

        .smart-chat-area::-webkit-scrollbar-track {
            background: transparent;
        }

        .smart-chat-area::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* Messages */
        .smart-message {
            display: flex;
            margin-bottom: 16px;
            animation: smartFadeIn 0.3s ease;
        }

        @keyframes smartFadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .smart-message.user {
            justify-content: flex-end;
        }

        .smart-message.bot {
            justify-content: flex-start;
        }

        .smart-msg-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.85rem;
        }

        .smart-message.bot .smart-msg-avatar {
            background: linear-gradient(135deg, var(--smart-primary), #7c3aed);
            color: #fff;
            margin-left: 10px;
            margin-right: 10px;
        }

        .smart-message.user .smart-msg-avatar {
            background: #e2e8f0;
            color: var(--smart-text);
            margin-left: 10px;
            margin-right: 10px;
        }

        .smart-msg-bubble {
            max-width: 75%;
            padding: 12px 16px;
            border-radius: 16px;
            font-size: 0.95rem;
            line-height: 1.6;
            position: relative;
        }

        .smart-message.user .smart-msg-bubble {
            background: var(--smart-user-msg);
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        .smart-message.bot .smart-msg-bubble {
            background: var(--smart-bot-msg);
            color: var(--smart-text);
            border: 1px solid var(--smart-border);
            border-bottom-left-radius: 4px;
        }

        /* Suggestion Chips */
        .smart-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 10px 0;
        }

        .smart-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: #fff;
            border: 1px solid var(--smart-border);
            border-radius: 20px;
            font-size: 0.85rem;
            color: var(--smart-text);
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .smart-chip:hover {
            border-color: var(--smart-primary);
            color: var(--smart-primary);
            background: #eff6ff;
            transform: translateY(-1px);
        }

        .smart-chip i {
            font-size: 0.75rem;
            color: var(--smart-primary);
        }

        /* Follow-up Questions */
        .smart-followup {
            margin-top: 10px;
        }

        .smart-followup-btn {
            display: block;
            width: 100%;
            text-align: right;
            padding: 8px 14px;
            margin-bottom: 6px;
            background: #f8fafc;
            border: 1px solid var(--smart-border);
            border-radius: 10px;
            font-size: 0.85rem;
            color: var(--smart-primary);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .smart-followup-btn:hover {
            background: #eff6ff;
            border-color: var(--smart-primary);
        }

        /* Property Results */
        .smart-results-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-top: 12px;
        }

        .smart-property-card {
            display: flex;
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--smart-border);
            overflow: hidden;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
        }

        .smart-property-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
            text-decoration: none;
            color: inherit;
        }

        .smart-property-img {
            width: 140px;
            min-height: 120px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .smart-property-info {
            padding: 12px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .smart-property-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--smart-text);
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .smart-property-price {
            font-size: 1rem;
            font-weight: 700;
            color: var(--smart-primary);
            margin-bottom: 6px;
        }

        .smart-property-meta {
            display: flex;
            gap: 12px;
            font-size: 0.78rem;
            color: var(--smart-text-light);
        }

        .smart-property-meta span {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .smart-property-location {
            font-size: 0.78rem;
            color: var(--smart-text-light);
            margin-top: 4px;
        }

        .smart-property-vip {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #f59e0b;
            color: #fff;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .smart-property-card-wrapper {
            position: relative;
        }

        /* Result count */
        .smart-result-count {
            font-size: 0.85rem;
            color: var(--smart-text-light);
            margin-bottom: 8px;
        }

        .smart-result-count strong {
            color: var(--smart-primary);
        }

        /* More results link */
        .smart-more-results {
            display: block;
            text-align: center;
            padding: 12px;
            margin-top: 8px;
            background: #f8fafc;
            border: 1px dashed var(--smart-border);
            border-radius: 10px;
            color: var(--smart-primary);
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .smart-more-results:hover {
            background: #eff6ff;
            text-decoration: none;
            color: var(--smart-primary-dark);
        }

        /* Input Area */
        .smart-input-area {
            padding: 15px 0 10px;
            border-top: 1px solid var(--smart-border);
            margin-top: auto;
        }

        .smart-input-wrapper {
            display: flex;
            gap: 10px;
            align-items: center;
            background: #fff;
            border: 2px solid var(--smart-border);
            border-radius: 25px;
            padding: 6px 6px 6px 16px;
            transition: border-color 0.2s ease;
        }

        .smart-input-wrapper:focus-within {
            border-color: var(--smart-primary);
        }

        .smart-input-wrapper input {
            flex: 1;
            border: none;
            outline: none;
            font-size: 0.95rem;
            background: transparent;
            color: var(--smart-text);
            padding: 8px 0;
        }

        .smart-input-wrapper input::placeholder {
            color: #94a3b8;
        }

        .smart-send-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--smart-primary);
            border: none;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s ease;
            flex-shrink: 0;
        }

        .smart-send-btn:hover {
            background: var(--smart-primary-dark);
        }

        .smart-send-btn:disabled {
            background: #94a3b8;
            cursor: not-allowed;
        }

        .smart-send-btn i {
            font-size: 1rem;
        }

        /* Loading dots */
        .smart-typing {
            display: flex;
            gap: 4px;
            padding: 8px 0;
        }

        .smart-typing span {
            width: 8px;
            height: 8px;
            background: #94a3b8;
            border-radius: 50%;
            animation: smartBounce 1.4s infinite;
        }

        .smart-typing span:nth-child(2) { animation-delay: 0.2s; }
        .smart-typing span:nth-child(3) { animation-delay: 0.4s; }

        @keyframes smartBounce {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-6px); }
        }

        /* Detected filters bar */
        .smart-filters-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            padding: 8px 0;
        }

        .smart-filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            font-size: 0.75rem;
            color: var(--smart-primary);
        }

        .smart-filter-tag i {
            font-size: 0.65rem;
        }

        /* No results */
        .smart-no-results {
            text-align: center;
            padding: 20px;
        }

        .smart-no-results .icon {
            font-size: 2.5rem;
            color: #cbd5e1;
            margin-bottom: 10px;
        }

        .smart-no-results p {
            color: var(--smart-text-light);
            margin-bottom: 6px;
        }

        .smart-relaxed-title {
            font-size: 0.9rem;
            color: var(--smart-text);
            font-weight: 600;
            margin: 12px 0 8px;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .smart-search-header h2 {
                font-size: 1.3rem;
            }

            .smart-msg-bubble {
                max-width: 85%;
            }

            .smart-property-img {
                width: 110px;
                min-height: 100px;
            }

            .smart-property-info {
                padding: 8px;
            }

            .smart-property-title {
                font-size: 0.82rem;
            }

            .smart-property-price {
                font-size: 0.9rem;
            }

            .smart-chip {
                font-size: 0.78rem;
                padding: 6px 12px;
            }

            .smart-chat-area {
                max-height: 50vh;
            }
        }

        /* RTL specific */
        [dir="rtl"] .smart-message.user .smart-msg-bubble {
            border-bottom-right-radius: 16px;
            border-bottom-left-radius: 4px;
        }

        [dir="rtl"] .smart-message.bot .smart-msg-bubble {
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 4px;
        }

        [dir="rtl"] .smart-send-btn i {
            transform: rotate(180deg);
        }

        [dir="rtl"] .smart-followup-btn {
            text-align: right;
        }

        [dir="ltr"] .smart-followup-btn {
            text-align: left;
        }
    </style>

    <div class="smart-search-container" id="smartSearch">
        {{-- Header --}}
        <div class="smart-search-header">
            <div class="header-icon">
                <i class="fas fa-robot"></i>
            </div>
            <h2>{{ App::isLocale('en') ? 'What property are you looking for?' : 'إيه الشقة اللي بتدور عليها؟' }}</h2>
            <p>{{ App::isLocale('en') ? 'Describe what you need in your own words' : 'قولنا بالظبط عايز إيه وإحنا هنلاقيلك' }}</p>
        </div>

        {{-- Chat Area --}}
        <div class="smart-chat-area" id="smartChatArea">
            {{-- Welcome message --}}
            <div class="smart-message bot">
                <div class="smart-msg-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <div class="smart-msg-bubble">
                        {{ App::isLocale('en')
                            ? 'Hi! 👋 I\'m your smart property assistant. Tell me what you\'re looking for - type of property, location, budget, number of rooms - and I\'ll find the best options for you!'
                            : 'أهلاً! 👋 أنا مساعدك الذكي للعقارات. قولي بتدور على إيه - نوع العقار، المكان، الميزانية، عدد الغرف - وأنا هلاقيلك أحسن الاختيارات!' }}
                    </div>

                    {{-- Suggestion chips --}}
                    <div class="smart-chips" id="smartChips">
                        @if(App::isLocale('en'))
                            <button class="smart-chip" onclick="smartSendChip(this)">
                                <i class="fas fa-building"></i> Apartment for sale
                            </button>
                            <button class="smart-chip" onclick="smartSendChip(this)">
                                <i class="fas fa-home"></i> Villa with garden
                            </button>
                            <button class="smart-chip" onclick="smartSendChip(this)">
                                <i class="fas fa-couch"></i> Furnished for rent
                            </button>
                            <button class="smart-chip" onclick="smartSendChip(this)">
                                <i class="fas fa-money-bill-wave"></i> Installment
                            </button>
                            <button class="smart-chip" onclick="smartSendChip(this)">
                                <i class="fas fa-store"></i> Office or Shop
                            </button>
                        @else
                            <button class="smart-chip" onclick="smartSendChip(this)">
                                <i class="fas fa-building"></i> شقة للبيع
                            </button>
                            <button class="smart-chip" onclick="smartSendChip(this)">
                                <i class="fas fa-home"></i> فيلا بحديقة
                            </button>
                            <button class="smart-chip" onclick="smartSendChip(this)">
                                <i class="fas fa-couch"></i> شقة مفروشة للايجار
                            </button>
                            <button class="smart-chip" onclick="smartSendChip(this)">
                                <i class="fas fa-money-bill-wave"></i> عقار بالتقسيط
                            </button>
                            <button class="smart-chip" onclick="smartSendChip(this)">
                                <i class="fas fa-store"></i> مكتب أو محل
                            </button>
                            <button class="smart-chip" onclick="smartSendChip(this)">
                                <i class="fas fa-building"></i> شقة 3 غرف بميزانية 2 مليون
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Input Area --}}
        <div class="smart-input-area">
            <form id="smartSearchForm" onsubmit="smartSendMessage(event)">
                <div class="smart-input-wrapper">
                    <input type="text" id="smartInput"
                           placeholder="{{ App::isLocale('en') ? 'Describe the property you want...' : 'اوصفلي العقار اللي بتدور عليه...' }}"
                           autocomplete="off" maxlength="500">
                    <button type="submit" class="smart-send-btn" id="smartSendBtn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    (function() {
        const LOCALE = '{{ App::getLocale() }}';
        const SEARCH_URL = '{{ route("smart-search.search", ["locale" => App::getLocale()]) }}';
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const isAr = LOCALE !== 'en';

        // Conversation state
        let conversationContext = {};
        let isProcessing = false;

        const chatArea = document.getElementById('smartChatArea');
        const input = document.getElementById('smartInput');
        const sendBtn = document.getElementById('smartSendBtn');

        // Labels
        const labels = {
            searching: isAr ? 'جاري البحث عن أنسب العقارات...' : 'Searching for the best properties...',
            noResults: isAr ? 'مش لاقي عقارات مطابقة للي وصفته' : 'No exact matches found for your description',
            tryAgain: isAr ? 'جرب تغير الميزانية أو المنطقة أو نوع العقار' : 'Try adjusting the budget, location, or property type',
            nearestResults: isAr ? 'لكن ممكن دول يعجبوك:' : 'But you might like these:',
            results: isAr ? 'عقار' : 'properties',
            found: isAr ? 'لقيتلك' : 'Found',
            moreResults: isAr ? 'عرض المزيد من النتائج' : 'Show more results',
            rooms: isAr ? 'غرف' : 'Rooms',
            baths: isAr ? 'حمام' : 'Baths',
            sqm: isAr ? 'م²' : 'm²',
            egp: isAr ? 'جنيه' : 'EGP',
            vip: isAr ? 'مميز' : 'VIP',
            error: isAr ? 'حصل خطأ، جرب تاني' : 'Something went wrong, please try again',
        };

        function scrollToBottom() {
            setTimeout(() => {
                chatArea.scrollTop = chatArea.scrollHeight;
            }, 100);
        }

        function addUserMessage(text) {
            const msgDiv = document.createElement('div');
            msgDiv.className = 'smart-message user';
            msgDiv.innerHTML = `
                <div class="smart-msg-bubble">${escapeHtml(text)}</div>
                <div class="smart-msg-avatar"><i class="fas fa-user"></i></div>
            `;
            chatArea.appendChild(msgDiv);
            scrollToBottom();
        }

        function addBotMessage(content) {
            const msgDiv = document.createElement('div');
            msgDiv.className = 'smart-message bot';
            msgDiv.innerHTML = `
                <div class="smart-msg-avatar"><i class="fas fa-robot"></i></div>
                <div>${content}</div>
            `;
            chatArea.appendChild(msgDiv);
            scrollToBottom();
        }

        function addTypingIndicator() {
            const id = 'typing-' + Date.now();
            const msgDiv = document.createElement('div');
            msgDiv.className = 'smart-message bot';
            msgDiv.id = id;
            msgDiv.innerHTML = `
                <div class="smart-msg-avatar"><i class="fas fa-robot"></i></div>
                <div class="smart-msg-bubble">
                    <div class="smart-typing">
                        <span></span><span></span><span></span>
                    </div>
                    <div style="font-size:0.8rem;color:var(--smart-text-light);margin-top:4px;">${labels.searching}</div>
                </div>
            `;
            chatArea.appendChild(msgDiv);
            scrollToBottom();
            return id;
        }

        function removeTypingIndicator(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function buildResultsHtml(data) {
            let html = '<div class="smart-msg-bubble">';

            if (data.noResults) {
                html += `
                    <div class="smart-no-results">
                        <div class="icon"><i class="fas fa-search"></i></div>
                        <p><strong>${labels.noResults}</strong></p>
                        <p style="font-size:0.82rem;">${labels.tryAgain}</p>
                    </div>
                `;

                if (data.relaxedResults && data.relaxedResults.length > 0) {
                    html += `<div class="smart-relaxed-title">${labels.nearestResults}</div>`;
                    html += '<div class="smart-results-grid">';
                    data.relaxedResults.forEach(function(prop) {
                        html += buildPropertyCard(prop);
                    });
                    html += '</div>';
                }
            } else {
                html += `<div class="smart-result-count">${labels.found} <strong>${data.resultCount}</strong> ${labels.results}</div>`;
                html += '<div class="smart-results-grid">';
                data.results.forEach(function(prop) {
                    html += buildPropertyCard(prop);
                });
                html += '</div>';

                // Build filter URL for "show more"
                if (data.resultCount >= 12) {
                    const filterUrl = buildFilterUrl(data.filters);
                    html += `<a href="${filterUrl}" class="smart-more-results" target="_blank">
                        <i class="fas fa-external-link-alt"></i> ${labels.moreResults}
                    </a>`;
                }
            }

            html += '</div>';

            // Follow-up questions
            if (data.followUpQuestions) {
                const langQuestions = isAr ? data.followUpQuestions.ar : data.followUpQuestions.en;
                if (langQuestions && langQuestions.length > 0) {
                    html += '<div class="smart-followup">';
                    langQuestions.forEach(function(q) {
                        html += `<button class="smart-followup-btn" onclick="smartSendChip(this)">${escapeHtml(q)}</button>`;
                    });
                    html += '</div>';
                }
            }

            return html;
        }

        function buildPropertyCard(prop) {
            return `
                <div class="smart-property-card-wrapper">
                    <a href="${prop.url}" target="_blank" class="smart-property-card">
                        <img src="${prop.image}" alt="" class="smart-property-img" loading="lazy"
                             onerror="this.src='{{ URL::to('/images/FBO.png') }}'">
                        <div class="smart-property-info">
                            <div class="smart-property-title">${escapeHtml(prop.title)}</div>
                            <div class="smart-property-price">
                                ${prop.price} ${prop.currency || labels.egp}
                                ${prop.priceLabel || ''}
                            </div>
                            <div class="smart-property-meta">
                                ${prop.rooms ? '<span><i class="fas fa-door-open"></i> ' + prop.rooms + ' ' + labels.rooms + '</span>' : ''}
                                ${prop.baths ? '<span><i class="fas fa-bath"></i> ' + prop.baths + ' ' + labels.baths + '</span>' : ''}
                                ${prop.area ? '<span><i class="fas fa-expand-arrows-alt"></i> ' + prop.area + ' ' + labels.sqm + '</span>' : ''}
                            </div>
                            ${prop.location ? '<div class="smart-property-location"><i class="fas fa-map-marker-alt"></i> ' + escapeHtml(prop.location) + '</div>' : ''}
                        </div>
                    </a>
                    ${prop.vip ? '<div class="smart-property-vip">' + labels.vip + '</div>' : ''}
                </div>
            `;
        }

        function buildFilterUrl(filters) {
            let params = new URLSearchParams();
            if (filters.location1) params.set('location1', filters.location1);
            if (filters.location2) params.set('location2', filters.location2);
            if (filters.licat) params.set('licat', filters.licat);
            if (filters.Propertytype) params.set('Propertytype', filters.Propertytype);
            if (filters.saletype) params.set('saletype', filters.saletype);
            if (filters.finishtype2) params.set('finishtype2', filters.finishtype2);
            if (filters.minArea) params.set('minArea', filters.minArea);
            if (filters.maxArea) params.set('maxArea', filters.maxArea);
            if (filters.minPrice) params.set('minPrice', filters.minPrice);
            if (filters.maxPrice) params.set('maxPrice', filters.maxPrice);
            if (filters.minRooms) params.set('minRooms', filters.minRooms);
            if (filters.maxRooms) params.set('maxRooms', filters.maxRooms);
            if (filters.minBaths) params.set('minBaths', filters.minBaths);
            if (filters.maxBaths) params.set('maxBaths', filters.maxBaths);
            if (filters.keywords) params.set('keywords', filters.keywords);
            if (filters.compound) params.set('compound', filters.compound);
            if (filters.area) params.set('area', filters.area);
            if (filters.mzaya) {
                filters.mzaya.forEach(m => params.append('mzaya[]', m));
            }
            return '/' + LOCALE + '/filter?' + params.toString();
        }

        // Send message
        window.smartSendMessage = function(e) {
            e.preventDefault();
            const text = input.value.trim();
            if (!text || isProcessing) return;

            isProcessing = true;
            sendBtn.disabled = true;
            input.value = '';

            // Hide initial chips
            const chipsEl = document.getElementById('smartChips');
            if (chipsEl) chipsEl.style.display = 'none';

            addUserMessage(text);

            const typingId = addTypingIndicator();

            fetch(SEARCH_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    message: text,
                    context: conversationContext,
                }),
            })
            .then(response => response.json())
            .then(data => {
                removeTypingIndicator(typingId);

                if (data.success) {
                    // Update conversation context with new filters
                    conversationContext = data.filters || {};
                    const resultsHtml = buildResultsHtml(data);
                    addBotMessage(resultsHtml);
                } else {
                    addBotMessage(`<div class="smart-msg-bubble">${labels.error}</div>`);
                }
            })
            .catch(err => {
                removeTypingIndicator(typingId);
                addBotMessage(`<div class="smart-msg-bubble">${labels.error}</div>`);
            })
            .finally(() => {
                isProcessing = false;
                sendBtn.disabled = false;
                input.focus();
            });
        };

        // Send chip text
        window.smartSendChip = function(el) {
            const text = el.textContent.trim();
            input.value = text;
            smartSendMessage(new Event('submit'));
        };

        // Enter to send
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                smartSendMessage(e);
            }
        });

        // Focus input on load
        setTimeout(() => input.focus(), 300);
    })();
    </script>
</x-layout>
