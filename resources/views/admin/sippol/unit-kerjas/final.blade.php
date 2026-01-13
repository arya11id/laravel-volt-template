@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>Periode : {{ $SippolPeriode->nama_periode }}, {{ \Carbon\Carbon::parse($SippolPeriode->tgl)->translatedFormat('d F Y') }}<br>Total Pagu : Rp {{ number_format($SippolUnitKerja->sum('jml_gu'), 0, ',', '.') }}</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive py-4">                
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>KODE</th>
                            <th>NAMA</th>
                            <th>GU</th>
                            <th>STS</th>
                            <th>INPUTAN</th>
                            <th>SISA</th>
                            <th>pph21 penerimaan</th>
                            <th>pph21 pengeluaran</th>
                            <th>sisa pph21</th>
                            <th>pph22 penerimaan</th>
                            <th>pph22 pengeluaran</th>
                            <th>sisa pph22</th>
                            <th>pph23 penerimaan</th>
                            <th>pph23 pengeluaran</th>
                            <th>sisa pph23</th>
                            <th>ppn penerimaan</th>
                            <th>ppn pengeluaran</th>
                            <th>sisa ppn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $jenis)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $jenis->kode }}</td>
                                <td>{{ $jenis->nama_unit_kerja }}</td>
                                <td>Rp {{ number_format($jenis->jml_gu, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($jenis->jml_sts, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($jenis->panjar, 0, ',', '.') }}
                                <td>Rp {{ number_format($jenis->jml_gu - ($jenis->jml_sts + $jenis->panjar), 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format($jenis->pph21_penerimaan, 0, ',', '.') }}
                                <td>Rp {{ number_format($jenis->pph21_pengeluaran, 0, ',', '.') }}
                                <td>Rp {{ number_format($jenis->pph21_penerimaan - $jenis->pph21_pengeluaran, 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format($jenis->pph22_penerimaan, 0, ',', '.') }}
                                <td>Rp {{ number_format($jenis->pph22_pengeluaran, 0, ',', '.') }}
                                <td>Rp {{ number_format($jenis->pph22_penerimaan - $jenis->pph22_pengeluaran, 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format($jenis->pph23_penerimaan, 0, ',', '.') }}
                                <td>Rp {{ number_format($jenis->pph23_pengeluaran, 0, ',', '.') }}
                                <td>Rp {{ number_format($jenis->pph23_penerimaan - $jenis->pph23_pengeluaran, 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format($jenis->ppn_penerimaan, 0, ',', '.') }}
                                <td>Rp {{ number_format($jenis->ppn_pengeluaran, 0, ',', '.') }}
                                <td>Rp {{ number_format($jenis->ppn_penerimaan - $jenis->ppn_pengeluaran, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow">
                <div class="card-header border-gray-100 d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">panjar ok</h2>
                </div>
                <div class="card-body">
                    <p>Berikut Data Lembaga yang sudah klop sippol</p>
                    <table>
                        <tbody>
                            @foreach ($panjarok as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}.&nbsp;&nbsp;</td>
                                    <td>{{ $item->nama_unit_kerja }}</td>
                                    {{-- <td>&nbsp;:&nbsp;</td> --}}
                                    {{-- <td>Rp {{ number_format($item->hasil, 0, ',', '.') }}</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow">
                <div class="card-header border-gray-100 d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">panjar minus</h2>
                    
                </div>
                <div class="card-body">
                    <p>List Lembaga yang sudah input namun masih ada kelebihan anggaran</p>
                    <table>
                        <tbody>
                            @foreach ($panjarminus as $item1)
                                <tr>
                                    <td>{{ $loop->iteration }}.&nbsp;&nbsp;</td>
                                    <td>{{ $item1->nama_unit_kerja }}</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td>Rp {{ number_format($item1->jml_gu - ($item1->jml_sts + $item1->panjar), 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow">
                <div class="card-header border-gray-100 d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">panjar kurang input</h2>
                </div>
                <div class="card-body">
                    <p>List Lembaga yang sudah input namun masih ada sisa</p>
                    <table>
                        <tbody>
                            @foreach ($panjarlebih as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}.&nbsp;&nbsp;</td>
                                    <td>{{ $item->nama_unit_kerja }}</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td>Rp {{ number_format($item->hasil, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow">
                <div class="card-header border-gray-100 d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">panjar belum input</h2>
                    
                </div>
                <div class="card-body">
                    <p>Berikut Data Lembaga yang belum input sippol</p>
                    <table>
                        <tbody>
                            @foreach ($beluminput as $item1)
                                <tr>
                                    <td>{{ $loop->iteration }}.&nbsp;&nbsp;</td>
                                    <td>{{ $item1->nama_unit_kerja }}</td>
                                    {{-- <td>&nbsp;:&nbsp;</td> --}}
                                    {{-- <td>Rp {{ number_format($item1->jml_gu - ($item1->jml_sts + $item1->panjar), 0, ',', '.') }}</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
    });
</script>
@endsection