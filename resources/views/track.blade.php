@extends('layouts.home')

@section('content')
    <section class="section-header overflow-hidden pt-7 pt-lg-8 pb-9 pb-lg-12 bg-primary text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="fw-bolder">tracking layanan</h2>
                    @include('layouts.alert')
                </div>
            </div>
            <div class="d-flex justify-content-center gap-6">

                <form action="{{ route('track') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">NIP</label>
                        <input type="number" class="form-control" id="nip" name="nip"
                            aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
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
                                            <th scope="col">Keterangan</th>
                                            <th scope="col">Tanggal Pengajuan</th>
                                            <th scope="col">Tanggal Selesai</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    @if ($tracking != '')
                                        <tbody>
                                            @foreach ($tracking as $item)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $item->jenisLayanan->nama }}</td>
                                                    <td>{{ $item->keterangan }}</td>
                                                    <td>{{ $item->tgl_pengajuan ? $item->tgl_pengajuan->format('d-m-Y') : '-' }}
                                                    </td>
                                                    <td>{{ $item->tgl_selesai ? $item->tgl_selesai->format('d-m-Y') : '-' }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('track-detail', $item->uuid) }}"
                                                            class="btn btn-primary">Detail</a>
                                                    </td>
                                                </tr>
                                            @endforeach
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
