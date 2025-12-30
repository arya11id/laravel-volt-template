@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>{{ $data->bastUnitKerja->nama_unit_kerja }} : {{ $data->bastTrsNomorBa->bastMsNomorBa->no_a . '/' . $data->bastTrsNomorBa->bastMsNomorBa->no_b }} /</H2><h2 class="text-danger">{{  $data->bastTrsNomorBa->no_c .'.'. $data->nomor_surat}}</H2><H2>/ {{ $data->bastTrsNomorBa->bastMsNomorBa->no_d . '/' . $data->bastTrsNomorBa->bastMsNomorBa->no_e }}</h2>
        
    </div>
    
    <br>

    <div class="card">
        <div class="card-body">
            <a href="javascript:void(0)" class="btn btn-success" id="createNewBastTrsBastBarang"> Create</a>
    <a href="{{ route('bast-trs-bast-barangs.cetakPdf', $data->uuid) }}" class="btn btn-success" target="_blank"> Cetak </a>
    <a href="{{ route('bast-trs-bast-barangs.cetakWord', $data->uuid) }}" class="btn btn-success" target="_blank"> Cetak Word </a>
            <div class="table-responsive py-4">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>JENIS</th>
                            <th>URAIAN</th>
                            <th>VOLUME</th>
                            <th>ID_BAST_SATUAN</th>
                            <th>HARGA_SATUAN</th>
                            <th>BARANG_FILE_NAME_A</th>
                            <th>BARANG_FILE_NAME_B</th>
                            <th>BARANG_FILE_NAME_C</th>
                            <th>BARANG_FILE_NAME_D</th>
                            <th>TGL_SELESAI_NEGO</th>
                            <th>TGL_DATANG_BARANG</th>
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
                <form id="bastTrsBastBarangForm" name="bastTrsBastBarangForm" class="form-horizontal">
                   <input type="hidden" name="id" id="bastTrsBastBarang_id">
                    <input type="hidden" id="id_bast_transaksi" name="id_bast_transaksi" value="{{ $id }}">
                        <div class="form-group mb-3">
                            <label for="jenis" class="control-label mb-1">Jenis</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Enter Jenis">
                        </div>
                        <div class="form-group mb-3">
                            <label for="uraian" class="control-label mb-1">Uraian</label>
                            <input type="text" class="form-control" id="uraian" name="uraian" placeholder="Enter Uraian">
                        </div>
                        <div class="form-group mb-3">
                            <label for="volume" class="control-label mb-1">Volume</label>
                            <input type="text" class="form-control" id="volume" name="volume" placeholder="Enter Volume">
                        </div>
                        <div class="form-group mb-3">
                            <label for="id_bast_satuan" class="control-label mb-1">satuan</label>
                            {{-- <input type="number" class="form-control" id="id_bast_satuan" name="id_bast_satuan" placeholder="Enter Id_bast_satuan"> --}}
                            <select id='id_bast_satuan' name='id_bast_satuan' class="form-control select9" style="width: 100%">
                                <option value="">--Pilih--</option>
                                @foreach ($satuan as $list)
                                    <option value="{{ $list->id }}">{{ $list->nama_satuan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="harga_satuan" class="control-label mb-1">Harga_satuan</label>
                            <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" placeholder="Enter Harga_satuan" inputmode="numeric">
                            <small class="form-text text-muted" id="harga_display">Rp 0</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="barang_file_name_a" class="control-label mb-1">Barang_file_name_a</label>
                            <input type="file" class="form-control" id="barang_file_name_a" name="barang_file_name_a">
                        </div>
                        <div class="form-group mb-3">
                            <label for="barang_file_name_b" class="control-label mb-1">Barang_file_name_b</label>
                            <input type="file" class="form-control" id="barang_file_name_b" name="barang_file_name_b">
                        </div>
                        <div class="form-group mb-3">
                            <label for="barang_file_name_c" class="control-label mb-1">Barang_file_name_c</label>
                            <input type="file" class="form-control" id="barang_file_name_c" name="barang_file_name_c">
                        </div>
                        <div class="form-group mb-3">
                            <label for="barang_file_name_d" class="control-label mb-1">Barang_file_name_d</label>
                            <input type="file" class="form-control" id="barang_file_name_d" name="barang_file_name_d">
                        </div>
                        <div class="form-group mb-3">
                            <label for="tgl_selesai_nego" class="control-label mb-1">Tgl_selesai_nego</label>
                            <input type="date" class="form-control" id="tgl_selesai_nego" name="tgl_selesai_nego">
                        </div>
                        <div class="form-group mb-3">
                            <label for="tgl_datang_barang" class="control-label mb-1">Tgl_datang_barang</label>
                            <input type="date" class="form-control" id="tgl_datang_barang" name="tgl_datang_barang">
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
    $('#harga_satuan').on('keyup', function() {
                                let value = $(this).val().replace(/\D/g, '');
                                let formatted = new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0
                                }).format(value || 0);
                                $('#harga_display').text(formatted);
                            });
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
        ajax: "{{ route('bast-trs-bast-barangs.data', ['id' => $id]) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'jenis', name: 'jenis'},
                    {data: 'uraian', name: 'uraian'},
                    {data: 'volume', name: 'volume'},
                    {data: 'satuan.nama_satuan', name: 'satuan.nama_satuan'},
                    {data: 'harga_satuan', name: 'harga_satuan'},
                    {data: 'barang_file_a', name: 'barang_file_a'},
                    {data: 'barang_file_b', name: 'barang_file_b'},
                    {data: 'barang_file_c', name: 'barang_file_c'},
                    {data: 'barang_file_d', name: 'barang_file_d'},
                    {data: 'tgl_selesai_nego', name: 'tgl_selesai_nego'},
                    {data: 'tgl_datang_barang', name: 'tgl_datang_barang'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    // Open Modal for Create
    $('#createNewBastTrsBastBarang').click(function () {
        $('#saveBtn').val("create-product");
        $('#bastTrsBastBarang_id').val('');
        $('#bastTrsBastBarangForm').trigger("reset");
        $('#modelHeading').html("Create New BastTrsBastBarang");
        $('#ajaxModel').modal('show');
    });

    // Open Modal for Edit
    $('body').on('click', '.editBastTrsBastBarang', function () {
        var id = $(this).data('id');
        $.get("{{ url('sippol/bast-trs-bast-barangs/edit') }}" + '/' + id, function (data) {
            $('#modelHeading').html("Edit BastTrsBastBarang");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#bastTrsBastBarang_id').val(data.id);
            $('#id_bast_transaksi').val(data.id_bast_transaksi);
                $('#jenis').val(data.jenis);
                $('#uraian').val(data.uraian);
                $('#volume').val(data.volume);
                $('#id_bast_satuan').val(data.id_bast_satuan);
                $('#harga_satuan').val(data.harga_satuan);
                $('#tgl_selesai_nego').val(data.tgl_selesai_nego);
                $('#tgl_datang_barang').val(data.tgl_datang_barang);
        })
    });

    // Save/Update Data
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        var formData = new FormData($('#bastTrsBastBarangForm')[0]);
        
        $.ajax({
            data: formData,
            url: "{{ route('bast-trs-bast-barangs.store') }}",
            type: "POST",
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                $('#bastTrsBastBarangForm').trigger("reset");
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
    $('body').on('click', '.deleteBastTrsBastBarang', function () {
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
                    url: "{{ route('bast-trs-bast-barangs.destroy', ':id') }}".replace(':id', id),
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