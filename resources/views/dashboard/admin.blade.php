@extends('layouts.app')

@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Dashboard</h1>
                <p class="mb-0">Show the summary of all informations in system</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="row">
            <div class="col-12 col-sm-6 col-xl-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="h5">Jumlah Data Proses</h2>
                                    <h3 class="fw-extrabold mb-1">{{ $proses }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h6 text-gray-400 mb-0">Jumlah Data Proses</h2>
                                    <h3 class="fw-extrabold mb-2">{{ $proses }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="h5">Jumlah Data Selesai</h2>
                                    <h3 class="fw-extrabold mb-1">{{ $selesai }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h6 text-gray-400 mb-0">Jumlah Data Selesai</h2>
                                    <h3 class="fw-extrabold mb-2">{{ $selesai }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Data Jumlah Peserta Didik Aktif di Kota Kediri</h1>
                <p class="mb-0">Pembaruan terakhir: {{ $formattedDate }} (diperbarui mingguan) </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 rounded">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0 rounded-start">Kecamatan</th>
                                    <th class="border-0">SMA/Sederajat</th>
                                    <th class="border-0">SMK/Sederajat</th>
                                    <th class="border-0">SLB/Sederajat</th>
                                    <th class="border-0">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Item -->
                                @foreach ($list['data'] as $listItem)
                                    @php
                                        $dn = [
                                            'nama' => $listItem['district']['namaWilayah'],
                                            'kode' => $listItem['district']['kodeWilayah'],
                                            'wilayah' => 'Kota Kediri',
                                            'formattedDateKab' => $formattedDate,
                                        ];
                                    @endphp
                                    <tr>
                                        <td class="border-0">
                                            <div><span class="h6">{{ $listItem['district']['namaWilayah'] }}</span>
                                            </div>
                                        </td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listItem['pesertaDidikStatistics']['smaSederajat'] }}</td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listItem['pesertaDidikStatistics']['smkSederajat'] }}</td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listItem['pesertaDidikStatistics']['slb'] }}</td>
                                        <td><a href="{{ route('dashboard.detail.kecamatan', Crypt::encrypt($dn)) }}"
                                                class="btn btn-sm btn-primary">detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Data Jumlah Peserta Didik Aktif di Kabupaten Kediri</h1>
                <p class="mb-0">Pembaruan terakhir: {{ $formattedDateKab }} (diperbarui mingguan) </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 rounded">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0 rounded-start">Kecamatan</th>
                                    <th class="border-0">SMA/Sederajat</th>
                                    <th class="border-0">SMK/Sederajat</th>
                                    <th class="border-0">SLB/Sederajat</th>
                                    <th class="border-0">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Item -->
                                @foreach ($listKab['data'] as $listx)
                                    @php
                                        $dn = [
                                            'nama' => $listx['district']['namaWilayah'],
                                            'kode' => $listx['district']['kodeWilayah'],
                                            'wilayah' => 'Kabupaten Kediri',
                                            'formattedDateKab' => $formattedDateKab,
                                        ];
                                    @endphp
                                    <tr>
                                        <td class="border-0">
                                            <div><span class="h6">{{ $listx['district']['namaWilayah'] }}</span>
                                            </div>
                                        </td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listx['pesertaDidikStatistics']['smaSederajat'] }}</td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listx['pesertaDidikStatistics']['smkSederajat'] }}</td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listx['pesertaDidikStatistics']['slb'] }}</td>
                                        <td><a href="{{ route('dashboard.detail.kecamatan', Crypt::encrypt($dn)) }}"
                                                class="btn btn-sm btn-primary">detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
