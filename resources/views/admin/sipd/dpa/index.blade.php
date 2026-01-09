@extends('layouts.app')
@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">List Data DPA {{ $tahun->jenis }} {{ $tahun->nama }}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">List Data DPA {{ $tahun->jenis }} {{ $tahun->nama }}</h1>
        </div>
    </div>
</div>
@include('layouts.alert')
<div class="card">
    <div class="card-body">
        <div class="table-responsive py-4">
            <button class="btn btn-primary mb-3" id="btnAdd">Tambah</button>
            <button class="btn btn-primary mb-3" id="bersih">Refresh</button>
            <button class="btn btn-primary mb-3" id="rekap">Rekap Sekolah</button>
            <button class="btn btn-primary mb-3" id="rekapKodex">Rekap Kode Rekening</button>
            <table class="table table-bordered" id="statusTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Rekening <br>
                            <select id='kode_akun' class="form-control select9" style="width: 200px">
                                <option value="">--Pilih--</option>
                                <option value="">Semua</option>
                                @foreach ($akun as $data)
                                    <option value="{{ $data->kode_akun }}">{{ $data->kode_akun }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>Nama Rekening <br>
                            <select id='nama_akun' class="form-control select9" style="width: 100%">
                                <option value="">--Pilih--</option>
                                <option value="">Semua</option>
                                @foreach ($akun as $list)
                                    <option value="{{ $list->kode_akun }}">{{ $list->nama_akun }}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>Belanja Modal ? <br>
                            <select id='bm' class="form-control select9" style="width: 200px">
                                <option value="">--Pilih--</option>
                                <option value="">Semua</option>
                                <option value="TRUE">TRUE</option>
                                <option value="FALSE">FALSE</option>
                            </select>
                        </th>
                        <th>Unit Kerja<br>
                            <select id='unit' class="form-control select9" style="width: 200px">
                                <option value="">--Pilih--</option>
                                <option value="">Semua</option>
                                @foreach ($unit as $unitx)
                                    <option value="{{ $unitx->subs_bl_teks }}">{{ $unitx->subs_bl_teks }}</option>
                                @endforeach
                            </select></th>
                        <th>Uraian</th>
                        <th>Spesifikasi</th>
                        <th>Koefisien Sebelum</th>
                        <th>Harga Satuan Sebelum</th>
                        <th>Jumlah Sebelum</th>
                        <th>Koefisien Sesudah</th>
                        <th>Harga Satuan Sesudah</th>
                        <th>Jumlah Sesudah</th>
                        <th>Bertambah / (Berkurang)</th>
                        {{-- <th>Aksi</th> --}}
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
          <input type="hidden" id="jenis" name="jenis" value="{{ $jenis }}">
            <div class="mb-3">
                <label for="nama" class="form-label">id_ket_sub_bl</label>
                <input type="file" id="id_ket_sub_bl" class="form-control mb-2" name="id_ket_sub_bl" accept=".json" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama id_subs_sub_bl</label>
                <input type="file" id="id_subs_sub_bl" class="form-control mb-2" name="id_subs_sub_bl" accept=".json" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">id_rinci_sub_bl</label>
                <input type="file" id="id_rinci_sub_bl" class="form-control mb-2" name="id_rinci_sub_bl" accept=".json" required>
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
<div class="modal fade" id="statusBersih" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Bersihkan Data</h5>
      </div>
      <div class="modal-body">
        <form id="formBersih">
          <input type="hidden" id="jenis" name="jenis" value="{{ $jenis }}">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btnSmpn">Simpan</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="rekapSekolahx" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rekap Persekolah</h5>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="rekapTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Sekolah</th>
                    <th>Total Sesudah</th>
                </tr>
            </thead>
            <tbody id="rekapBody">
                {{-- Data akan dimuat di sini --}}
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="rekapKode" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rekap Persekolah</h5>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm" id="rekapTableKode">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Rekening</th>
                    <th>Nama Rekening</th>
                    <th>Total Sesudah</th>
                </tr>
            </thead>
            <tbody id="rekapBodyKode">
                {{-- Data akan dimuat di sini --}}
            </tbody>
            </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('customCSS')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.2.5/css/buttons.dataTables.min.css"/>
@endsection

@section('customJS')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/3.2.5/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.dataTables.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/3.2.5/js/buttons.print.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('.select9').select2();
         var table = $('#statusTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('sipd.dpa.data',$jenis) }}",
                    method: "POST",
                    data: function(data) {
                        data.kode_akun = $('#kode_akun').val();
                        data.nama_akun = $('#nama_akun').val();
                        data.unit = $('#unit').val();
                        data.bm = $('#bm').val();
                    }
                },
                dom: 'Blrtip', // B = buttons, l = length select, r = processing, t = table, i = info, p = paging
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        exportOptions: { modifier: { page: 'all' } }
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        exportOptions: { modifier: { page: 'all' } }
                    },
                    {
                        text: 'Show All',
                        action: function (e, dt, node, config) {
                            dt.page.len(-1).draw(false); // request all rows (server must honor length=-1)
                        }
                    },
                    {
                        text: 'Paged',
                        action: function (e, dt, node, config) {
                            dt.page.len(10).draw(false); // kembali ke paging default
                        }
                    }
                ],
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
                pageLength: 10,
                searching: false,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'kode_akun', name: 'kode_akun'},
                    {data: 'nama_akun', name: 'nama_akun'},
                    {data: 'is_bm', name: 'is_bm'},
                    {data: 'subs_bl_teks', name: 'subs_bl_teks'},
                    {data: 'nama_standar_harga', name: 'nama_standar_harga'},
                    {data: 'spek', name: 'spek'},
                    {data: 'koefisien_sebelum', name: 'koefisien_sebelum'},
                    {data: 'harga_awal', name: 'harga_awal'},
                    {data: 'total_awal', name: 'total_awal'},
                    {data: 'koefisien_setelah', name: 'koefisien_setelah'},
                    {data: 'harga_akhir', name: 'harga_akhir'},
                    {data: 'total_akhir', name: 'total_akhir'},
                    {data: 'selisih', name: 'selisih'}
                    // {data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            });
            $('#nama_akun').on('change', function() {
                table.draw(); // Redraw the table with the updated filter
            });
            $('#kode_akun').on('change', function() {
                table.draw(); // Redraw the table with the updated filter
            });
            $('#unit').on('change', function() {
                table.draw(); // Redraw the table with the updated filter
            });
            $('#bm').on('change', function() {
                table.draw(); // Redraw the table with the updated filter
            });
       

        $('#btnAdd').on('click', function () {
            $('#formStatus')[0].reset();
            $('#status_id').val('');
            $('#statusModal').modal('show');
        });
        $('#bersih').on('click', function () {
            $('#formBersih')[0].reset();
            $('#statusBersih').modal('show');
        });
        $('#rekap').on('click', function () {
            $('#formBersih')[0].reset();
            $('#rekapSekolahx').modal('show');
            $.get("{{ route('sipd.dpa.rekap-sekolah', $jenis) }}", function(data) {
                let tbody = '';
                data.forEach(function(item, index) {
                    tbody += `<tr>
                        <td>${index + 1}</td>
                        <td>${item.subs_bl_teks}</td>
                        <td>${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.total_setelah)}</td>
                    </tr>`;
                });
                $('#rekapBody').html(tbody);
            });
        });
        $('#rekapKodex').on('click', function () {
            $('#formBersih')[0].reset();
            $('#rekapKode').modal('show');
            $.get("{{ route('sipd.dpa.rekap-kode-rekening', $jenis) }}", function(data) {
                let tbody = '';
                data.forEach(function(item, index) {
                    tbody += `<tr>
                        <td>${index + 1}</td>
                        <td>${item.kode_akun}</td>
                        <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">${item.nama_akun}</td>
                        <td>${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.total_setelah)}</td>
                    </tr>`;
                });
                $('#rekapBodyKode').html(tbody);
            });
        });

        $('#btnSave').on('click', function () {
            let formData = new FormData($('#formStatus')[0]);
            
            $.ajax({
                url: "{{ route('sipd.dpa.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#btnSave').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Loading...');
                },
                success: function (response) {
                    $('#statusModal').modal('hide');
                    table.draw();
                    $('#btnSave').prop('disabled', false).html('Simpan');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                    $('#btnSave').prop('disabled', false).html('Simpan');
                }
            });
        });
        $('#btnSmpn').on('click', function () {
            let formData = new FormData($('#formBersih')[0]);
            
            $.ajax({
                url: "{{ route('sipd.dpa.bersih') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#btnSmpn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Loading...');
                },
                success: function (response) {
                    $('#statusBersih').modal('hide');
                    table.draw();
                    $('#btnSmpn').prop('disabled', false).html('Simpan');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseJSON.message);
                    $('#btnSmpn').prop('disabled', false).html('Simpan');
                }
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
