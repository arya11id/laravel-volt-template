@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>Data Masuk</h2>
        <h2>Periode : {{ $SippolPeriode->nama_periode }}, {{ \Carbon\Carbon::parse($SippolPeriode->tgl)->translatedFormat('d F Y') }}<br>Total Pagu : Rp {{ number_format($SippolUnitKerja->sum('jml_gu'), 0, ',', '.') }}</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive py-4">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>JENIS</th>
                            <th>NOMOR</th>
                            <th>TANGGAL</th>
                            <th>SEKOLAH</th>
                            <th>KODE</th>
                            <th>URAIAN</th>
                            <th>PENERIMAAN</th>
                            <th>PENGELUARAN</th>
                            {{-- <th>ID_SIPPOL_JENIS</th> --}}
                            {{-- <th width="280px">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sippolBpDuaDuaForm" name="sippolBpDuaDuaForm" class="form-horizontal">
                   <input type="hidden" name="id" id="sippolBpDuaDua_id">
                   
                   
                        <div class="form-group mb-3">
                            <label for="id_periode" class="control-label mb-1">Id_periode</label>
                            <input type="text" class="form-control" id="id_periode" name="id_periode" placeholder="Enter Id_periode">
                        </div>
                        <div class="form-group mb-3">
                            <label for="id_unit_kerja" class="control-label mb-1">Id_unit_kerja</label>
                            <input type="text" class="form-control" id="id_unit_kerja" name="id_unit_kerja" placeholder="Enter Id_unit_kerja">
                        </div>
                        <div class="form-group mb-3">
                            <label for="jenis" class="control-label mb-1">Jenis</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Enter Jenis">
                        </div>
                        <div class="form-group mb-3">
                            <label for="nomor" class="control-label mb-1">Nomor</label>
                            <input type="text" class="form-control" id="nomor" name="nomor" placeholder="Enter Nomor">
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal" class="control-label mb-1">Tanggal</label>
                            <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Enter Tanggal">
                        </div>
                        <div class="form-group mb-3">
                            <label for="sekolah" class="control-label mb-1">Sekolah</label>
                            <input type="text" class="form-control" id="sekolah" name="sekolah" placeholder="Enter Sekolah">
                        </div>
                        <div class="form-group mb-3">
                            <label for="kode" class="control-label mb-1">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Enter Kode">
                        </div>
                        <div class="form-group mb-3">
                            <label for="uraian" class="control-label mb-1">Uraian</label>
                            <input type="text" class="form-control" id="uraian" name="uraian" placeholder="Enter Uraian">
                        </div>
                        <div class="form-group mb-3">
                            <label for="penerimaan" class="control-label mb-1">Penerimaan</label>
                            <input type="text" class="form-control" id="penerimaan" name="penerimaan" placeholder="Enter Penerimaan">
                        </div>
                        <div class="form-group mb-3">
                            <label for="pengeluaran" class="control-label mb-1">Pengeluaran</label>
                            <input type="text" class="form-control" id="pengeluaran" name="pengeluaran" placeholder="Enter Pengeluaran">
                        </div>
                        <div class="form-group mb-3">
                            <label for="id_sippol_jenis" class="control-label mb-1">Id_sippol_jenis</label>
                            <input type="text" class="form-control" id="id_sippol_jenis" name="id_sippol_jenis" placeholder="Enter Id_sippol_jenis">
                        </div>

                    <div class="col-sm-offset-2 col-sm-10 mt-3">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                    </div>
                </form>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script type="text/javascript">
  $(function () {
    
    // CSRF Token Setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Render DataTable
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('sippol-bp-dua-duas.data', $id) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', defaultContent: '-'},
            {data: 'jenisbp22.nama_jenis', name: 'jenisbp22.nama_jenis', defaultContent: '-'},
            {data: 'nomor', name: 'nomor', defaultContent: '-'},
            {data: 'tanggal', name: 'tanggal', defaultContent: '-'},
            {data: 'sekolah', name: 'sekolah', defaultContent: '-'},
            {data: 'kode', name: 'kode', defaultContent: '-'},
            {data: 'uraian', name: 'uraian', defaultContent: '-'},
            {
                data: 'penerimaan', 
                name: 'penerimaan', 
                render: $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
            },
            {
                data: 'pengeluaran', 
                name: 'pengeluaran', 
                render: $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
            },
            
            // {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // Open Modal for Create
    $('#createNewSippolBpDuaDua').click(function () {
        $('#saveBtn').val("create-product");
        $('#sippolBpDuaDua_id').val('');
        $('#sippolBpDuaDuaForm').trigger("reset");
        $('#modelHeading').html("Create New SippolBpDuaDua");
        $('#ajaxModel').modal('show');
    });

    // Open Modal for Edit
    $('body').on('click', '.editSippolBpDuaDua', function () {
        var id = $(this).data('id');
        $.get("{{ route('sippol-bp-dua-duas.index') }}" +'/' + id +'/edit', function (data) {
            $('#modelHeading').html("Edit SippolBpDuaDua");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#sippolBpDuaDua_id').val(data.id);
            $('#id_periode').val(data.id_periode);
                $('#id_unit_kerja').val(data.id_unit_kerja);
                $('#jenis').val(data.jenis);
                $('#nomor').val(data.nomor);
                $('#tanggal').val(data.tanggal);
                $('#sekolah').val(data.sekolah);
                $('#kode').val(data.kode);
                $('#uraian').val(data.uraian);
                $('#penerimaan').val(data.penerimaan);
                $('#pengeluaran').val(data.pengeluaran);
                $('#id_sippol_jenis').val(data.id_sippol_jenis);
        })
    });

    // Save/Update Data
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
            data: $('#sippolBpDuaDuaForm').serialize(),
            url: "{{ route('sippol-bp-dua-duas.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#sippolBpDuaDuaForm').trigger("reset");
                $('#ajaxModel').modal('hide');
                table.draw();
                $('#saveBtn').html('Save Changes');
                
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.success,
                });
            },
            error: function (data) {
                console.log('Error:', data);
                $('#saveBtn').html('Save Changes');
                
                // Show Error Validation
                let errorMessage = 'Something went wrong.';
                if(data.responseJSON.errors) {
                    errorMessage = Object.values(data.responseJSON.errors).flat().join('\n');
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage,
                });
            }
        });
    });

    // Delete Data
    $('body').on('click', '.deleteSippolBpDuaDua', function () {
        var id = $(this).data("id");
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('sippol-bp-dua-duas.destroy', ':id') }}".replace(':id', id),
                    success: function (data) {
                        table.draw();
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        )
                    }
                });
            }
        })
    });
    
  });
</script>
@endsection