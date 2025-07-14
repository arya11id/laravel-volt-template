@extends('layouts.app')
@section('customCSS')
    <style>
        .tracking-detail {
            padding: 3rem 0
        }

        #tracking {
            margin-bottom: 1rem
        }

        [class*=tracking-status-] p {
            margin: 0;
            font-size: 1.1rem;
            color: #fff;
            text-transform: uppercase;
            text-align: center
        }

        [class*=tracking-status-] {
            padding: 1.6rem 0
        }

        .tracking-status-intransit {
            background-color: #65aee0
        }

        .tracking-status-outfordelivery {
            background-color: #f5a551
        }

        .tracking-status-deliveryoffice {
            background-color: #f7dc6f
        }

        .tracking-status-delivered {
            background-color: #4cbb87
        }

        .tracking-status-attemptfail {
            background-color: #b789c7
        }

        .tracking-status-error,
        .tracking-status-exception {
            background-color: #d26759
        }

        .tracking-status-expired {
            background-color: #616e7d
        }

        .tracking-status-pending {
            background-color: #ccc
        }

        .tracking-status-inforeceived {
            background-color: #214977
        }

        .tracking-list {
            border: 1px solid #e5e5e5
        }

        .tracking-item {
            border-left: 1px solid #e5e5e5;
            position: relative;
            padding: 2rem 1.5rem .5rem 2.5rem;
            font-size: .9rem;
            margin-left: 3rem;
            min-height: 5rem
        }

        .tracking-item:last-child {
            padding-bottom: 4rem
        }

        .tracking-item .tracking-date {
            margin-bottom: .5rem
        }

        .tracking-item .tracking-date span {
            color: #888;
            font-size: 85%;
            padding-left: .4rem
        }

        .tracking-item .tracking-content {
            padding: .5rem .8rem;
            background-color: #f4f4f4;
            border-radius: .5rem;
        }

        .tracking-item .tracking-content span {
            display: block;
            color: #888;
            font-size: medium;
        }

        .tracking-item .tracking-icon {
            line-height: 2.6rem;
            position: absolute;
            left: -1.3rem;
            width: 2.6rem;
            height: 2.6rem;
            text-align: center;
            border-radius: 50%;
            font-size: 1.1rem;
            background-color: #fff;
            color: #fff
        }

        .tracking-item .tracking-icon.status-sponsored {
            background-color: #f68
        }

        .tracking-item .tracking-icon.status-delivered {
            background-color: #4cbb87
        }

        .tracking-item .tracking-icon.status-outfordelivery {
            background-color: #f5a551
        }

        .tracking-item .tracking-icon.status-deliveryoffice {
            background-color: #f7dc6f
        }

        .tracking-item .tracking-icon.status-attemptfail {
            background-color: #b789c7
        }

        .tracking-item .tracking-icon.status-exception {
            background-color: #d26759
        }

        .tracking-item .tracking-icon.status-inforeceived {
            background-color: #214977
        }

        .tracking-item .tracking-icon.status-intransit {
            color: #e5e5e5;
            border: 1px solid #e5e5e5;
            font-size: .6rem
        }

        @media(min-width:992px) {
            .tracking-item {
                margin-left: 10rem
            }

            .tracking-item .tracking-date {
                position: absolute;
                left: -10rem;
                width: 7.5rem;
                text-align: right
            }

            .tracking-item .tracking-date span {
                display: block
            }

            .tracking-item .tracking-content {
                padding: 0;
                background-color: transparent
            }
        }
    </style>
@endsection
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">tracking layanan surat</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Nomor Surat : {{ $data->no_surat }}</h1>
                <p class="mb-0">Keterangan : {{ $data->keterangan }}</p>
                <p class="mb-0">Tanggal Surat : {{ $data->tgl_surat->translatedFormat('d F Y') }}</p>
                <p class="mb-0">Tanggal Pengajuan : {{ $data->tgl_pengajuan->translatedFormat('d F Y') }}</p>
            </div>
        </div>
    </div>
    @include('layouts.alert')
    <div class="card">
        <div class="card-body">
            <div class="container">

                <div class="row">

                    <div class="col-md-12 col-lg-12">
                        <div id="tracking-pre"><button class="btn btn-info mb-3" id="btnAdd">Tambah Tracking
                                Layanan</button></div>
                        <div id="tracking">
                            <div class="text-center tracking-status-intransit">
                                <p class="tracking-status text-tight">Tracking Layanan</p>
                            </div>
                            <div class="tracking-list">
                                @foreach ($tracking as $list)
                                    <div class="tracking-item">
                                        <div class="tracking-icon status-intransit">
                                            <i class="fa fa-book"></i>
                                        </div>
                                        <div class="tracking-date">
                                            {{ $list->tgl_layanan->translatedFormat('d F Y') ?? '-' }}
                                        </div>
                                        <div class="tracking-content">Status : {{ $list->status->nama }}
                                            <span>keterangan:{{ $list->keterangan ?? '-' }}</span>
                                            @if ($list->url_file != null)
                                                <a href="{{ $list->url_file ?? '-' }}" target="_blank"
                                                    class="btn btn-primary btn-sm">Lihat File</a>
                                            @endif
                                            <span>
                                                <button class="btn btn-sm btn-info btn-edit"
                                                    data-id="{{ $list->id }}">Edit</button>
                                                <button class="btn btn-sm btn-danger btn-delete"
                                                    data-id="{{ $list->id }}">Hapus</button>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="tracking-item">
                                    <div class="tracking-icon status-intransit">
                                        {{-- <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                                    </svg> --}}
                                        <i class="fa fa-book"></i>
                                    </div>
                                    <div class="tracking-date">{{ $data->tgl_pengajuan->translatedFormat('d F Y') ?? '-' }}
                                    </div>
                                    <div class="tracking-content">Pengajuan layanan : {{ $data->jenisLayanan->nama }}
                                        <span>keterangan:{{ $data->keterangan ?? '-' }}</span>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="layananModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tracking layanan</h5>
                </div>
                <div class="modal-body">
                    <form id="formLayanan">
                        <input type="hidden" id="layanan_id" name="id">
                        <input type="hidden" id="layanan_surat_id" name="layanan_surat_id" value="{{ $data->id }}">
                        <select name="status_id" id="status_id" class="form-select mb-2">
                            <option value="">Pilih Status</option>
                            @foreach ($status as $status)
                                <option value="{{ $status->id }}">{{ $status->nama }}</option>
                            @endforeach
                        </select>
                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Tanggal layanan</label>
                            <input type="date" name="tgl_layanan" id="tgl_layanan" class="form-control mb-2">
                        </div>
                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control mb-2" placeholder="Keterangan"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Url File(opsional)</label>
                            <input type="text" name="url_file" id="url_file" class="form-control mb-2">
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



@section('customJS')
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function() {

            $('#btnAdd').on('click', function() {
                $('#formLayanan')[0].reset();
                $('#layanan_id').val('');
                $('#layananModal').modal('show');
            });

            $('#btnSave').on('click', function() {
                let id = $('#layanan_id').val();
                let url = id ? `/layanan-surat-detail/${id}` : '{{ route('layanan-surat-detail.store') }}';
                if (id) {
                    $.ajax({
                        url: url, // The URL where the request is sent
                        type: 'PUT', // Specify the HTTP method as PUT
                        data: $('#formLayanan').serialize(), // Serialize your form data

                        // Optional: Add headers if needed (like CSRF token for Laravel)
                        // Note: If you have $.ajaxSetup for CSRF, you don't need this here.
                        // headers: {
                        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        // },

                        success: function(response) {
                            // This function runs if the request is successful (HTTP 2xx status)
                            $('#layananModal').modal('hide'); // Hide the modal
                            location.reload(); // Reload the page
                            // Or, for DataTables, you'd typically use: table.draw();
                            // console.log('Success:', response); // Log the server's response
                        },
                        error: function(xhr, status, error) {
                            // This function runs if the request fails (e.g., HTTP 4xx or 5xx status)
                            console.error("AJAX PUT Error:", status, error);
                            console.error("Response Text:", xhr.responseText);
                            alert(
                                'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
                            ); // Simple error alert
                            // You can parse xhr.responseJSON for validation errors from Laravel
                        }
                    });
                } else {
                    $.post(url, $('#formLayanan').serialize(), function() {
                        $('#layananModal').modal('hide');
                        location.reload();
                    });
                }


            });

            // ...existing code...
            // Change this:
            // To this:
            $(document).on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.get(`/layanan-surat-detail/${id}`, function(data) {
                    $('#layanan_id').val(data.id);
                    $('#status_id').val(data.status_id); // set status if available
                    $('#tgl_layanan').val(data.tgl);
                    $('#url_file').val(data.url_file);
                    $('#keterangan').val(data.keterangan);
                    $('#layananModal').modal('show');
                });
            });
            // ...existing code...

            $(document).on('click', '.btn-delete', function() {
                if (confirm('Yakin ingin menghapus?')) {
                    let id = $(this).data('id');
                    $.ajax({
                        url: `/layanan-surat-detail/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection
