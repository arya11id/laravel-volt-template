@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>BastUnitKerjas Management</h2>
        <a href="javascript:void(0)" class="btn btn-success" id="createNewBastUnitKerja"> Create New BastUnitKerja</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive py-4">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NAMA_UNIT_KERJA</th>
                                <th>KODE_UNIT_KERJA</th>
                                <th>NIP_KS</th>
                                <th>NAMA_KS</th>
                                <th>NIP_BENDAHARA</th>
                                <th>NAMA_BENDAHARA</th>
                                <th>JENIS</th>
                                <th>NO_URUT</th>
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
                <form id="bastUnitKerjaForm" name="bastUnitKerjaForm" class="form-horizontal">
                   <input type="hidden" name="id" id="bastUnitKerja_id">
                   
                   
                        <div class="form-group mb-3">
                            <label for="nama_unit_kerja" class="control-label mb-1">Nama_unit_kerja</label>
                            <input type="text" class="form-control" id="nama_unit_kerja" name="nama_unit_kerja" placeholder="Enter Nama_unit_kerja">
                        </div>
                        <div class="form-group mb-3">
                            <label for="kode_unit_kerja" class="control-label mb-1">Kode_unit_kerja</label>
                            <input type="text" class="form-control" id="kode_unit_kerja" name="kode_unit_kerja" placeholder="Enter Kode_unit_kerja">
                        </div>
                        <div class="form-group mb-3">
                            <label for="nip_ks" class="control-label mb-1">Nip_ks</label>
                            <input type="number" class="form-control" id="nip_ks" name="nip_ks" placeholder="Enter Nip_ks">
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama_ks" class="control-label mb-1">Nama_ks</label>
                            <input type="text" class="form-control" id="nama_ks" name="nama_ks" placeholder="Enter Nama_ks">
                        </div>
                        <div class="form-group mb-3">
                            <label for="nip_bendahara" class="control-label mb-1">Nip_bendahara</label>
                            <input type="number" class="form-control" id="nip_bendahara" name="nip_bendahara" placeholder="Enter Nip_bendahara">
                        </div>
                        <div class="form-group mb-3">
                            <label for="nama_bendahara" class="control-label mb-1">Nama_bendahara</label>
                            <input type="text" class="form-control" id="nama_bendahara" name="nama_bendahara" placeholder="Enter Nama_bendahara">
                        </div>
                        <div class="form-group mb-3">
                            <label for="jenis" class="control-label mb-1">Jenis</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Enter Jenis">
                        </div>
                        <div class="form-group mb-3">
                            <label for="no_urut" class="control-label mb-1">No_urut</label>
                            <input type="text" class="form-control" id="no_urut" name="no_urut" placeholder="Enter No_urut">
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
        responsive: true,
        ajax: "{{ route('bast-unit-kerjas.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama_unit_kerja', name: 'nama_unit_kerja'},
                    {data: 'kode_unit_kerja', name: 'kode_unit_kerja'},
                    {data: 'nip_ks', name: 'nip_ks'},
                    {data: 'nama_ks', name: 'nama_ks'},
                    {data: 'nip_bendahara', name: 'nip_bendahara'},
                    {data: 'nama_bendahara', name: 'nama_bendahara'},
                    {data: 'jenis', name: 'jenis'},
                    {data: 'no_urut', name: 'no_urut'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // Open Modal for Create
    $('#createNewBastUnitKerja').click(function () {
        $('#saveBtn').val("create-product");
        $('#bastUnitKerja_id').val('');
        $('#bastUnitKerjaForm').trigger("reset");
        $('#modelHeading').html("Create New BastUnitKerja");
        $('#ajaxModel').modal('show');
    });

    // Open Modal for Edit
    $('body').on('click', '.editBastUnitKerja', function () {
        var id = $(this).data('id');
        $.get("{{ route('bast-unit-kerjas.index') }}" +'/' + id +'/edit', function (data) {
            $('#modelHeading').html("Edit BastUnitKerja");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#bastUnitKerja_id').val(data.id);
            $('#nama_unit_kerja').val(data.nama_unit_kerja);
                $('#kode_unit_kerja').val(data.kode_unit_kerja);
                $('#nip_ks').val(data.nip_ks);
                $('#nama_ks').val(data.nama_ks);
                $('#nip_bendahara').val(data.nip_bendahara);
                $('#nama_bendahara').val(data.nama_bendahara);
                $('#jenis').val(data.jenis);
                $('#no_urut').val(data.no_urut);
        })
    });

    // Save/Update Data
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
            data: $('#bastUnitKerjaForm').serialize(),
            url: "{{ route('bast-unit-kerjas.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#bastUnitKerjaForm').trigger("reset");
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
    $('body').on('click', '.deleteBastUnitKerja', function () {
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
                    url: "{{ route('bast-unit-kerjas.destroy', ':id') }}".replace(':id', id),
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