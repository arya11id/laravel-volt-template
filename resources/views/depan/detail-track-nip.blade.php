@extends('depan.layout-track')

@section('content')
    <section id="starter-section" class="starter-section section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>tracking layanan</h2>
            <div><span>Check </span> <span class="description-title">Detail tracking layanan</span></div>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 rounded-start">tracking layanan</th>
                            <th class="border-0"></th>
                            <th class="border-0 rounded-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Item -->
                        <tr>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">Nama Pemohon</span></div>
                            </td>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">:</span></div>
                            </td>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">{{ $data->pemohon->nama ?? '-' }}</span></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">NIP</span></div>
                            </td>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">:</span></div>
                            </td>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">{{ $data->pemohon->nip ?? '-' }}</span></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">Asal Instansi</span></div>
                            </td>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">:</span></div>
                            </td>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">{{ $data->pemohon->unitKerja->nama ?? '-' }} </span></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">Jenis Layanan</span></div>
                            </td>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">:</span></div>
                            </td>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">{{ $data->jenisLayanan->nama ?? '' }}</span></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">Tanggal Pengajuan</span></div>
                            </td>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">:</span></div>
                            </td>
                            <td class="border-0 rounded-start">
                                <div><span
                                        class="h6">{{ $data->tgl_pengajuan->translatedFormat('d F Y') ?? '-' }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">Keterangan</span></div>
                            </td>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">:</span></div>
                            </td>
                            <td class="border-0 rounded-start">
                                <div><span class="h6">{{ $data->keterangan ?? '-' }}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    <section class="section-header overflow-hidden pt-7 pt-lg-8 pb-9 pb-lg-12 bg-primary text-white">

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
                                            @if ($loop->first)
                                                <span class="spinner-grow spinner-grow-sm" role="status"
                                                    aria-hidden="true"></span>
                                            @else
                                                <i class="bi bi-postcard"></i>
                                            @endif
                                        </div>
                                        <div class="tracking-date">
                                            {{ $list->tgl_layanan->translatedFormat('d F Y') ?? '-' }}</div>
                                        <div class="tracking-content"><span>Status : {{ $list->status->nama }}</span>
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
                                        <i class="bi bi-postcard"></i>
                                    </div>
                                    <div class="tracking-date">
                                        {{ $data->tgl_pengajuan->translatedFormat('d F Y') ?? '-' }}</div>
                                    <div class="tracking-content"><span>Pengajuan layanan :
                                            {{ $data->jenisLayanan->nama }}</span>
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
