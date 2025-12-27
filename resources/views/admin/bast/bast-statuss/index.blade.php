@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>BastStatuss Management</h2>
        <a href="javascript:void(0)" class="btn btn-success" id="createNewBastStatus"> Create New BastStatus</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NAMA_STATUS</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
                <form id="bastStatusForm" name="bastStatusForm" class="form-horizontal">
                   <input type="hidden" name="id" id="bastStatus_id">
                   
                   
                        <div class="form-group mb-3">
                            <label for="nama_status" class="control-label mb-1">Nama_status</label>
                            <input type="text" class="form-control" id="nama_status" name="nama_status" placeholder="Enter Nama_status">
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
        ajax: "{{ route('bast-statuss.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_status', name: 'nama_status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // Open Modal for Create
    $('#createNewBastStatus').click(function () {
        $('#saveBtn').val("create-product");
        $('#bastStatus_id').val('');
        $('#bastStatusForm').trigger("reset");
        $('#modelHeading').html("Create New BastStatus");
        $('#ajaxModel').modal('show');
    });

    // Open Modal for Edit
    $('body').on('click', '.editBastStatus', function () {
        var id = $(this).data('id');
        $.get("{{ route('bast-statuss.index') }}" +'/' + id +'/edit', function (data) {
            $('#modelHeading').html("Edit BastStatus");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#bastStatus_id').val(data.id);
            $('#nama_status').val(data.nama_status);
        })
    });

    // Save/Update Data
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
            data: $('#bastStatusForm').serialize(),
            url: "{{ route('bast-statuss.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#bastStatusForm').trigger("reset");
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
    $('body').on('click', '.deleteBastStatus', function () {
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
                    url: "{{ route('bast-statuss.destroy', ':id') }}".replace(':id', id),
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