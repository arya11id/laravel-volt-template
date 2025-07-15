@extends('layouts.home')

@section('content')
    <section class="section-header overflow-hidden pt-7 pt-lg-8 pb-9 pb-lg-12 bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fw-bolder">tracking layanan surat</h2>
                    @include('layouts.alert')
                </div>
            </div>
            <div class="d-flex justify-content-center gap-12">

                <form action="{{ route('track-surat') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nomor Surat</label>
                        <input type="text" class="form-control" id="no_surat" name="no_surat"
                            aria-describedby="no_surat" required>
                    </div>
                    <button type="submit" class="btn btn-info">Cari</button>
                </form>
            </div>
        </div>

        <br />
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <h2>TRACK INFO</h2>
                    <div class="row">

                        <div class="col-md-12 col-lg-12">
                            <div class="table-responsive">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Jenis Layanan</th>
                                            <th scope="col">Nomor Surat</th>
                                            <th scope="col">Tanggal Surat</th>
                                            <th scope="col">Keterangan</th>
                                            <th scope="col">Tanggal Pengajuan</th>
                                            <th scope="col">Tanggal Selesai</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    @if ($tracking != '')
                                        <tbody>
                                            {{-- @foreach ($tracking as $tracking) --}}
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>{{ $tracking->jenisLayanan->nama }}</td>
                                                <td>{{ $tracking->no_surat }}</td>
                                                <td>{{ $tracking->tgl_surat ? $tracking->tgl_surat->format('d-m-Y') : '-' }}
                                                </td>
                                                <td>{{ $tracking->keterangan }}</td>
                                                <td>{{ $tracking->tgl_pengajuan ? $tracking->tgl_pengajuan->format('d-m-Y') : '-' }}
                                                </td>
                                                <td>{{ $tracking->tgl_selesai ? $tracking->tgl_selesai->format('d-m-Y') : '-' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('track-surat-detail', $tracking->uuid) }}"
                                                        class="btn btn-primary">Detail</a>
                                                </td>
                                            </tr>
                                            {{-- @endforeach --}}
                                        </tbody>
                                    @else
                                        <tbody>
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data</td>
                                            </tr>
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </section>
@endsection
