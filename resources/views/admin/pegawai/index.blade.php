@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pemohon List</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">List Pemohon</h1>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <div class="card-body">
        <div class="table-responsive py-4">
            {{-- <button class="btn btn-primary mb-3" id="btnAdd">Tambah Pemohon</button> --}}
             <button type="button" class="btn btn-primary mb-3" id="uploamodal">
                                    {{ __('Upload Excel') }}
                                </button>
            <table class="table table-bordered" id="pemohonTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Instansi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="pemohonModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Pemohon</h5>
      </div>
      <div class="modal-body">
        <form id="formPemohon">
          <input type="hidden" id="pemohon_id">

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" class="form-control mb-2" placeholder="Nama">
            </div>
            <div class="form-group">
                <label for="nip">NIP</label>
                <input type="text" id="nip" name="nip" class="form-control mb-2" placeholder="NIP">
            </div>
            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" id="no_hp" name="no_hp" class="form-control mb-2" placeholder="No HP">
            </div>
            <div class="form-group">
                <label for="tgl_lahir">Tanggal Lahir</label>
                <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control mb-2">
            </div>
            <div class="form-group">
                <label for="asal_instansi">Asal Instansi</label>
                <input type="text" id="asal_instansi" name="asal_instansi" class="form-control mb-2" placeholder="Asal Instansi">
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" class="form-control mb-2" placeholder="Alamat">
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
<div class="modal fade" id="xuploamodal" tabindex="-1" aria-labelledby="uploamodalX" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploamodalX">Upload Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="importForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Choose Excel File</label>
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('customCSS')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
@endsection

@section('customJS')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function () {
        let table = $('#pemohonTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('pegawai.data') }}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nip', name: 'nip'},
                {data: 'nama', name: 'nama'},
                {data: 'unit_kerja', name: 'unit_kerja'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#btnAdd').on('click', function () {
            $('#formPemohon')[0].reset();
            $('#pemohon_id').val('');
            $('#pemohonModal').modal('show');
        });
         $('#uploamodal').on('click', function () {
            $('#xuploamodal').modal('show');
        });

        $('#btnSave').on('click', function () {
            let id = $('#pemohon_id').val();
            let url = id ? `/pemohon/update/${id}` : '{{ route('pemohon.store') }}';

            $.post(url, $('#formPemohon').serialize(), function () {
                $('#pemohonModal').modal('hide');
                table.ajax.reload();
            });
        });

        $('#pemohonTable').on('click', '.btn-edit', function () {
            let id = $(this).data('id');
            $.get(`/pemohon/${id}`, function (data) {
                $('#pemohon_id').val(data.id);
                $('#nama').val(data.nama);
                $('#nip').val(data.nip);
                $('#no_hp').val(data.no_hp);
                $('#tgl_lahir').val(data.tgl_lahir);
                $('#asal_instansi').val(data.asal_instansi);
                $('#alamat').val(data.alamat);
                $('#pemohonModal').modal('show');
            });
        });

        $('#pemohonTable').on('click', '.btn-delete', function () {
            if (confirm('Hapus data ini?')) {
                let id = $(this).data('id');
                $.ajax({
                    url: `/pemohon/delete/${id}`,
                    type: 'DELETE',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function () {
                        table.ajax.reload();
                    }
                });
            }
        });
        $('#importForm').on('submit', function(e) {
                e.preventDefault();

                // Create a FormData object to handle the file upload
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('pegawai.import') }}", // Update with the correct route
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        Swal.fire({
                            title: "Loading...",
                            html: "Please wait a moment",
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        // Swal.showLoading();
                    },
                    success: function(response) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.msg,
                            showConfirmButton: false,
                            timer: 2000
                        }).then((result) => {
                             $('#xuploamodal').modal('hide');
                            table.ajax.reload();

                        })
                    },
                    error: function(response) {
                        let errorMessage = response.responseJSON?.message ??
                            'An error occurred';
                        $('#responseMessage').html('<div class="alert alert-danger">' +
                            errorMessage + '</div>');
                    }
                });
            });
    });
</script>
@endsection
