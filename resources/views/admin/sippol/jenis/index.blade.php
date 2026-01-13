@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>Periode : {{ $SippolPeriode->nama_periode }}, {{ \Carbon\Carbon::parse($SippolPeriode->tgl)->translatedFormat('d F Y') }}<br>Total Pagu : Rp {{ number_format($SippolUnitKerja->sum('jml_gu'), 0, ',', '.') }}</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <a href="javascript:void(0);"
                    class="btn btn-danger kategori-btn"
                    data-route-url="{{ route('sippol-jenis.kategori', ['id' => 100, 'kategori' => 100]) }}">
                    reset kategori
                </a>
            <div class="table-responsive py-4">                
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>action</th>
                            <th>NAMA</th>
                            <th>URUTAN</th>
                            <th>NOMOR</th>
                            <th>MULAI</th>
                            <th>AKHIR</th>
                            <th>total_pengeluaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($SippolJenis as $jenis)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($cek == 5)
                                        <span class="badge bg-success">{{ $jenis->nama }}</span>
                                    @else
                                        @if ($jenis->nama != null)
                                            <span class="badge bg-success">{{ $jenis->nama }}</span>
                                        @else
                                            <a href="javascript:void(0);"
                                                class="btn btn-danger kategori-btn"
                                                data-route-url="{{ route('sippol-jenis.kategori', ['id' => $jenis->id, 'kategori' => 1]) }}">
                                                panjar
                                            </a><br>
                                            <a href="javascript:void(0);" class="btn btn-success kategori-btn" data-route-url="{{ route('sippol-jenis.kategori', ['id' => $jenis->id, 'kategori' => 2]) }}">pph21</a><br>
                                            <a href="javascript:void(0);" class="btn btn-warning kategori-btn" data-route-url="{{ route('sippol-jenis.kategori', ['id' => $jenis->id, 'kategori' => 3]) }}">pph22</a><br>
                                            <a href="javascript:void(0);" class="btn btn-primary kategori-btn" data-route-url="{{ route('sippol-jenis.kategori', ['id' => $jenis->id, 'kategori' => 4]) }}">pph23</a><br>
                                            <a href="javascript:void(0);" class="btn btn-info kategori-btn" data-route-url="{{ route('sippol-jenis.kategori', ['id' => $jenis->id, 'kategori' => 5]) }}">ppn</a><br>
                                        @endif
                                    @endif
                                    
                                    
                                </td>
                                <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">
                                    <a href="#" class="btn btn-link view-rekap-btn" data-toggle="modal" data-target="#rekapModal" data-id="{{ $jenis->id }}">
                                        {{ $jenis->nama_jenis }}
                                    </a>
                                </td>
                                <td>{{ $jenis->urutan }}</td>
                                <td>{{ $jenis->nomor }}</td>
                                <td>{{ $jenis->mulai }}</td>
                                <td>{{ $jenis->akhir }}</td>
                                <td>
                                    <a href="#" class="btn btn-link view-hasil-btn" data-toggle="modal" data-target="#hasilModal" data-id="{{ $jenis->id }}">
                                    Rp {{ number_format($jenis->total_pengeluaran, 0, ',', '.') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="rekapModal" tabindex="-1" role="dialog" aria-labelledby="rekapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rekapModalLabel">Detail Rekap</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded here via AJAX -->
                <table class="table table-bordered" id="rekapTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sekolah</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="rekapBody">
                        {{-- Data akan dimuat di sini --}}
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hasilModal" tabindex="-1" role="dialog" aria-labelledby="rekapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rekapModalLabel">Detail Hasil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded here via AJAX -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="rekapTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sekolah</th>
                                <th>Jml GU</th>
                                <th>Jml STS</th>
                                <th>Jumlah Input</th>
                                <th>Total</th>
                                <th>Kode</th>
                                <th>Sekolah</th>
                            </tr>
                        </thead>
                        <tbody id="hasilBody">
                            {{-- Data akan dimuat di sini --}}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->

@endsection

@section('customJS')
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


<script type="text/javascript">
    $(function () {
        
        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.view-rekap-btn').on('click', function(e) {
            e.preventDefault();
            var jenisId = $(this).data('id');
            $('#rekapContent').html('<p>Loading...</p>'); // Show loading message

            // $.ajax({
            //     url: '/sippol/sippol-jenis/rekap/' + jenisId, // Adjust this URL to your actual API endpoint
            //     type: 'GET',
            //     success: function(response) {
            //         $('#rekapContent').html(response); // Populate modal with response
            //     },
            //     error: function(xhr) {
            //         $('#rekapContent').html('<p class="text-danger">Failed to load data. Please try again.</p>');
            //         console.error('Error:', xhr.responseText);
            //     }
            // });
        $.get('/sippol/sippol-jenis/rekap/' + jenisId, function(data) {
            let tbody = '';
            let grandTotal = 0;

            data.forEach(function(item, index) {
                let total = Number(item.total_pengeluaran) || 0;
                grandTotal += total;

                tbody += `<tr>
                    <td>${index + 1}</td>
                    <td>${item.sekolah}</td>
                    <td class="text-end">
                        ${new Intl.NumberFormat('id-ID', { 
                            style: 'currency', 
                            currency: 'IDR' 
                        }).format(total)}
                    </td>
                </tr>`;
            });

            // 🔽 Tambahkan baris TOTAL
            tbody += `
                <tr class="fw-bold bg-light">
                    <td colspan="2" class="text-center">TOTAL</td>
                    <td class="text-end">
                        ${new Intl.NumberFormat('id-ID', { 
                            style: 'currency', 
                            currency: 'IDR' 
                        }).format(grandTotal)}
                    </td>
                </tr>
            `;

            $('#rekapBody').html(tbody);
        });

        });
        $('.view-hasil-btn').on('click', function(e) {
            e.preventDefault();

            var jenisId = $(this).data('id');
            $('#hasilContent').html('<p>Loading...</p>');

            $.get('/sippol/sippol-jenis/hasil/' + jenisId, function(data) {
                let tbody = '';

                let totalGu = 0;
                let totalSts = 0;
                let totalPengeluaran = 0;
                let totalSisa = 0;

                data.forEach(function(item, index) {
                    let gu = Number(item.jml_gu) || 0;
                    let sts = Number(item.jml_sts) || 0;
                    let pengeluaran = Number(item.total_pengeluaran) || 0;
                    let sisa = gu - sts - pengeluaran;

                    totalGu += gu;
                    totalSts += sts;
                    totalPengeluaran += pengeluaran;
                    totalSisa += sisa;

                    tbody += `<tr>
                        <td>${index + 1}</td>
                        <td>${item.bast_unit_kerja.nama_unit_kerja}</td>
                        <td class="text-end">${formatRupiah(gu)}</td>
                        <td class="text-end">${formatRupiah(sts)}</td>
                        <td class="text-end">${formatRupiah(pengeluaran)}</td>
                        <td class="text-end">${formatRupiah(sisa)}</td>
                        <td>${item.kode}</td>
                        <td>${item.sekolah}</td>
                    </tr>`;
                });

                // 🔽 Baris TOTAL
                tbody += `
                    <tr class="fw-bold bg-light">
                        <td colspan="2" class="text-center">TOTAL</td>
                        <td class="text-end">${formatRupiah(totalGu)}</td>
                        <td class="text-end">${formatRupiah(totalSts)}</td>
                        <td class="text-end">${formatRupiah(totalPengeluaran)}</td>
                        <td class="text-end">${formatRupiah(totalSisa)}</td>
                        <td colspan="2"></td>
                    </tr>
                `;
                tbody += `
                    <tr class="fw-bold bg-light">
                        <td colspan="2" class="text-center">rekap</td>
                        <td class="text-end"></td>
                        <td class="text-end"></td>
                        <td class="text-end">${formatRupiah(totalPengeluaran+totalSts)}</td>
                        <td class="text-end"></td>
                        <td colspan="2"></td>
                    </tr>
                `;

                $('#hasilBody').html(tbody);
            });
        });

        // 🔧 Helper format rupiah (lebih rapi & reusable)
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(angka);
        }

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