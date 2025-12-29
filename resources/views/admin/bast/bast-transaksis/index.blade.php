@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>BastTransaksis Management</h2>
        <a href="javascript:void(0)" class="btn btn-success" id="createNewBastTransaksi"> Create New BastTransaksi</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive py-4">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID_BAST_UNIT_KERJA</th>
                            <th>ID_TRS_NOMOR_BA</th>
                            <th>ID_PENGURUS_BARANG</th>
                            <th>ID_BAST_STATUS</th>
                            <th>NOMOR_SURAT</th>
                            <th>SURAT_PESANAN_PATH</th>
                            <th>SURAT_PESANAN_FILE</th>
                            <th width="280px">Action</th>
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
                <form id="bastTransaksiForm" name="bastTransaksiForm" class="form-horizontal">
                   <input type="hidden" name="id" id="bastTransaksi_id">
                   
                   
                        <div class="form-group mb-3">
                            <label for="id_bast_unit_kerja" class="control-label mb-1">unit kerja</label>
                            {{-- <input type="number" class="form-control" id="id_bast_unit_kerja" name="id_bast_unit_kerja" placeholder="Enter Id_bast_unit_kerja"> --}}
                            <select id='id_bast_unit_kerja' name='id_bast_unit_kerja' class="form-control select9" style="width: 100%">
                                <option value="">--Pilih--</option>
                                @foreach ($BastUnitKerja as $list)
                                    <option value="{{ $list->id }}">{{ $list->nama_unit_kerja }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="id_trs_nomor_ba" class="control-label mb-1">Id_trs_nomor_ba</label>
                            <input type="number" class="form-control" id="id_trs_nomor_ba" name="id_trs_nomor_ba" placeholder="Enter Id_trs_nomor_ba">
                        </div>
                        <div class="form-group mb-3">
                            <label for="id_pengurus_barang" class="control-label mb-1">Id_pengurus_barang</label>
                            <input type="number" class="form-control" id="id_pengurus_barang" name="id_pengurus_barang" placeholder="Enter Id_pengurus_barang">
                        </div>
                        <div class="form-group mb-3">
                            <label for="id_bast_status" class="control-label mb-1">Id_bast_status</label>
                            <input type="number" class="form-control" id="id_bast_status" name="id_bast_status" placeholder="Enter Id_bast_status">
                        </div>
                        <div class="form-group mb-3">
                            <label for="nomor_surat" class="control-label mb-1">Nomor_surat</label>
                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" placeholder="Enter Nomor_surat">
                        </div>
                        <div class="form-group mb-3">
                            <label for="surat_pesanan_path" class="control-label mb-1">Surat_pesanan_path</label>
                            <input type="text" class="form-control" id="surat_pesanan_path" name="surat_pesanan_path" placeholder="Enter Surat_pesanan_path">
                        </div>
                        <div class="form-group mb-3">
                            <label for="surat_pesanan_file" class="control-label mb-1">Surat_pesanan_file</label>
                            <input type="text" class="form-control" id="surat_pesanan_file" name="surat_pesanan_file" placeholder="Enter Surat_pesanan_file">
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
    $('.select9').select2();

    // Render DataTable
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('bast-transaksis.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id_bast_unit_kerja', name: 'id_bast_unit_kerja'},
                    {data: 'id_trs_nomor_ba', name: 'id_trs_nomor_ba'},
                    {data: 'id_pengurus_barang', name: 'id_pengurus_barang'},
                    {data: 'id_bast_status', name: 'id_bast_status'},
                    {data: 'nomor_surat', name: 'nomor_surat'},
                    {data: 'surat_pesanan_path', name: 'surat_pesanan_path'},
                    {data: 'surat_pesanan_file', name: 'surat_pesanan_file'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // Open Modal for Create
    $('#createNewBastTransaksi').click(function () {
        $('#saveBtn').val("create-product");
        $('#bastTransaksi_id').val('');
        $('#bastTransaksiForm').trigger("reset");
        $('#modelHeading').html("Create New BastTransaksi");
        $('#ajaxModel').modal('show');
    });

    // Open Modal for Edit
    $('body').on('click', '.editBastTransaksi', function () {
        var id = $(this).data('id');
        $.get("{{ route('bast-transaksis.index') }}" +'/' + id +'/edit', function (data) {
            $('#modelHeading').html("Edit BastTransaksi");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#bastTransaksi_id').val(data.id);
            $('#id_bast_unit_kerja').val(data.id_bast_unit_kerja);
                $('#id_trs_nomor_ba').val(data.id_trs_nomor_ba);
                $('#id_pengurus_barang').val(data.id_pengurus_barang);
                $('#id_bast_status').val(data.id_bast_status);
                $('#nomor_surat').val(data.nomor_surat);
                $('#surat_pesanan_path').val(data.surat_pesanan_path);
                $('#surat_pesanan_file').val(data.surat_pesanan_file);
        })
    });

    // Save/Update Data
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
            data: $('#bastTransaksiForm').serialize(),
            url: "{{ route('bast-transaksis.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#bastTransaksiForm').trigger("reset");
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
    $('body').on('click', '.deleteBastTransaksi', function () {
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
                    url: "{{ route('bast-transaksis.destroy', ':id') }}".replace(':id', id),
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