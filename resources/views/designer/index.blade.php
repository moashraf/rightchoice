<x-layout>
    @section('title')
        {{ App::isLocale('en') ? 'Design Your Apartment' : 'صمم شقتك بنفسك' }}
    @endsection

    <link rel="stylesheet" href="{{ asset('designer/style.css') }}">

    {{-- ═══════════════════════════════════════════════════════
         صمم شقتك بنفسك – Apartment Designer
         ═══════════════════════════════════════════════════════ --}}

    <div class="apartment-designer" id="apartmentDesigner">

        {{-- ═══════════════ TOOLBAR ═══════════════ --}}
        <div class="ad-toolbar">
            {{-- Tools --}}
            <div class="ad-toolbar-group">
                <button class="ad-tbtn active" data-tool="select" title="{{ App::isLocale('en') ? 'Select & Move (V)' : 'اختيار وتحريك (V)' }}">
                    <i class="fas fa-mouse-pointer"></i>
                    <span>{{ App::isLocale('en') ? 'Select' : 'اختيار' }}</span>
                </button>
                <button class="ad-tbtn" data-tool="room" title="{{ App::isLocale('en') ? 'Draw Room (R)' : 'ارسم غرفة (R)' }}">
                    <i class="fas fa-vector-square"></i>
                    <span>{{ App::isLocale('en') ? 'Room' : 'غرفة' }}</span>
                </button>
                <button class="ad-tbtn" data-tool="delete" title="{{ App::isLocale('en') ? 'Delete (D)' : 'حذف (D)' }}">
                    <i class="fas fa-eraser"></i>
                    <span>{{ App::isLocale('en') ? 'Delete' : 'حذف' }}</span>
                </button>
            </div>

            <div class="ad-toolbar-sep"></div>

            {{-- Undo/Redo --}}
            <div class="ad-toolbar-group">
                <button class="ad-tbtn" id="undoBtn" title="Ctrl+Z">
                    <i class="fas fa-undo"></i>
                </button>
                <button class="ad-tbtn" id="redoBtn" title="Ctrl+Y">
                    <i class="fas fa-redo"></i>
                </button>
            </div>

            <div class="ad-toolbar-sep"></div>

            {{-- Zoom --}}
            <div class="ad-toolbar-group">
                <button class="ad-tbtn" id="zoomOut" title="{{ App::isLocale('en') ? 'Zoom Out' : 'تصغير' }}">
                    <i class="fas fa-search-minus"></i>
                </button>
                <span class="ad-zoom-display" id="zoomLevel">100%</span>
                <button class="ad-tbtn" id="zoomIn" title="{{ App::isLocale('en') ? 'Zoom In' : 'تكبير' }}">
                    <i class="fas fa-search-plus"></i>
                </button>
                <button class="ad-tbtn" id="zoomFit" title="{{ App::isLocale('en') ? 'Fit View' : 'ملائمة العرض' }}">
                    <i class="fas fa-expand"></i>
                </button>
            </div>

            <div class="ad-toolbar-sep"></div>

            {{-- Auto Design --}}
            <button class="ad-tbtn ad-tbtn-accent" id="autoDesignBtn">
                <i class="fas fa-magic"></i>
                <span>{{ App::isLocale('en') ? 'Auto Design' : 'تصميم تلقائي' }}</span>
            </button>

            {{-- Clear --}}
            <button class="ad-tbtn" id="clearBtn" title="{{ App::isLocale('en') ? 'Clear All' : 'مسح الكل' }}">
                <i class="fas fa-trash-alt"></i>
            </button>

            {{-- Export --}}
            <button class="ad-tbtn" id="exportBtn" title="{{ App::isLocale('en') ? 'Export JSON' : 'تصدير JSON' }}">
                <i class="fas fa-file-export"></i>
                <span>{{ App::isLocale('en') ? 'Export' : 'تصدير' }}</span>
            </button>
        </div>

        {{-- ═══════════════ LEFT PANEL – Room Palette ═══════════════ --}}
        <div class="ad-left">
            <div class="ad-panel-title">{{ App::isLocale('en') ? 'Room Types' : 'أنواع الغرف' }}</div>
            <div class="ad-palette">
                <button class="ad-room-btn active" data-rtype="bedroom">
                    <span class="ad-rb-icon">🛏️</span>
                    <span>{{ App::isLocale('en') ? 'Bedroom' : 'غرفة نوم' }}</span>
                    <span class="ad-rb-swatch" style="background:#1565C0"></span>
                </button>
                <button class="ad-room-btn" data-rtype="living">
                    <span class="ad-rb-icon">🛋️</span>
                    <span>{{ App::isLocale('en') ? 'Living Room' : 'صالة' }}</span>
                    <span class="ad-rb-swatch" style="background:#E65100"></span>
                </button>
                <button class="ad-room-btn" data-rtype="kitchen">
                    <span class="ad-rb-icon">🍳</span>
                    <span>{{ App::isLocale('en') ? 'Kitchen' : 'مطبخ' }}</span>
                    <span class="ad-rb-swatch" style="background:#AD1457"></span>
                </button>
                <button class="ad-room-btn" data-rtype="bathroom">
                    <span class="ad-rb-icon">🚿</span>
                    <span>{{ App::isLocale('en') ? 'Bathroom' : 'حمام' }}</span>
                    <span class="ad-rb-swatch" style="background:#2E7D32"></span>
                </button>
                <button class="ad-room-btn" data-rtype="balcony">
                    <span class="ad-rb-icon">🌿</span>
                    <span>{{ App::isLocale('en') ? 'Balcony' : 'بلكونة' }}</span>
                    <span class="ad-rb-swatch" style="background:#6A1B9A"></span>
                </button>
                <button class="ad-room-btn" data-rtype="hallway">
                    <span class="ad-rb-icon">🚪</span>
                    <span>{{ App::isLocale('en') ? 'Hallway' : 'مدخل/ممر' }}</span>
                    <span class="ad-rb-swatch" style="background:#37474F"></span>
                </button>
                <button class="ad-room-btn" data-rtype="dining">
                    <span class="ad-rb-icon">🍽️</span>
                    <span>{{ App::isLocale('en') ? 'Dining' : 'سفرة' }}</span>
                    <span class="ad-rb-swatch" style="background:#558B2F"></span>
                </button>
                <button class="ad-room-btn" data-rtype="storage">
                    <span class="ad-rb-icon">📦</span>
                    <span>{{ App::isLocale('en') ? 'Storage' : 'مخزن' }}</span>
                    <span class="ad-rb-swatch" style="background:#4E342E"></span>
                </button>
            </div>

            {{-- Compass --}}
            <div class="ad-compass-section">
                <div class="ad-compass-label">
                    🧭 {{ App::isLocale('en') ? 'North Direction' : 'اتجاه الشمال' }}
                </div>
                <input type="range" id="compassSlider" class="ad-compass-slider" min="0" max="359" value="0">
                <div class="ad-compass-val">0°</div>
            </div>
        </div>

        {{-- ═══════════════ CENTER – Canvas ═══════════════ --}}
        <div class="ad-center">
            <div class="ad-floor-bar" id="floorTabs"></div>
            <div class="ad-canvas-wrap">
                <canvas id="designerCanvas"></canvas>
            </div>
        </div>

        {{-- ═══════════════ RIGHT PANEL – Properties ═══════════════ --}}
        <div class="ad-right">
            <div class="ad-panel-title">{{ App::isLocale('en') ? 'Properties' : 'الخصائص' }}</div>
            <div id="propsPanel">
                <div class="ad-prop-empty">
                    <i class="fas fa-mouse-pointer"></i>
                    <p>{{ App::isLocale('en') ? 'Select a room to edit' : 'اختر غرفة لتعديلها' }}</p>
                </div>
            </div>
        </div>

        {{-- ═══════════════ SUGGESTIONS BAR ═══════════════ --}}
        <div class="ad-suggestions">
            <div class="ad-sug-header">
                <i class="fas fa-lightbulb"></i>
                {{ App::isLocale('en') ? 'Smart Suggestions' : 'اقتراحات ذكية' }}
            </div>
            <div id="suggestionsContent">
                <p class="ad-sug-empty">
                    {{ App::isLocale('en') ? 'Start drawing for smart suggestions! 💡' : 'ابدأ ارسم وهنعطيك اقتراحات ذكية! 💡' }}
                </p>
            </div>
        </div>

        {{-- ═══════════════ AUTO DESIGN MODAL ═══════════════ --}}
        <div class="ad-modal-overlay ad-hidden" id="autoModal">
            <div class="ad-modal">
                <h3>✨ {{ App::isLocale('en') ? 'Auto Design' : 'التصميم التلقائي' }}</h3>
                <p class="ad-modal-sub">
                    {{ App::isLocale('en')
                        ? 'Enter your requirements and we will generate an optimized layout.'
                        : 'ادخل متطلباتك وهننشئلك تصميم متوازن تلقائياً.' }}
                </p>

                <div class="ad-mg">
                    <label>{{ App::isLocale('en') ? 'Total Area (m²)' : 'المساحة الكلية (م²)' }}</label>
                    <input type="number" id="adArea" class="ad-inp" value="120" min="40" max="500" step="10">
                </div>

                <div class="ad-modal-row">
                    <div class="ad-mg">
                        <label>{{ App::isLocale('en') ? 'Bedrooms' : 'غرف النوم' }}</label>
                        <input type="number" id="adBeds" class="ad-inp" value="3" min="1" max="6">
                    </div>
                    <div class="ad-mg">
                        <label>{{ App::isLocale('en') ? 'Bathrooms' : 'الحمامات' }}</label>
                        <input type="number" id="adBaths" class="ad-inp" value="2" min="1" max="4">
                    </div>
                </div>

                <div class="ad-mg">
                    <label>{{ App::isLocale('en') ? 'Orientation (بحري/قبلي)' : 'الاتجاه (بحري/قبلي)' }}</label>
                    <select id="adOrient" class="ad-inp">
                        <option value="N">{{ App::isLocale('en') ? 'North (بحري)' : 'شمال — بحري' }}</option>
                        <option value="NE">{{ App::isLocale('en') ? 'North-East' : 'شمال شرقي' }}</option>
                        <option value="E">{{ App::isLocale('en') ? 'East' : 'شرق' }}</option>
                        <option value="SE">{{ App::isLocale('en') ? 'South-East' : 'جنوب شرقي' }}</option>
                        <option value="S">{{ App::isLocale('en') ? 'South (قبلي)' : 'جنوب — قبلي' }}</option>
                        <option value="SW">{{ App::isLocale('en') ? 'South-West' : 'جنوب غربي' }}</option>
                        <option value="W">{{ App::isLocale('en') ? 'West' : 'غرب' }}</option>
                        <option value="NW">{{ App::isLocale('en') ? 'North-West' : 'شمال غربي' }}</option>
                    </select>
                </div>

                <div class="ad-modal-actions">
                    <button class="ad-modal-btn ad-modal-btn-primary" id="generateBtn">
                        <i class="fas fa-magic"></i>
                        {{ App::isLocale('en') ? 'Generate' : 'إنشاء التصميم' }}
                    </button>
                    <button class="ad-modal-btn ad-modal-btn-ghost" id="autoModalClose">
                        {{ App::isLocale('en') ? 'Cancel' : 'إلغاء' }}
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('designer/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ApartmentDesigner.init({ isArabic: {{ App::isLocale('en') ? 'false' : 'true' }} });

            // Update compass value display
            const slider = document.getElementById('compassSlider');
            const valDisplay = document.querySelector('.ad-compass-val');
            if (slider && valDisplay) {
                slider.addEventListener('input', function() {
                    valDisplay.textContent = this.value + '°';
                });
            }
        });
    </script>
</x-layout>
