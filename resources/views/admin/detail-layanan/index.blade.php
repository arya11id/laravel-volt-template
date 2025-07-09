@extends('layouts.app')

@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Jenis layanan List</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">List Jenis layanan</h1>
            </div>
        </div>
    </div>
    @include('layouts.alert')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive py-4">
                <button class="btn btn-primary mb-3" id="btnAdd">Tambah Jenis layanan</button>
                <table class="table table-bordered" id="detailLayananTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Layanan</th>
                            <th>NIP</th>
                            <th>Nama Pemohon</th>
                            <th>Tgl Pengajuan</th>
                            <th>Tgl Selesai</th>
                            <th>Keterangan</th>
                            <th>Riwayat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="layananModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Detail Layanan</h5>
                </div>
                <div class="modal-body">
                    <form id="formLayanan">
                        <input type="hidden" id="layanan_id">
                        <div class="mb-3">
                            <label class="form-label">Pemohon</label><br>
                            <select name="pemohon_id" id="pemohon_id" class="js-example-basic-single" style="width: 100%">
                                <option value="">Pilih Pemohon</option>
                                @foreach ($pemohon as $pemohon)
                                    <option value="{{ $pemohon->id }}">{{ $pemohon->nip }} - {{ $pemohon->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Layanan</label>
                            <select name="jenis_layanan_id" id="jenis_layanan_id" class="form-select mb-2">
                                <option value="">Pilih Jenis Layanan</option>
                                @foreach ($jenisLayanan as $jenisLayanan)
                                    <option value="{{ $jenisLayanan->id }}">{{ $jenisLayanan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Tanggal Pengajuan</label>
                            <input type="date" name="tgl_pengajuan" id="tgl_pengajuan" class="form-control mb-2">
                        </div>
                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control mb-2" placeholder="Keterangan"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSave">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customCSS')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('customJS')
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#pemohon_id').select2({
                dropdownParent: $('#layananModal')
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function() {

            let table = $('#detailLayananTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('detail-layanan.data') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'jenis_layanan.nama'
                    },
                    {
                        data: 'pemohon.nip'
                    },
                    {
                        data: 'pemohon.nama'
                    },
                    {
                        data: 'tgl_pengajuan'
                    },
                    {
                        data: 'tgl_selesai'
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'riwayat',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#btnAdd').on('click', function() {
                $('#formLayanan')[0].reset();
                $('#layanan_id').val('');
                $('#layananModal').modal('show');
            });

            // $('#btnSave').on('click', function() {
            //     let id = $('#layanan_id').val();
            //     let url = id ? `/detail-layanan/update/${id}` : '{{ route('detail-layanan.store') }}';

            //     $.post(url, $('#formLayanan').serialize(), function() {

            //         $('#layananModal').modal('hide');
            //         table.ajax.reload();
            //     });
            // });
            $('#btnSave').on('click', function() {
                let $btn = $(this);
                let originalText = $btn.text();

                // Disable tombol dan ubah teks
                $btn.prop('disabled', true).text('Menyimpan...');

                let id = $('#layanan_id').val();
                let url = id ? `/detail-layanan/update/${id}` : '{{ route('detail-layanan.store') }}';

                $.post(url, $('#formLayanan').serialize(), function() {
                        $('#layananModal').modal('hide');
                        table.ajax.reload();
                    })
                    .always(function() {
                        // Aktifkan kembali tombol dan reset teks
                        $btn.prop('disabled', false).text(originalText);
                    });
            });


            $('#detailLayananTable').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get(`/detail-layanan/${id}`, function(data) {
                    $('#jenis_layanan_id').val(data.jenis_layanan_id).change();
                    $('#pemohon_id').val(data.pemohon_id).change();
                    // $('#tgl_pengajuan').val(data.tgl_pengajuan);
                    $('#tgl_pengajuan').val(data.tgl_pengajuan ? data.tgl_pengajuan.substr(0, 10) :
                        '');
                    $('#layanan_id').val(data.id);
                    $('#keterangan').val(data.keterangan);
                    $('#layananModal').modal('show');
                });
            });

            $('#detailLayananTable').on('click', '.btn-delete', function() {
                if (confirm('Yakin ingin menghapus?')) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: `/detail-layanan/delete/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            table.ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection
