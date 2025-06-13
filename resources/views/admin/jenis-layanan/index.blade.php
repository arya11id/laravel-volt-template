@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
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
            <table class="table table-bordered" id="jenisLayananTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Layanan</th>
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
        <h5 class="modal-title">Form Jenis Layanan</h5>
      </div>
      <div class="modal-body">
        <form id="formLayanan">
          <input type="hidden" id="layanan_id">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Layanan</label>
            <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Layanan">
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
@endsection

@section('customJS')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function () {
        let table = $('#jenisLayananTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('jenis-layanan.data') }}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'nama', name: 'nama'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#btnAdd').on('click', function () {
            $('#formLayanan')[0].reset();
            $('#layanan_id').val('');
            $('#layananModal').modal('show');
        });

        $('#btnSave').on('click', function () {
            let id = $('#layanan_id').val();
            let url = id ? `/jenis-layanan/update/${id}` : '{{ route('jenis-layanan.store') }}';

            $.post(url, $('#formLayanan').serialize(), function () {
                $('#layananModal').modal('hide');
                table.ajax.reload();
            });
        });

        $('#jenisLayananTable').on('click', '.btn-edit', function () {
            let id = $(this).data('id');
            $.get(`/jenis-layanan/${id}`, function (data) {
                $('#layanan_id').val(data.id);
                $('#nama').val(data.nama);
                $('#layananModal').modal('show');
            });
        });

        $('#jenisLayananTable').on('click', '.btn-delete', function () {
            if (confirm('Hapus data ini?')) {
                let id = $(this).data('id');
                $.ajax({
                    url: `/jenis-layanan/delete/${id}`,
                    type: 'DELETE',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function () {
                        table.ajax.reload();
                    }
                });
            }
        });
    });
</script>
@endsection
