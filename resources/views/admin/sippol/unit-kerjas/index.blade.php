@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>Periode : {{ $SippolPeriode->nama_periode }}, {{ \Carbon\Carbon::parse($SippolPeriode->tgl)->translatedFormat('d F Y') }}<br>Total Pagu : Rp {{ number_format($SippolUnitKerja->sum('jml_gu'), 0, ',', '.') }}</h2><br>
        {{-- <h3></h3> --}}
        
    </div>

    <div class="card">
        <div class="card-body">
            <a href="javascript:void(0)" class="btn btn-success" id="createNewSippolUnitKerja"> Create New SippolUnitKerja</a>
            <a href="javascript:void(0)" class="btn btn-primary" id="createbp22">import bp22</a>
            <a href="{{ route('sippol-bp-dua-duas.list', $id) }}" class="btn btn-secondary">data masuk</a>
            <button class="btn btn-danger" id="bersih">Refresh</button>
            <a href="{{ route('sippol-jenis.show', $id) }}" class="btn btn-secondary">Rekap</a>
            <a href="{{ route('sippol-jenis.final', $id) }}" class="btn btn-primary">Final</a>
            <div class="table-responsive py-4">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID_BAST_UNIT_KERJA</th>
                            <th>JML_GU</th>
                            <th>JML_STS</th>
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
                  
                   
                        @foreach ($BastUnitKerja as $item)
                            <div class="form-group mb-3">
                                <label for="id_bast_unit_kerja" class="control-label mb-1">unit_kerja</label>
                                <input type="hidden" id="id_bast_unit_kerja" name="id_bast_unit_kerja[]" value="{{ $item->id }}">
                                <input type="hidden" id="id_periode" name="id_periode[]" value="{{ $id }}">
                                <input type="text" class="form-control" value="{{ $item->nama_unit_kerja }}" disabled>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="jml_gu" class="control-label mb-1">Jml_gu</label>
                                <input type="number" class="form-control" id="jml_gu" name="jml_gu[]" placeholder="Enter Jml_gu">
                            </div>
                            <div class="form-group mb-3">
                                <label for="jml_sts" class="control-label mb-1">Jml_sts</label>
                                <input type="number" class="form-control" id="jml_sts" name="jml_sts[]" placeholder="Enter Jml_sts">
                            </div>
                            <div class="form-group mb-3">
                                <label for="kode" class="control-label mb-1">Kode</label>
                                <input type="text" class="form-control" id="kode" name="kode[]" value="{{ $item->kode_unit_kerja }}" placeholder="Enter Kode">
                            </div>
                        @endforeach
                        
                       

                    <div class="col-sm-offset-2 col-sm-10 mt-3">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="ajaxModelEdit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sippolUnitKerjaFormEdit" name="sippolUnitKerjaFormEdit" class="form-horizontal">
                   <input type="hidden" name="id" id="sippolUnitKerja_id">
                            <div class="form-group mb-3">
                                <label for="id_bast_unit_kerja" class="control-label mb-1">unit_kerja</label>
                                <input type="hidden" id="id_bast_unit_kerjax" name="id_bast_unit_kerja[]">
                                <input type="hidden" id="id_periodex" name="id_periode[]">
                                <input type="text" class="form-control" id="nama_unit_kerjax" name="nama_unit_kerja[]" disabled>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="jml_gu" class="control-label mb-1">Jml_gu</label>
                                <input type="number" class="form-control" id="jml_gux" name="jml_gu[]" placeholder="Enter Jml_gu">
                                <small class="form-text text-muted" id="harga_display">Rp 0</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="jml_sts" class="control-label mb-1">Jml_sts</label>
                                <input type="number" class="form-control" id="jml_stsx" name="jml_sts[]" placeholder="Enter Jml_sts">
                                <small class="form-text text-muted" id="harga_displayx">Rp 0</small>
                            </div>
                            <div class="form-group mb-3">
                                <label for="kode" class="control-label mb-1">Kode</label>
                                <input type="text" class="form-control" id="kodex" name="kode[]" placeholder="Enter Kode">
                            </div>                      
                       

                    <div class="col-sm-offset-2 col-sm-10 mt-3">
                     <button type="submit" class="btn btn-primary" id="saveBtnEdit" value="create">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajaxModelBP" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="simpanBp" name="simpanBp" class="form-horizontal" enctype="multipart/form-data">
                   <input type="hidden" name="id" id="sippolUnitKerja_id">
                            <input type="hidden" id="id_periode" name="id_periode" value="{{ $id }}">
                            <div class="form-group mb-3">
                                <label for="kode" class="control-label mb-1">file bp22</label>
                                <input type="file" class="form-control" id="bp" name="bp">
                            </div>                      
                       

                    <div class="col-sm-offset-2 col-sm-10 mt-3">
                     <button type="submit" class="btn btn-primary" id="saveBp" value="create">Save changes</button>
                    </div>
                </form>
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
          <input type="hidden" id="id_periode" name="id_periode" value="{{ $id }}">
          @foreach ($tanggal as $tgl )
              <a href="javascript:void(0);" class="btn btn-success kategori-btn" data-route-url="{{ route('sippol-bp-dua-duas.tanggal',[$id,$tgl->tanggal]) }}">{{ $tgl->tanggal }}</a>
          @endforeach
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btnSmpn">Simpan</button>
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
    $('#jml_gux').on('keyup', function() {
        let value = $(this).val().replace(/\D/g, '');
        let formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value || 0);
        $('#harga_display').text(formatted);
    });
    $('#jml_stsx').on('keyup', function() {
        let value = $(this).val().replace(/\D/g, '');
        let formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value || 0);
        $('#harga_displayx').text(formatted);
    });
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
        ajax: "{{ route('sippol-unit-kerjas.data', $id) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'bast_unit_kerja.nama_unit_kerja', name: 'bast_unit_kerja.nama_unit_kerja'},
                    {data: 'jml_gu', name: 'jml_gu'},
                    {data: 'jml_sts', name: 'jml_sts'},
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
    $('#createbp22').click(function () {
        $('#ajaxModelBP').modal('show');
    });

    // Open Modal for Edit
    $('body').on('click', '.editSippolUnitKerja', function () {
        var id = $(this).data('id');
        $.get('/sippol/sippol-unit-kerjas/edit/' + id, function (data) {
            $('#modelHeading').html("Edit SippolUnitKerja");
            $('#saveBtn').val("edit-user");
            $('#ajaxModelEdit').modal('show');
            $('#sippolUnitKerja_id').val(data.id);
            $('#id_bast_unit_kerjax').val(data.id_bast_unit_kerja);
                $('#jml_gux').val(data.jml_gu);
                $('#jml_stsx').val(data.jml_sts);
                $('#id_periodex').val(data.id_periode);
                $('#kodex').val(data.kode);
                $('#nama_unit_kerjax').val(data.bast_unit_kerja.nama_unit_kerja);
        })
    });

    // Save/Update Data
    $('#saveBtn').click(function (e) {
        e.preventDefault();

        let btn = $(this);
        btn.prop('disabled', true).html('Sending...');

        let form = $('#sippolUnitKerjaForm')[0];
        let formData = new FormData(form);

        $.ajax({
            url: "{{ route('sippol-unit-kerjas.store') }}",
            type: "POST",
            data: formData,
            processData: false, // WAJIB untuk FormData
            contentType: false, // WAJIB untuk FormData
            dataType: 'json',
            success: function (response) {
                $('#sippolUnitKerjaForm')[0].reset();
                $('#ajaxModel').modal('hide');
                table.draw();

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.success ?? 'Data saved successfully',
                });

                btn.prop('disabled', false).html('Save Changes');
            },
            error: function (xhr) {
                btn.prop('disabled', false).html('Save Changes');

                let errorMessage = 'Something went wrong.';

                if (xhr.status === 422) {
                    // Laravel Validation Error
                    let errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('\n');
                } else if (xhr.responseJSON?.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage,
                });
            }
        });
    });

    $('#saveBtnEdit').click(function (e) {
        e.preventDefault();

        let btn = $(this);
        btn.prop('disabled', true).html('Sending...');

        let form = $('#sippolUnitKerjaFormEdit')[0];
        let formData = new FormData(form);

        $.ajax({
            url: "{{ route('sippol-unit-kerjas.store') }}",
            type: "POST",
            data: formData,
            processData: false, // WAJIB untuk FormData
            contentType: false, // WAJIB untuk FormData
            dataType: 'json',
            success: function (response) {
                $('#sippolUnitKerjaFormEdit')[0].reset();
                $('#ajaxModelEdit').modal('hide');
                table.draw();

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.success ?? 'Data saved successfully',
                });

                btn.prop('disabled', false).html('Save Changes');
            },
            error: function (xhr) {
                btn.prop('disabled', false).html('Save Changes');

                let errorMessage = 'Something went wrong.';

                if (xhr.status === 422) {
                    // Laravel Validation Error
                    let errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('\n');
                } else if (xhr.responseJSON?.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage,
                });
            }
        });
    });
    $('#saveBp').click(function (e) {
        e.preventDefault();

        let btn = $(this);
        btn.prop('disabled', true).html('Sending...');

        let form = $('#simpanBp')[0];
        let formData = new FormData(form); // Correctly collects all form data, including the file input

        $.ajax({
            url: "{{ route('sippol-bp-dua-duas.store') }}",
            type: "POST",
            data: formData,
            processData: false, // Required for file uploads to prevent jQuery from processing the data
            contentType: false, // Required for file uploads to prevent jQuery from setting the Content-Type header
            dataType: 'json',
            success: function (response) {
                $('#simpanBp')[0].reset();
                $('#ajaxModelBP').modal('hide');
                table.draw();

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.success ?? 'Data saved successfully',
                });

                btn.prop('disabled', false).html('Save Changes');
            },
            error: function (xhr) {
                btn.prop('disabled', false).html('Save Changes');

                let errorMessage = 'Something went wrong.';

                if (xhr.status === 422) {
                    // Laravel Validation Error
                    let errors = xhr.responseJSON.errors;
                    errorMessage = Object.values(errors).flat().join('\n');
                } else if (xhr.responseJSON?.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage,
                });
            }
        });
    });
    $('#bersih').on('click', function () {
            $('#formBersih')[0].reset();
            $('#statusBersih').modal('show');
    });
    $('#btnSmpn').on('click', function () {
        let formData = new FormData($('#formBersih')[0]);
        
        $.ajax({
            url: "{{ route('sippol-bp-dua-duas.bersih') }}",
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
    $('.kategori-btn').on('click', function(e) {
            e.preventDefault();
            var routeUrl = $(this).data('route-url');

            // Example: Show a loading state or disable the button
            $(this).prop('disabled', true).text('Processing...');

            $.ajax({
                url: routeUrl,
                type: 'get',
                success: function(response) {
                    // alert('Kategori updated successfully!');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error updating kategori: ' + xhr.responseText);
                    console.error('Error:', xhr.responseText);
                },
                complete: function() {
                    // Re-enable the button after the request is complete
                    $('.kategori-btn').prop('disabled', false).text(function() {
                        return $(this).data('kategori'); // Restore original text
                    });
                }
            });
        });
    
  });
</script>
@endsection