<!--

=========================================================
* Volt Free - Bootstrap 5 Dashboard
=========================================================

* Product Page: https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard
* Copyright 2021 Themesberg (https://www.themesberg.com)

* Designed and coded by https://themesberg.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. Please contact us to request a removal. Contact us if you want to remove it.

-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>Dinas Pendidikan Cabang Wilayah Kediri</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="Dinas Pendidikan Cabang Wilayah Kediri">
    <meta name="author" content="Andry">
    <meta name="description" content="Dinas Pendidikan Cabang Wilayah Kediri">
    <meta name="keywords" content="DinasPendidikanCabangWilayahKediri" />
    <link rel="canonical" href="https://themesberg.com/product/admin-dashboard/volt-premium-bootstrap-5-dashboard">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="https://dindik.jatimprov.go.id/assets/images/favicon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="https://dindik.jatimprov.go.id/assets/images/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="https://dindik.jatimprov.go.id/assets/images/favicon.png">
    <link rel="manifest" href="{{ asset('assets/img/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/img/favicon/safari-pinned-tab.svg') }}" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Volt CSS -->
    <link type="text/css" href="{{ asset('css/volt.css') }}" rel="stylesheet">
    @yield('css')

</head>

<body>
    <main>
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-dark navbar-theme-primary mb-4">
            <div class="container position-relative">
                <a class="navbar-brand me-lg-3" href="#">
                    <img class="navbar-brand-dark" src="https://dindik.jatimprov.go.id/assets/images/logo/logo.png"
                        alt="menuimage">
                </a>
                <div class="navbar-collapse collapse w-100" id="navbar-default-primary">
                    <div class="navbar-collapse-header">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                <a href="/">
                                    <img src="https://dindik.jatimprov.go.id/assets/images/logo/logo.png"
                                        alt="menuimage">
                                </a>
                            </div>
                            <div class="col-6 collapse-close">
                                <i class="fas fa-times" data-toggle="collapse" role="button"
                                    data-target="#navbar-default-primary" aria-controls="navbar-default-primary"
                                    aria-expanded="false" aria-label="Toggle navigation"></i>
                            </div>
                        </div>
                    </div>
                    <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                        <li class="nav-item">
                            <a href="/" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="/track" class="nav-link">track</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Contact</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-items-center">
                    <button class="navbar-toggler ms-2" type="button" data-toggle="collapse"
                        data-target="#navbar-default-primary" aria-controls="navbar-default-primary"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </nav>
        @yield('content')
    </main>

    <footer class="footer py-6 mt-5 bg-gray-800 text-white">
        <div class="container">
            <div class="row">
                <div class="col mb-md-0">
                    <div class="d-flex text-center justify-content-center align-items-center" role="contentinfo">
                        <p class="fw-normal font-small mb-0">Copyright © Themesberg 2019-<span
                                class="current-year">2021</span>. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Core -->
    <script src="{{ asset('vendor/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Vendor JS -->
    <script src="{{ asset('vendor/onscreen/dist/on-screen.umd.min.js') }}"></script>

    <!-- FA Icon -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" crossorigin="anonymous"></script>

</body>

</html>
