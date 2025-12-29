@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>BastTrsNomorBas Management</h2>
        <a href="javascript:void(0)" class="btn btn-success" id="createNewBastTrsNomorBa"> Create New BastTrsNomorBa</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive py-4">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID_BAST_MS_NOMOR_BA</th>
                            <th>TGL_NOMOR</th>
                            <th>NO_SURAT</th>
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
                <form id="bastTrsNomorBaForm" name="bastTrsNomorBaForm" class="form-horizontal">
                   <input type="hidden" name="id" id="bastTrsNomorBa_id">
                   
                   
                        <div class="form-group mb-3">
                            <label for="id_bast_ms_nomor_ba" class="control-label mb-1">master nomor ba</label>
                            {{-- <input type="number" class="form-control" id="id_bast_ms_nomor_ba" name="id_bast_ms_nomor_ba" placeholder="Enter Id_bast_ms_nomor_ba"> --}}
                            <select id='id_bast_ms_nomor_ba' name='id_bast_ms_nomor_ba' class="form-control select9" style="width: 100%">
                                <option value="">--Pilih--</option>
                                @foreach ($BastMsNomorBa as $list)
                                    <option value="{{ $list->id }}">{{ $list->no_a }}/{{ $list->no_b }}/.../{{ $list->no_d }}/{{ $list->no_e }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tgl_nomor" class="control-label mb-1">Tgl_nomor</label>
                            <input type="date" class="form-control" id="tgl_nomor" name="tgl_nomor">
                        </div>
                        <div class="form-group mb-3">
                            <label for="no_c" class="control-label mb-1">No_SURAT</label>
                            <input type="text" class="form-control" id="no_c" name="no_c" placeholder="Enter No_c">
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
        ajax: "{{ route('bast-trs-nomor-bas.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'ms_nomor_ba', name: 'ms_nomor_ba'},
                    {data: 'tgl_nomor', name: 'tgl_nomor'},
                    {data: 'no_c', name: 'no_c'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // Open Modal for Create
    $('#createNewBastTrsNomorBa').click(function () {
        $('#saveBtn').val("create-product");
        $('#bastTrsNomorBa_id').val('');
        $('#bastTrsNomorBaForm').trigger("reset");
        $('#modelHeading').html("Create New BastTrsNomorBa");
        $('#ajaxModel').modal('show');
    });

    // Open Modal for Edit
    $('body').on('click', '.editBastTrsNomorBa', function () {
        var id = $(this).data('id');
        $.get("{{ route('bast-trs-nomor-bas.index') }}" +'/' + id +'/edit', function (data) {
            $('#modelHeading').html("Edit BastTrsNomorBa");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#bastTrsNomorBa_id').val(data.id);
            $('#id_bast_ms_nomor_ba').val(data.id_bast_ms_nomor_ba);
                $('#tgl_nomor').val(data.tgl_nomor);
                $('#no_c').val(data.no_c);
        })
    });

    // Save/Update Data
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
            data: $('#bastTrsNomorBaForm').serialize(),
            url: "{{ route('bast-trs-nomor-bas.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#bastTrsNomorBaForm').trigger("reset");
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
    $('body').on('click', '.deleteBastTrsNomorBa', function () {
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
                    url: "{{ route('bast-trs-nomor-bas.destroy', ':id') }}".replace(':id', id),
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