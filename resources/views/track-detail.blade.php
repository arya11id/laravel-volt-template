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
    <title>Laravel Volt Template Starter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="Laravel Volt Template Starter">
    <meta name="author" content="Andry">
    <meta name="description" content="Laravel Volt Template Starter">
    <meta name="keywords"
        content="laravel, bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, themesberg, themesberg dashboard, themesberg admin dashboard" />
    <link rel="canonical" href="https://themesberg.com/product/admin-dashboard/volt-premium-bootstrap-5-dashboard">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/img/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/img/favicon/safari-pinned-tab.svg') }}" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Volt CSS -->
    <link type="text/css" href="{{ asset('css/volt.css') }}" rel="stylesheet">
    <style>
        .tracking-detail {
            padding: 3rem 0
        }

        #tracking {
            margin-bottom: 1rem
        }

        [class*=tracking-status-] p {
            margin: 0;
            font-size: 1.1rem;
            color: #fff;
            text-transform: uppercase;
            text-align: center
        }

        [class*=tracking-status-] {
            padding: 1.6rem 0
        }

        .tracking-status-intransit {
            background-color: #65aee0
        }

        .tracking-status-outfordelivery {
            background-color: #f5a551
        }

        .tracking-status-deliveryoffice {
            background-color: #f7dc6f
        }

        .tracking-status-delivered {
            background-color: #4cbb87
        }

        .tracking-status-attemptfail {
            background-color: #b789c7
        }

        .tracking-status-error,
        .tracking-status-exception {
            background-color: #d26759
        }

        .tracking-status-expired {
            background-color: #616e7d
        }

        .tracking-status-pending {
            background-color: #ccc
        }

        .tracking-status-inforeceived {
            background-color: #214977
        }

        .tracking-list {
            border: 1px solid #e5e5e5
        }

        .tracking-item {
            border-left: 1px solid #e5e5e5;
            position: relative;
            padding: 2rem 1.5rem .5rem 2.5rem;
            font-size: .9rem;
            margin-left: 3rem;
            min-height: 5rem
        }

        .tracking-item:last-child {
            padding-bottom: 4rem
        }

        .tracking-item .tracking-date {
            margin-bottom: .5rem;
            color: black;
        }

        .tracking-item .tracking-date span {
            color: #888;
            font-size: 85%;
            padding-left: .4rem
        }

        .tracking-item .tracking-content {
            padding: .5rem .8rem;
            background-color: #2361ce;
            border-radius: .5rem;
        }

        .tracking-item .tracking-content span {
            display: block;
            color: #ffffff;
            font-size: medium;
        }

        .tracking-item .tracking-icon {
            line-height: 2.6rem;
            position: absolute;
            left: -1.3rem;
            width: 2.6rem;
            height: 2.6rem;
            text-align: center;
            border-radius: 50%;
            font-size: 1.1rem;
            background-color: #fff;
            color: #fff
        }

        .tracking-item .tracking-icon.status-sponsored {
            background-color: #f68
        }

        .tracking-item .tracking-icon.status-delivered {
            background-color: #4cbb87
        }

        .tracking-item .tracking-icon.status-outfordelivery {
            background-color: #f5a551
        }

        .tracking-item .tracking-icon.status-deliveryoffice {
            background-color: #f7dc6f
        }

        .tracking-item .tracking-icon.status-attemptfail {
            background-color: #b789c7
        }

        .tracking-item .tracking-icon.status-exception {
            background-color: #d26759
        }

        .tracking-item .tracking-icon.status-inforeceived {
            background-color: #214977
        }

        .tracking-item .tracking-icon.status-intransit {
            color: #2361ce;
            border: 1px solid #e5e5e5;
            font-size: .9rem
        }

        @media(min-width:992px) {
            .tracking-item {
                margin-left: 10rem
            }

            .tracking-item .tracking-date {
                position: absolute;
                left: -10rem;
                width: 7.5rem;
                text-align: right;
                color: black
            }

            .tracking-item .tracking-date span {
                display: block
            }

            .tracking-item .tracking-content {
                padding: 10;
                background-color: #2361ce
            }
        }
    </style>

</head>

<body>
    <main>
        <section class="section-header overflow-hidden pt-7 pt-lg-8 pb-9 pb-lg-12 bg-primary text-white">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="fw-bolder">tracking layanan</h2>
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-6">
                    <div class="mb-3 mb-lg-0">
                        <h1 class="h4">Nama Pemohon : {{ $data->pemohon->nama ?? '-' }}</h1>
                        <p class="mb-0">NIP : {{ $data->pemohon->nip ?? '-' }}</p>
                        <p class="mb-0">Asal Instansi : {{ $data->pemohon->asal_instansi ?? '-' }}</p>
                        <p class="mb-0">Jenis Layanan : {{ $data->jenisLayanan->nama }}</p>
                        <p class="mb-0">Tanggal Pengajuan :
                            {{ $data->tgl_pengajuan->translatedFormat('d F Y') ?? '-' }}</p>
                        <p class="mb-0">Keterangan : {{ $data->keterangan ?? '-' }}</p>

                    </div>
                </div>
            </div>
            <br />
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <h2>TRACK INFO</h2>
                        <div class="row">

                            <div class="col-md-12 col-lg-12">

                                <div class="tracking-list">
                                    @foreach ($tracking as $list)
                                        <div class="tracking-item">
                                            <div class="tracking-icon status-intransit">
                                                <i class="fa fa-book"></i>
                                            </div>
                                            <div class="tracking-date">
                                                {{ $list->tgl_layanan->translatedFormat('d F Y') ?? '-' }}</div>
                                            <div class="tracking-content">Status : {{ $list->status->nama }}
                                                <span>keterangan : {{ $list->keterangan ?? '-' }}</span>
                                                @if ($list->url_file != null)
                                                    <a href="{{ $list->url_file ?? '-' }}" target="_blank"
                                                        class="btn btn-primary btn-sm">Lihat File</a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="tracking-item">
                                        <div class="tracking-icon status-intransit">
                                            {{-- <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                    </svg> --}}
                                            <i class="fa fa-book"></i>
                                        </div>
                                        <div class="tracking-date">
                                            {{ $data->tgl_pengajuan->translatedFormat('d F Y') ?? '-' }}</div>
                                        <div class="tracking-content">Pengajuan layanan :
                                            {{ $data->jenisLayanan->nama }}
                                            <span>keterangan:{{ $data->keterangan ?? '-' }}</span>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
