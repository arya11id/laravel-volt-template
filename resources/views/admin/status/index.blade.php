@extends('layouts.app')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Status List</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">List Status</h1>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <div class="card-body">
        <div class="table-responsive py-4">
            <button class="btn btn-primary mb-3" id="btnAdd">Tambah Status</button>
            <table class="table table-bordered" id="statusTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="statusModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Status</h5>
      </div>
      <div class="modal-body">
        <form id="formStatus">
          <input type="hidden" id="status_id">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Status</label>
            <input type="text" name="nama" id="nama" class="form-control mb-2" placeholder="Nama Status">
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
        let table = $('#statusTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('status.data') }}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'nama', name: 'nama'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#btnAdd').on('click', function () {
            $('#formStatus')[0].reset();
            $('#status_id').val('');
            $('#statusModal').modal('show');
        });

        $('#btnSave').on('click', function () {
            let id = $('#status_id').val();
            let url = id ? `/status/update/${id}` : '{{ route('status.store') }}';

            $.post(url, $('#formStatus').serialize(), function () {
                $('#statusModal').modal('hide');
                table.ajax.reload();
            });
        });

        $('#statusTable').on('click', '.btn-edit', function () {
            let id = $(this).data('id');
            $.get(`/status/${id}`, function (data) {
                $('#status_id').val(data.id);
                $('#nama').val(data.nama);
                $('#statusModal').modal('show');
            });
        });

        $('#statusTable').on('click', '.btn-delete', function () {
            if (confirm('Hapus data ini?')) {
                let id = $(this).data('id');
                $.ajax({
                    url: `/status/delete/${id}`,
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
