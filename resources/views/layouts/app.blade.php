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
    <!-- Di dalam <head> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Volt CSS -->
    <link type="text/css" href="{{ asset('css/volt.css') }}" rel="stylesheet">

    @yield('customCSS')
</head>

<body>
    @include('layouts.navbar')
    @include('layouts.sidebar')
    <main class="content">
        @include('layouts.topbar')
        <div class="container mb-5">
            @yield('content')
        </div>
    </main>
    <!-- Core -->
    <script src="{{ asset('vendor/@popperjs/core/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Vendor JS -->
    <script src="{{ asset('vendor/onscreen/dist/on-screen.umd.min.js') }}"></script>

    <!-- FA Icon -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" crossorigin="anonymous"></script>
     
    @yield('customJS')
</body>

</html>
