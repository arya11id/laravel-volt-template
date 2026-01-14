<table class="table table-bordered" id="m4nuk">
    @if (isset($result[1]))
    <thead>
        <tr>
            <th colspan="6" class="text-left" style="background-color: #0ccaca;">Uang Panjar</th>
        </tr>
        <tr>
            <th>No</th>
            <th>TANGGAL</th>
            <th>KODE</th>
            <th>URAIAN</th>
            <th>PENERIMAAN</th>
            <th>PENGELUARAN</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($result[1] as $jenis)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $jenis->tanggal }}</td>
                <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">{{ $jenis->kode }}</td>
                <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">{{ $jenis->uraian }}</td>
                <td>Rp {{ number_format($jenis->penerimaan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($jenis->pengeluaran, 0, ',', '.') }}</td>
            </tr>
            @if ($loop->last)
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="4" class="text-center">TOTAL</td>
                <td>Rp {{ number_format(collect($result[1])->sum('penerimaan'), 0, ',', '.') }}</td>
                <td>Rp {{ number_format(collect($result[1])->sum('pengeluaran'), 0, ',', '.') }}</td>
            </tr>
            @endif
        @endforeach
    </tbody>
    @endif
    @if (isset($result[2]))
    <thead>
        <tr>
            <th colspan="6" class="text-left" style="background-color: #0ccaca;">PPH 21</th>
        </tr>
        <tr>
            <th>No</th>
            <th>TANGGAL</th>
            <th>KODE</th>
            <th>URAIAN</th>
            <th>PENERIMAAN</th>
            <th>PENGELUARAN</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($result[2] as $jenis)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $jenis->tanggal }}</td>
                <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">{{ $jenis->kode }}</td>
                <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">{{ $jenis->uraian }}</td>
                <td>Rp {{ number_format($jenis->penerimaan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($jenis->pengeluaran, 0, ',', '.') }}</td>
            </tr>
            @if ($loop->last)
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="4" class="text-center">TOTAL</td>
                <td>Rp {{ number_format(collect($result[2])->sum('penerimaan'), 0, ',', '.') }}</td>
                <td>Rp {{ number_format(collect($result[2])->sum('pengeluaran'), 0, ',', '.') }}</td>
            </tr>
            @endif
        @endforeach
    </tbody>
    @endif
    @if (isset($result[3]))
    <thead>
        <tr>
            <th colspan="6" class="text-left" style="background-color: #0ccaca;">PPH 22</th>
        </tr>
        <tr>
            <th>No</th>
            <th>TANGGAL</th>
            <th>KODE</th>
            <th>URAIAN</th>
            <th>PENERIMAAN</th>
            <th>PENGELUARAN</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($result[3] as $jenis)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $jenis->tanggal }}</td>
                <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">{{ $jenis->kode }}</td>
                <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">{{ $jenis->uraian }}</td>
                <td>Rp {{ number_format($jenis->penerimaan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($jenis->pengeluaran, 0, ',', '.') }}</td>
            </tr>
            @if ($loop->last)
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="4" class="text-center">TOTAL</td>
                <td>Rp {{ number_format(collect($result[3])->sum('penerimaan'), 0, ',', '.') }}</td>
                <td>Rp {{ number_format(collect($result[3])->sum('pengeluaran'), 0, ',', '.') }}</td>
            </tr>
            @endif
        @endforeach
    </tbody>
    @endif
    @if (isset($result[4]))
    <thead>
        <tr>
            <th colspan="6" class="text-left" style="background-color: #0ccaca;">PPH 23</th>
        </tr>
        <tr>
            <th>No</th>
            <th>TANGGAL</th>
            <th>KODE</th>
            <th>URAIAN</th>
            <th>PENERIMAAN</th>
            <th>PENGELUARAN</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($result[4] as $jenis)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $jenis->tanggal }}</td>
                <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">{{ $jenis->kode }}</td>
                <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">{{ $jenis->uraian }}</td>
                <td>Rp {{ number_format($jenis->penerimaan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($jenis->pengeluaran, 0, ',', '.') }}</td>
            </tr>
            @if ($loop->last)
            <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="4" class="text-center">TOTAL</td>
                <td>Rp {{ number_format(collect($result[4])->sum('penerimaan'), 0, ',', '.') }}</td>
                <td>Rp {{ number_format(collect($result[4])->sum('pengeluaran'), 0, ',', '.') }}</td>
            </tr>
            @endif
        @endforeach
    </tbody>
    @endif
    @if (isset($result[5]))           
        <thead>
            <tr>
                <th colspan="6" class="text-left" style="background-color: #0ccaca;">PPN</th>
            </tr>
            <tr>
                <th>No</th>
                <th>TANGGAL</th>
                <th>KODE</th>
                <th>URAIAN</th>
                <th>PENERIMAAN</th>
                <th>PENGELUARAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($result[5] as $jenis)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jenis->tanggal }}</td>
                    <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">{{ $jenis->kode }}</td>
                    <td style="word-wrap: break-word; white-space: normal; max-width: 200px;">{{ $jenis->uraian }}</td>
                    <td>Rp {{ number_format($jenis->penerimaan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($jenis->pengeluaran, 0, ',', '.') }}</td>
                </tr>
                @if ($loop->last)
                <tr style="font-weight: bold; background-color: #f0f0f0;">
                    <td colspan="4" class="text-center">TOTAL</td>
                    <td>Rp {{ number_format(collect($result[5])->sum('penerimaan'), 0, ',', '.') }}</td>
                    <td>Rp {{ number_format(collect($result[5])->sum('pengeluaran'), 0, ',', '.') }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>                        
    @endif
</table>