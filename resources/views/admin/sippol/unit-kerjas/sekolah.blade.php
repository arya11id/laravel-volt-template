@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h2>Periode : {{ $SippolPeriode->nama_periode }}, {{ \Carbon\Carbon::parse($SippolPeriode->tgl)->translatedFormat('d F Y') }}<br>Total Pagu {{$SippolUnitKerja->bastUnitKerja->nama_unit_kerja }} : Rp {{ number_format($SippolUnitKerja->jml_gu, 0, ',', '.') }}</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive py-4">      
                <button id="btnExport" class="btn btn-success mb-3">Export to Excel</button>          
                @include('admin.sippol.unit-kerjas.detail-sekolah', ['result' => $result])
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

        $("#btnExport").click(function (e) {
            e.preventDefault();
            var table = document.getElementById("m4nuk");
            if (table) {
                var html = table.outerHTML;
                var blob = new Blob(['\ufeff', html], {
                    type: 'application/vnd.ms-excel'
                });
                var url = URL.createObjectURL(blob);
                var a = document.createElement("a");
                a.href = url;
                a.download = "{{$SippolUnitKerja->bastUnitKerja->nama_unit_kerja }}.xls";
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }
        });
    });
</script>
@endsection