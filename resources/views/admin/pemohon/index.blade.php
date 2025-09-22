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
            <button class="btn btn-primary mb-3" id="btnAdd">Tambah Pemohon</button>
            <table class="table table-bordered" id="pemohonTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Tgl Lahir</th>
                        <th>Instansi</th>
                        <th>Alamat</th>
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
                <label for="asal_instansi">Unit Kerja</label>
                <select id="id_unit_kerja" name="id_unit_kerja" class="form-control mb-2">
                    <option value="">-- Pilih Instansi --</option>
                    @foreach($unitKerja as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
                    @endforeach
                </select>
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
        let table = $('#pemohonTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('pemohon.data') }}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nip', name: 'nip'},
                {data: 'nama', name: 'nama'},
                {data: 'no_hp', name: 'no_hp'},
                {data: 'tgllahir', name: 'tgllahir'},
                // {data: 'asal_instansi', name: 'asal_instansi'},
                {
                    data: 'unit_kerja.nama', 
                    name: 'unit_kerja.nama',
                    defaultContent: '-'
                },
                {data: 'alamat', name: 'alamat'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#btnAdd').on('click', function () {
            $('#formPemohon')[0].reset();
            $('#pemohon_id').val('');
            $('#pemohonModal').modal('show');
        });

       $('#btnSave').on('click', function () {
            let id = $('#pemohon_id').val();
            let url = id ? `/pemohon/update/${id}` : '{{ route('pemohon.store') }}';

            // Disable button dan tampilkan loading
            $('#btnSave').prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

            $.post(url, $('#formPemohon').serialize(), function () {
                $('#pemohonModal').modal('hide');
                table.ajax.reload();
                // Enable button dan kembalikan text
                $('#btnSave').prop('disabled', false).html('Simpan');
            }).fail(function() {
                // Enable button dan kembalikan text jika gagal
                $('#btnSave').prop('disabled', false).html('Simpan');
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
                $('#id_unit_kerja').val(data.id_unit_kerja).change();
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
    });
</script>
@endsection
