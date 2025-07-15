@extends('layouts.app')

@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Jenis layanan Surat</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">List Jenis layanan Surat</h1>
            </div>
        </div>
    </div>
    @include('layouts.alert')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive py-4">
                <a class="btn btn-success" href="javascript:void(0)" id="createNewLayananSurat">
                    <i class="fas fa-plus"></i> Tambah Layanan Surat
                </a>
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Surat</th>
                            <th>Tgl. Surat</th>
                            <th>Keterangan</th>
                            <th>Jenis Layanan ID</th>
                            <th>Tgl. Pengajuan</th>
                            <th>Tgl. Selesai</th>
                            <th>File</th>
                            <th>Riwayat</th>
                            <th width="200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="layananSuratForm" name="layananSuratForm" class="form-horizontal"
                        enctype="multipart/form-data">
                        <input type="hidden" name="layanan_surat_id" id="layanan_surat_id">

                        <div class="mb-3">
                            <label for="no_surat" class="form-label">No. Surat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="no_surat" name="no_surat"
                                placeholder="Masukkan Nomor Surat" value="" required>
                            <div class="text-danger" id="no_surat-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="tgl_surat" class="form-label">Tanggal Surat</label>
                            <input type="date" class="form-control" id="tgl_surat" name="tgl_surat">
                            <div class="text-danger" id="tgl_surat-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Masukkan Keterangan"></textarea>
                            <div class="text-danger" id="keterangan-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_layanan_id" class="form-label">Jenis Layanan ID</label>
                            <select name="jenis_layanan_id" id="jenis_layanan_id" class="form-select mb-2">
                                <option value="">Pilih Jenis Layanan</option>
                                @foreach ($jenisLayanan as $jenisLayanan)
                                    <option value="{{ $jenisLayanan->id }}">{{ $jenisLayanan->nama }}</option>
                                @endforeach
                            </select>
                            <div class="text-danger" id="jenis_layanan_id-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="tgl_pengajuan" class="form-label">Tanggal Pengajuan</label>
                            <input type="date" class="form-control" id="tgl_pengajuan" name="tgl_pengajuan">
                            <div class="text-danger" id="tgl_pengajuan-error"></div>
                        </div>


                        <div class="mb-3">
                            <label for="url_file" class="form-label">Url File</label>
                            <input type="text" class="form-control" id="url_file" name="url_file">
                            <div class="text-danger" id="url_file-error"></div>
                            <div id="current_file_display" class="mt-2"></div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data Layanan Surat ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
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

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('layanan-surat.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_surat',
                        name: 'no_surat'
                    },
                    {
                        data: 'tgl_surat',
                        name: 'tgl_surat'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'jenis_layanan.nama',
                        name: 'jenis_layanan.nama'
                    },
                    {
                        data: 'tgl_pengajuan',
                        name: 'tgl_pengajuan'
                    },
                    {
                        data: 'tgl_selesai',
                        name: 'tgl_selesai'
                    },
                    {
                        data: 'url_file',
                        name: 'url_file',
                        render: function(data, type, row) {
                            if (data) {
                                // Check file extension to display icon or link
                                return '<a href="' + data +
                                    '" target="_blank"><i class="fas fa-image"></i> Lihat File</a>';
                            }
                            return 'Tidak ada file';
                        }
                    },
                    {
                        data: 'riwayat',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Handle "Add New" button click
            $('#createNewLayananSurat').click(function() {
                $('#saveBtn').val("create-layanan-surat");
                $('#layanan_surat_id').val('');
                $('#layananSuratForm').trigger("reset");
                $('#modelHeading').html("Tambah Layanan Surat Baru");
                $('#current_file_display').html(''); // Clear file display
                $('.text-danger').html(''); // Clear validation errors
                $('#ajaxModel').modal('show');
            });
            $('body').on('click', '.editLayananSurat', function() {
                var layananSuratId = $(this).data('id');
                $('.text-danger').html(''); // Clear validation errors
                $.get("{{ route('layanan-surat.index') }}" + '/' + layananSuratId + '/edit', function(
                    data) {
                    $('#modelHeading').html("Edit Layanan Surat");
                    $('#saveBtn').val("edit-layanan-surat");
                    $('#ajaxModel').modal('show');
                    $('#layanan_surat_id').val(data.id);
                    $('#no_surat').val(data.no_surat);
                    $('#keterangan').val(data.keterangan);
                    $('#jenis_layanan_id').val(data.jenis_layanan_id).change();
                    // $('#tgl_pengajuan').val(data.tgl_pengajuan);
                    $('#tgl_pengajuan').val(data.tgl_pengajuan ? data.tgl_pengajuan.substr(0, 10) :
                        '');
                    $('#tgl_surat').val(data.tgl_surat ? data.tgl_surat.substr(0, 10) :
                        '');

                    // Display current file if exists
                    if (data.url_file) {
                        var fileName = data.url_file.split('/').pop();
                        $('#current_file_display').html('File saat ini: <a href="' + data.url_file +
                            '" target="_blank">' + fileName + '</a>');
                    } else {
                        $('#current_file_display').html('Tidak ada file saat ini.');
                    }
                })
            });

            // Handle Save/Update Form Submission
            $('#layananSuratForm').submit(function(e) {
                e.preventDefault();
                $('#saveBtn').html('Mengirim...');
                $('.text-danger').html(''); // Clear previous errors

                var formData = new FormData(this); // Use FormData for file uploads
                var url = "{{ route('layanan-surat.store') }}";
                var type = "POST";

                if ($('#layanan_surat_id').val()) {
                    url = "{{ route('layanan-surat.index') }}" + '/' + $('#layanan_surat_id').val();
                    type = "POST"; // Laravel needs POST for PUT/PATCH with FormData
                    formData.append('_method', 'PUT'); // Spoof PUT method
                }

                $.ajax({
                    data: formData,
                    url: url,
                    type: type,
                    contentType: false, // Important for FormData
                    processData: false, // Important for FormData
                    success: function(data) {
                        $('#layananSuratForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        $('#saveBtn').html('Simpan Perubahan');
                        alert(data.success); // Simple success alert
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Simpan Perubahan');
                        if (data.responseJSON && data.responseJSON.errors) {
                            $.each(data.responseJSON.errors, function(key, value) {
                                $('#' + key + '-error').html(value[0]);
                            });
                        } else {
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    }
                });
            });

            // Handle Delete button click
            var layananSuratIdToDelete;
            $('body').on('click', '.deleteLayananSurat', function() {
                layananSuratIdToDelete = $(this).data("id");
                $('#confirmDeleteModal').modal('show');
            });

            // Confirm Delete action
            $('#confirmDeleteBtn').click(function() {
                var url = "{{ route('layanan-surat.index') }}" + '/' + layananSuratIdToDelete;
                $.ajax({
                    type: "DELETE",
                    url: url,
                    success: function(data) {
                        $('#confirmDeleteModal').modal('hide');
                        table.draw();
                        alert(data.success); // Simple success alert
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        alert('Terjadi kesalahan saat menghapus data.');
                    }
                });
            });
        });
    </script>
@endsection
