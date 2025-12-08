<table class="table table-bordered" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis</th>
            <th>Tanggal</th>
            <th>sekolah</th>
            <th>KODE</th>
            <th>URAIAN</th>
            <th>Penerimaan</th>
            <th>Pengeluaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach($startFromRow18 as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item[1] }}</td>
            <td>{{ $item[3] }}</td>
            <td>{{ substr($item[5], 0, strpos($item[5], '/')) }}</td>
            <td>{{ $item[5] }}</td>
            <td>{{ $item[6] }}</td>
            <td>{{ $item[14] }}</td>
            <td>{{ $item[15] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>