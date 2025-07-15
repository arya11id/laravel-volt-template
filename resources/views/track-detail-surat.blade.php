@extends('layouts.home')
@section('css')
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
@endsection
@section('content')
    <section class="overflow-hidden pt-lg-8 pb-lg-12 bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fw-bolder"></h2>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-6">
                {{-- <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Nama Pemohon : {{ $data->pemohon->nama ?? '-' }}</h1>
                    <p class="mb-0">NIP : {{ $data->pemohon->nip ?? '-' }}</p>
                    <p class="mb-0">Asal Instansi : {{ $data->pemohon->asal_instansi ?? '-' }}</p>
                    <p class="mb-0">Jenis Layanan : {{ $data->jenisLayanan->nama }}</p>
                    <p class="mb-0">Tanggal Pengajuan :
                        {{ $data->tgl_pengajuan->translatedFormat('d F Y') ?? '-' }}</p>
                    <p class="mb-0">Keterangan : {{ $data->keterangan ?? '-' }}</p>

                </div> --}}
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0 rounded">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0 rounded-start">tracking layanan by surat</th>
                                <th class="border-0"></th>
                                <th class="border-0 rounded-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Item -->
                            <tr>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">Nomor Surat</span></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">:</span></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">{{ $data->no_surat }}</span></div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">Keterangan</span></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">:</span></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">{{ $data->keterangan }}</span></div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">Tanggal Surat</span></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">:</span></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">{{ $data->tgl_surat->translatedFormat('d F Y') }}</span>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">Jenis Layanan</span></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">:</span></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">{{ $data->jenisLayanan->nama ?? '' }}</span></div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">Tanggal Pengajuan</span></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">:</span></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span
                                                class="h6">{{ $data->tgl_pengajuan->translatedFormat('d F Y') ?? '-' }}</span>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">Url File</span></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">:</span></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <a href="#" class="d-flex align-items-center">
                                        <div><span class="h6">
                                                @if ($data->url_file != null)
                                                    <a href="{{ $data->url_file ?? '-' }}" target="_blank"
                                                        class="btn btn-secondary btn-sm">Lihat File</a>
                                                @endif
                                            </span>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
@endsection
