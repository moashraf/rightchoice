<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/css/adminlte.min.css"
          integrity="sha512-rVZC4rf0Piwtw/LsgwXxKXzWq3L0P6atiQKBNuXYRbg2FoRbSTIY0k2DxuJcs7dk4e/ShtMzglHKBOJxW8EQyQ=="
          crossorigin="anonymous"/>

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
          integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg=="
          crossorigin="anonymous"/>

    @yield('third_party_stylesheets')

    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <li class="user-header bg-primary">
                        <p>
                            {{ Auth::user()->name }}
                            <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="{{ url('/') }}" class="btn btn-default btn-flat">Back to Site</a>
                        <form action="{{ route('sitemanagement.logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-default btn-flat float-right">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Left side column -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ url('/sitemanagement/blogs') }}" class="brand-link">
            <span class="brand-text font-weight-light">Admin Panel</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.blogs.index') }}" class="nav-link {{ request()->is('sitemanagement/blogs*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-blog"></i>
                            <p>Blogs</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.sliders.index') }}" class="nav-link {{ request()->is('sitemanagement/sliders*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Sliders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.settingSites.index') }}" class="nav-link {{ request()->is('sitemanagement/settingSites*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Site Settings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.requestPhotoSessions.index') }}" class="nav-link {{ request()->is('sitemanagement/requestPhotoSessions*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-camera"></i>
                            <p>Photo Sessions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.priceVips.index') }}" class="nav-link {{ request()->is('sitemanagement/priceVips*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-gem"></i>
                            <p>Price VIP</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.pages.index') }}" class="nav-link {{ request()->is('sitemanagement/pages*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Pages</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.companies.index') }}" class="nav-link {{ request()->is('sitemanagement/companies*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Companies</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.mzayas.index') }}" class="nav-link {{ request()->is('sitemanagement/mzayas*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-star"></i>
                            <p>Mzaya</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.priceingSales.index') }}" class="nav-link {{ request()->is('sitemanagement/priceingSales*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Priceing Sales</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.adminServices.index') }}" class="nav-link {{ request()->is('sitemanagement/adminServices*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-concierge-bell"></i>
                            <p>Services</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.subareas.index') }}" class="nav-link {{ request()->is('sitemanagement/subareas*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map-marker-alt"></i>
                            <p>Sub Areas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.licenseTypes.index') }}" class="nav-link {{ request()->is('sitemanagement/licenseTypes*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-id-card"></i>
                            <p>License Types</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.floors.index') }}" class="nav-link {{ request()->is('sitemanagement/floors*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Floors</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.finishTypes.index') }}" class="nav-link {{ request()->is('sitemanagement/finishTypes*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-paint-roller"></i>
                            <p>Finish Types</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.districts.index') }}" class="nav-link {{ request()->is('sitemanagement/districts*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map"></i>
                            <p>Districts</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.governrates.index') }}" class="nav-link {{ request()->is('sitemanagement/governrates*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-flag"></i>
                            <p>Governrates</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.compounds.index') }}" class="nav-link {{ request()->is('sitemanagement/compounds*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-city"></i>
                            <p>Compounds</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.callTimes.index') }}" class="nav-link {{ request()->is('sitemanagement/callTimes*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-phone-alt"></i>
                            <p>Call Times</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.aqarCategories.index') }}" class="nav-link {{ request()->is('sitemanagement/aqarCategories*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-th-list"></i>
                            <p>Aqar Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.offerTypes.index') }}" class="nav-link {{ request()->is('sitemanagement/offerTypes*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tag"></i>
                            <p>Offer Types</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.notifications.index') }}" class="nav-link {{ request()->is('sitemanagement/notifications*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bell"></i>
                            <p>Notifications</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.contactForms.index') }}" class="nav-link {{ request()->is('sitemanagement/contactForms*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>Contact Forms</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.propertyTypes.index') }}" class="nav-link {{ request()->is('sitemanagement/propertyTypes*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Property Types</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.complaints.index') }}" class="nav-link {{ request()->is('sitemanagement/complaints*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-exclamation-circle"></i>
                            <p>Complaints</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.aqars.index') }}" class="nav-link {{ request()->is('sitemanagement/aqars*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Aqars</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Back to Site</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content">
            @yield('content')
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Admin Panel</strong>
    </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js"
        integrity="sha512-++c7zGcm18AhH83pOIETVReg0dr1Yn8XTRw+0bWSIWAVCAwz1s2PwnSj4z/OOyKlwSXc4RLg3nnjR22q0dhEyA=="
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.2.0/ekko-lightbox.min.js"></script>

<script>
    $(function () {
        bsCustomFileInput.init();
    });
</script>

<script>
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>

@yield('third_party_scripts')

@stack('page_scripts')

</body>
</html>
