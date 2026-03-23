<x-layout>


{{-- Map page CSS --}}
<link rel="stylesheet" href="{{ asset('assets/css/map.css') }}">

{{-- Google Maps JS (replace YOUR_API_KEY in .env with GOOGLE_MAPS_API_KEY) --}}
<style>
    /* Ensure footer doesn't interfere with map layout */
    .map-page-wrapper { margin-top: -20px; }
</style>

<!-- ================================================================== -->
<!-- MAP PAGE                                                           -->
<!-- ================================================================== -->
<div class="map-page-wrapper">

    <div class="map-container-row">

        <!-- ── Filter Sidebar ──────────────────────────────────────── -->
        <aside class="map-filter-sidebar" id="filterSidebar">
            <div class="filter-header">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: -3px; margin-left:6px; margin-right:6px;">
                        <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .39.812l-4.89 6.1V13.5a.5.5 0 0 1-.26.44l-2 1A.5.5 0 0 1 6.5 14.5V7.912L1.61 1.812A.5.5 0 0 1 1.5 1.5z"/>
                    </svg>
                    {{ App::isLocale('en') ? 'Filters' : 'تصفية البحث' }}
                </h3>
                <span class="filter-count" id="resultCount">0</span>
                <button class="filter-close-btn" id="closeSidebar" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Search by keyword --}}
            <div class="map-filter-group">
                <label>{{ App::isLocale('en') ? 'Search' : 'بحث بالعنوان' }}</label>
                <input type="text" id="filterSearch" placeholder="{{ App::isLocale('en') ? 'Property title or location...' : 'عنوان العقار أو الموقع...' }}">
            </div>

            {{-- Governorate filter --}}
            <div class="map-filter-group">
                <label>{{ App::isLocale('en') ? 'Governorate' : 'المحافظة' }}</label>
                <select id="filterGovernorate">
                    <option value="">{{ App::isLocale('en') ? 'All Governorates' : 'كل المحافظات' }}</option>
                    @foreach($governrates as $gov)
                        <option value="{{ $gov->id }}">
                            {{ App::isLocale('en') && $gov->governrate_en ? $gov->governrate_en : $gov->governrate }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Property type filter --}}
            <div class="map-filter-group">
                <label>{{ App::isLocale('en') ? 'Property Type' : 'نوع العقار' }}</label>
                <select id="filterPropertyType">
                    <option value="">{{ App::isLocale('en') ? 'All Types' : 'كل الأنواع' }}</option>
                    @foreach($propertyTypes as $pt)
                        <option value="{{ $pt->id }}">
                            {{ App::isLocale('en') && $pt->property_type_en ? $pt->property_type_en : $pt->property_type }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Action buttons --}}
            <div class="map-filter-actions">
                <button class="btn-map-search" id="btnApplyFilter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242.156a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/>
                    </svg>
                    {{ App::isLocale('en') ? 'Search' : 'بحث' }}
                </button>
                <button class="btn-map-reset" id="btnResetFilter">
                    {{ App::isLocale('en') ? 'Reset' : 'مسح' }}
                </button>
            </div>

            <hr style="border-color:#eef1f6; margin-bottom:16px;">

            {{-- Results summary --}}
            <div id="filterSummary" style="font-size:0.85rem; color:#718096; line-height:1.6;">
                <p id="summaryText">{{ App::isLocale('en') ? 'Showing all properties on the map.' : 'عرض جميع العقارات على الخريطة.' }}</p>
            </div>
        </aside>

        <!-- ── Map Area ────────────────────────────────────────────── -->
        <div class="map-area">
            <div id="propertyMap"></div>

            {{-- Loading overlay --}}
            <div class="map-loading-overlay" id="mapLoading">
                <div class="map-spinner"></div>
                <div class="map-loading-text">{{ App::isLocale('en') ? 'Loading properties...' : 'جاري تحميل العقارات...' }}</div>
            </div>

            {{-- Empty state --}}
            <div class="map-empty-state" id="mapEmpty">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#a0aec0" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                </svg>
                <h4>{{ App::isLocale('en') ? 'No properties found' : 'لا توجد عقارات' }}</h4>
                <p>{{ App::isLocale('en') ? 'Try adjusting your filters to see more results.' : 'حاول تعديل الفلاتر لعرض نتائج أكثر.' }}</p>
            </div>
        </div>

    </div>

    {{-- Mobile filter toggle button --}}
    <button class="map-filter-toggle" id="btnToggleFilter">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .39.812l-4.89 6.1V13.5a.5.5 0 0 1-.26.44l-2 1A.5.5 0 0 1 6.5 14.5V7.912L1.61 1.812A.5.5 0 0 1 1.5 1.5z"/>
        </svg>
        {{ App::isLocale('en') ? 'Filters' : 'الفلاتر' }}
    </button>

    {{-- Mobile overlay --}}
    <div class="map-filter-overlay" id="filterOverlay"></div>

</div>

<!-- ================================================================== -->
<!-- SCRIPTS                                                            -->
<!-- ================================================================== -->

{{-- Google Maps API --}}
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key', '') }}&libraries=marker&callback=Function.prototype" async defer></script>

{{-- MarkerClusterer library --}}
<script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>

<script>
/**
 * Wait for jQuery to be available (loaded after slot in layout),
 * then wait for Google Maps, then boot the map application.
 */
(function waitForJQuery() {
    if (typeof window.jQuery === 'undefined') {
        return setTimeout(waitForJQuery, 100);
    }

    // jQuery is ready — boot the map app
    jQuery(function($) {
        'use strict';

        // ── Configuration ──────────────────────────────────────────────
        var API_URL        = "{{ route('api.map.aqars') }}";
        var DEFAULT_CENTER = { lat: 30.0444, lng: 31.2357 }; // Cairo, Egypt
        var DEFAULT_ZOOM   = 7;
        var LOCALE         = "{{ App::getLocale() }}";

        var map, markers = [], markerCluster, infoWindow;

        // ── DOM Elements ───────────────────────────────────────────────
        var $filterGov     = $('#filterGovernorate');
        var $filterType    = $('#filterPropertyType');
        var $filterSearch  = $('#filterSearch');
        var $resultCount   = $('#resultCount');
        var $summaryText   = $('#summaryText');
        var $mapLoading    = $('#mapLoading');
        var $mapEmpty      = $('#mapEmpty');
        var $sidebar       = $('#filterSidebar');
        var $overlay       = $('#filterOverlay');

        // ── Initialize Map ─────────────────────────────────────────────
        function initMap() {
            map = new google.maps.Map(document.getElementById('propertyMap'), {
                center: DEFAULT_CENTER,
                zoom: DEFAULT_ZOOM,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                    position: google.maps.ControlPosition.TOP_LEFT
                },
                streetViewControl: false,
                fullscreenControl: true,
                zoomControl: true,
                styles: [
                    {
                        featureType: "poi",
                        elementType: "labels",
                        stylers: [{ visibility: "off" }]
                    }
                ]
            });

            infoWindow = new google.maps.InfoWindow();

            // Load initial data
            loadProperties();
        }

        // ── Fetch Properties ───────────────────────────────────────────
        function loadProperties() {
            showLoading(true);
            hideEmpty();

            var params = {};
            if ($filterGov.val())    params.governrate_id = $filterGov.val();
            if ($filterType.val())   params.property_type = $filterType.val();
            if ($filterSearch.val()) params.search = $filterSearch.val();

            $.ajax({
                url: API_URL,
                type: 'GET',
                data: params,
                dataType: 'json',
                success: function(response) {
                    clearMarkers();

                    if (response.success && response.data.length > 0) {
                        placeMarkers(response.data);
                        fitBounds(response.data);
                        $resultCount.text(response.count);
                        updateSummary(response.count);
                    } else {
                        $resultCount.text('0');
                        updateSummary(0);
                        showEmpty();
                    }

                    showLoading(false);
                },
                error: function() {
                    showLoading(false);
                    $resultCount.text('0');
                    updateSummary(0);
                    showEmpty();
                }
            });
        }

        // ── Place Markers ──────────────────────────────────────────────
        function placeMarkers(properties) {
            properties.forEach(function(prop) {
                var position = { lat: prop.lat, lng: prop.lon };

                var marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: prop.title,
                    icon: {
                        url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(
                            '<svg xmlns="http://www.w3.org/2000/svg" width="36" height="48" viewBox="0 0 36 48">' +
                            '<path d="M18 0C8.06 0 0 8.06 0 18c0 13.5 18 30 18 30s18-16.5 18-30C36 8.06 27.94 0 18 0z" fill="#196aa2"/>' +
                            '<circle cx="18" cy="18" r="8" fill="#fff"/>' +
                            '<path d="M14 16h8v1h-8zM14 19h8v1h-8zM14 22h5v1h-5z" fill="#196aa2"/>' +
                            '</svg>'
                        ),
                        scaledSize: new google.maps.Size(36, 48),
                        anchor: new google.maps.Point(18, 48)
                    },
                    optimized: true
                });

                marker.propertyData = prop;

                marker.addListener('click', function() {
                    openInfoWindow(marker);
                });

                markers.push(marker);
            });

            // Marker Clustering
            if (typeof markerClusterer !== 'undefined' && markerClusterer.MarkerClusterer) {
                markerCluster = new markerClusterer.MarkerClusterer({
                    map: map,
                    markers: markers,
                    renderer: {
                        render: function(cluster, stats) {
                            var count = cluster.count;
                            var position = cluster.position;
                            var size = Math.min(60, 35 + Math.floor(count / 5) * 3);
                            var svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' + size + '" height="' + size + '" viewBox="0 0 ' + size + ' ' + size + '">' +
                                '<circle cx="' + (size/2) + '" cy="' + (size/2) + '" r="' + (size/2-2) + '" fill="rgba(25,106,162,0.85)" stroke="#fff" stroke-width="3"/>' +
                                '<text x="50%" y="53%" text-anchor="middle" dy=".3em" fill="#fff" font-size="14" font-weight="700">' + count + '</text>' +
                                '</svg>';

                            return new google.maps.Marker({
                                position: position,
                                icon: {
                                    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg),
                                    scaledSize: new google.maps.Size(size, size),
                                    anchor: new google.maps.Point(size/2, size/2)
                                },
                                zIndex: Number(google.maps.Marker.MAX_ZINDEX) + count
                            });
                        }
                    }
                });
            }
        }

        // ── Info Window ────────────────────────────────────────────────
        function openInfoWindow(marker) {
            var p = marker.propertyData;

            var priceHtml = '';
            if (p.price_formatted) {
                priceHtml = '<div class="info-price">' + p.price_formatted + ' <span>' + (LOCALE === 'en' ? 'EGP' : 'ج.م') + '</span></div>';
            }

            var metaHtml = '';
            if (p.rooms || p.baths || p.total_area) {
                metaHtml = '<div class="info-meta">';
                if (p.rooms) {
                    metaHtml += '<span class="info-meta-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M7 14c1.66 0 3-1.34 3-3S8.66 8 7 8s-3 1.34-3 3 1.34 3 3 3zm0-4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM19 7h-8v7H3V5H1v15h2v-3h18v3h2v-9c0-2.21-1.79-4-4-4z"/></svg> ' + p.rooms + '</span>';
                }
                if (p.baths) {
                    metaHtml += '<span class="info-meta-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M7 7c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2zm13 7V4h-2v6H8.83C9.52 9.27 10 8.2 10 7c0-2.21-1.79-4-4-4S2 4.79 2 7h2c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2H1v4c0 2.21 1.79 4 4 4v3h2v-3h10v3h2v-3c2.21 0 4-1.79 4-4h-5zm-5 2H5c-1.1 0-2-.9-2-2v-1h14v1c0 1.1-.9 2-2 2z"/></svg> ' + p.baths + '</span>';
                }
                if (p.total_area) {
                    metaHtml += '<span class="info-meta-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/></svg> ' + p.total_area + ' ' + (LOCALE === 'en' ? 'm²' : 'م²') + '</span>';
                }
                metaHtml += '</div>';
            }

            var descHtml = '';
            if (p.description) {
                descHtml = '<p class="info-description">' + p.description + '</p>';
            }

            var content = '<div class="map-info-card">' +
                '<img class="info-image" src="' + p.image_url + '" alt="' + p.title + '" onerror="this.src=\'' + "{{ asset('assets/img/placeholder.png') }}" + '\'">' +
                '<div class="info-body">' +
                    (p.property_type ? '<span class="info-type-badge">' + p.property_type + '</span>' : '') +
                    '<h4 class="info-title">' + p.title + '</h4>' +
                    (p.governorate ? '<div class="info-location"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#718096"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg> ' + p.governorate + '</div>' : '') +
                    descHtml +
                    metaHtml +
                    '<div class="info-footer">' +
                        priceHtml +
                        '<a href="' + p.detail_url + '" class="info-link" target="_blank">' +
                            (LOCALE === 'en' ? 'Details' : 'التفاصيل') +
                            ' <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>' +
                        '</a>' +
                    '</div>' +
                '</div>' +
            '</div>';

            infoWindow.setContent(content);
            infoWindow.open(map, marker);
        }

        // ── Fit Map Bounds ─────────────────────────────────────────────
        function fitBounds(properties) {
            if (!properties.length) return;

            var bounds = new google.maps.LatLngBounds();
            properties.forEach(function(p) {
                bounds.extend({ lat: p.lat, lng: p.lon });
            });
            map.fitBounds(bounds, { top: 50, right: 50, bottom: 50, left: 50 });

            // Don't zoom in too much for a single marker
            var listener = google.maps.event.addListener(map, 'idle', function() {
                if (map.getZoom() > 16) map.setZoom(16);
                google.maps.event.removeListener(listener);
            });
        }

        // ── Clear Markers ──────────────────────────────────────────────
        function clearMarkers() {
            if (markerCluster) {
                markerCluster.clearMarkers();
                markerCluster = null;
            }
            markers.forEach(function(m) { m.setMap(null); });
            markers = [];
            infoWindow && infoWindow.close();
        }

        // ── UI Helpers ─────────────────────────────────────────────────
        function showLoading(show) {
            $mapLoading.toggleClass('hidden', !show);
        }

        function showEmpty() {
            $mapEmpty.addClass('visible');
        }

        function hideEmpty() {
            $mapEmpty.removeClass('visible');
        }

        function updateSummary(count) {
            var msg;
            if (count > 0) {
                msg = LOCALE === 'en'
                    ? 'Showing <strong>' + count + '</strong> properties on the map.'
                    : 'عرض <strong>' + count + '</strong> عقار على الخريطة.';
            } else {
                msg = LOCALE === 'en'
                    ? 'No properties match your filters.'
                    : 'لا توجد عقارات تطابق الفلاتر المحددة.';
            }
            $summaryText.html(msg);
        }

        // ── Mobile Sidebar Toggle ──────────────────────────────────────
        $('#btnToggleFilter').on('click', function() {
            $sidebar.addClass('open');
            $overlay.addClass('active');
        });

        $('#closeSidebar, #filterOverlay').on('click', function() {
            $sidebar.removeClass('open');
            $overlay.removeClass('active');
        });

        // ── Filter Events ──────────────────────────────────────────────
        $('#btnApplyFilter').on('click', function() {
            loadProperties();
            $sidebar.removeClass('open');
            $overlay.removeClass('active');
        });

        $('#btnResetFilter').on('click', function() {
            $filterGov.val('');
            $filterType.val('');
            $filterSearch.val('');
            loadProperties();
        });

        $filterSearch.on('keypress', function(e) {
            if (e.which === 13) {
                loadProperties();
                $sidebar.removeClass('open');
                $overlay.removeClass('active');
            }
        });

        // ── Init on Google Maps ready ──────────────────────────────────
        function waitForGoogleMaps() {
            if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
                initMap();
            } else {
                setTimeout(waitForGoogleMaps, 200);
            }
        }

        waitForGoogleMaps();

    }); // end jQuery ready
})(); // end waitForJQuery
</script>

</x-layout>
