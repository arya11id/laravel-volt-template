@extends('layouts.app')

@section('content')
    <div class="py-4">
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Data Jumlah Peserta Didik Aktif di {{ $code['wilayah'] }}, Kecamatan {{ $code['kode'] }}
                </h1>
                <p class="mb-0">Pembaruan terakhir: {{ $formattedDate }} (diperbarui mingguan), total data :
                    {{ $data['meta']['total'] }} </p>
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
                                    <th class="border-0 rounded-start">No</th>
                                    <th class="border-0 rounded-start">NPSN</th>
                                    <th class="border-0">Nama Satuan Pendidikan</th>
                                    <th class="border-0">Alamat</th>
                                    <th class="border-0">Kelurahan</th>
                                    <th class="border-0">Peserta Didik</th>
                                    <th class="border-0 rounded-end">Rombel</th>
                                    <th class="border-0 rounded-end">Bentuk</th>
                                    <th class="border-0 rounded-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Item -->
                                @foreach ($data['data'] as $listx)
                                    <tr>
                                        <td class="border-0">
                                            <div><span class="h6">{{ $loop->iteration + $page }}</span></div>
                                        </td>
                                        <td class="border-0">
                                            <div><span class="h6">{{ $listx['npsn'] }}</span>
                                            </div>
                                        </td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listx['nama'] }}</td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listx['alamatJalan'] }}</td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listx['namaDesa'] }}</td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listx['jumlahPesertaDidik'] }}</td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listx['totalRombel'] }}</td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listx['bentukPendidikanGroup'] }}</td>
                                        <td class="border-0 font-weight-bold">
                                            {{ $listx['statusSatuanPendidikan'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @php
                            $dn = [
                                'nama' => $code['nama'],
                                'kode' => $code['kode'],
                                'wilayah' => $code['wilayah'],
                                'formattedDateKab' => $formattedDate,
                            ];
                        @endphp

                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination mb-0">
                            @if ($totalPages > 0)
                                {{-- @if ($page > 0)
                                    <li class="page-item"><a class="page-link"
                                            href="{{ route('dashboard.detail.kecamatan.page', [Crypt::encrypt($dn), ($page - 1) * 20]) }}">Previous</a>
                                    </li>
                                @endif --}}

                                @for ($i = 0; $i < $totalPages; $i++)
                                    @if ($i * 20 == $page)
                                        <li class="page-item active" aria-current="page">
                                        @else
                                        <li class="page-item">
                                    @endif
                                    <a class="page-link"
                                        href="{{ route('dashboard.detail.kecamatan.page', [Crypt::encrypt($dn), $i * 20]) }}">
                                        @if ($i * 20 == $page)
                                            <strong>{{ $i + 1 }}</strong>
                                        @else
                                            {{ $i + 1 }}
                                        @endif
                                    </a>
                                    </li>
                                @endfor

                                {{-- @if ($page < $totalPages - 1)
                                    <li class="page-item"><a class="page-link"
                                            href="{{ route('dashboard.detail.kecamatan.page', [Crypt::encrypt($dn), ($page + 1) * 20]) }}">Next</a>
                                    </li>
                                @endif --}}
                            @endif

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
