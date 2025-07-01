<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Excel Gaji</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }
        h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #f2f2f2;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h3>Laporan Gaji Bulan {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</h3>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">NIP</th>
                <th rowspan="2">Jabatan</th>
                <th rowspan="2">Group</th>
                <th rowspan="2">Gaji Pokok</th>
                <th rowspan="2">Perjalanan Dinas</th>
                <th rowspan="2">Lembur</th>
                <th rowspan="2">THR</th>
                <th rowspan="2">Pakaian Dinas</th>
                <th colspan="2" class="text-center">Karyawan</th>
                <th colspan="2" class="text-center">Perusahaan</th>
                <th rowspan="2">PPH</th>
                <th rowspan="2">Total</th>
            </tr>
            <tr>
                <th>BPJS TK</th>
                <th>BPJS KES</th>
                <th>BPJS TK</th>
                <th>BPJS KES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gajis as $i => $gaji)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $gaji->karyawan->nama }}</td>
                <td>{{ $gaji->karyawan->nip }}</td>
                <td>{{ $gaji->karyawan->jabatan }}</td>
                <td>{{ $gaji->karyawan->group }}</td>
                <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($gaji->perjalanan_dinas, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($gaji->lembur, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($gaji->thr, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($gaji->pakaian_dinas, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($gaji->bpjs_tk, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($gaji->bpjs_kes, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($gaji->bpjs_tk_perusahaan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($gaji->bpjs_kes_perusahaan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($gaji->pph, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($gaji->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
