<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIP</th>
            <th>Hari Kerja (Jam)</th>
            <th>Hari Libur (Jam)</th>
            <th>Total Jam</th>
            <th>Total Upah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->karyawan->nama }}</td>
            <td>{{ $item->karyawan->nip }}</td>
            <td>{{ $item->hari_kerja_jam }}</td>
            <td>{{ $item->hari_libur_jam }}</td>
            <td>{{ $item->total_jam }}</td>
            <td>{{ $item->total_upah }}</td>
        </tr>
        @endforeach
        <tr>
            <th colspan="5">TOTAL</th>
            <th>{{ $totalJam }}</th>
            <th>{{ $totalUpah }}</th>
        </tr>
    </tbody>
</table>
