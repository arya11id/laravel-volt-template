@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>SippolUnitKerjas Management</h2>
        <a href="javascript:void(0)" class="btn btn-success" id="createNewSippolUnitKerja"> Create New SippolUnitKerja</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive py-4">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID_BAST_UNIT_KERJA</th>
                            <th>JML_GU</th>
                            <th>JML_STS</th>
                            <th>ID_PERIODE</th>
                            <th>KODE</th>
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
                <form id="sippolUnitKerjaForm" name="sippolUnitKerjaForm" class="form-horizontal">
                   <input type="hidden" name="id" id="sippolUnitKerja_id">
                   
                   
                        <div class="form-group mb-3">
                            <label for="id_bast_unit_kerja" class="control-label mb-1">Id_bast_unit_kerja</label>
                            <input type="number" class="form-control" id="id_bast_unit_kerja" name="id_bast_unit_kerja" placeholder="Enter Id_bast_unit_kerja">
                        </div>
                        <div class="form-group mb-3">
                            <label for="jml_gu" class="control-label mb-1">Jml_gu</label>
                            <input type="number" class="form-control" id="jml_gu" name="jml_gu" placeholder="Enter Jml_gu">
                        </div>
                        <div class="form-group mb-3">
                            <label for="jml_sts" class="control-label mb-1">Jml_sts</label>
                            <input type="number" class="form-control" id="jml_sts" name="jml_sts" placeholder="Enter Jml_sts">
                        </div>
                        <div class="form-group mb-3">
                            <label for="id_periode" class="control-label mb-1">Id_periode</label>
                            <input type="number" class="form-control" id="id_periode" name="id_periode" placeholder="Enter Id_periode">
                        </div>
                        <div class="form-group mb-3">
                            <label for="kode" class="control-label mb-1">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Enter Kode">
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
        ajax: "{{ route('sippol-unit-kerjas.index', $id) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id_bast_unit_kerja', name: 'id_bast_unit_kerja'},
                    {data: 'jml_gu', name: 'jml_gu'},
                    {data: 'jml_sts', name: 'jml_sts'},
                    {data: 'id_periode', name: 'id_periode'},
                    {data: 'kode', name: 'kode'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // Open Modal for Create
    $('#createNewSippolUnitKerja').click(function () {
        $('#saveBtn').val("create-product");
        $('#sippolUnitKerja_id').val('');
        $('#sippolUnitKerjaForm').trigger("reset");
        $('#modelHeading').html("Create New SippolUnitKerja");
        $('#ajaxModel').modal('show');
    });

    // Open Modal for Edit
    $('body').on('click', '.editSippolUnitKerja', function () {
        var id = $(this).data('id');
        $.get("{{ route('sippol-unit-kerjas.index') }}" +'/' + id +'/edit', function (data) {
            $('#modelHeading').html("Edit SippolUnitKerja");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#sippolUnitKerja_id').val(data.id);
            $('#id_bast_unit_kerja').val(data.id_bast_unit_kerja);
                $('#jml_gu').val(data.jml_gu);
                $('#jml_sts').val(data.jml_sts);
                $('#id_periode').val(data.id_periode);
                $('#kode').val(data.kode);
        })
    });

    // Save/Update Data
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
            data: $('#sippolUnitKerjaForm').serialize(),
            url: "{{ route('sippol-unit-kerjas.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#sippolUnitKerjaForm').trigger("reset");
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
    $('body').on('click', '.deleteSippolUnitKerja', function () {
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
                    url: "{{ route('sippol-unit-kerjas.destroy', ':id') }}".replace(':id', id),
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