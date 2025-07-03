<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: left;
        }

        thead th {
            background-color: #f2f2f2;
        }

        tfoot td {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h3>Data Gaji Bulan {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</h3>

    <table>
        <thead>
            <tr>
                <th rowspan="2">Nama</th>
                <th rowspan="2">NIP</th>
                <th rowspan="2">Gaji Pokok</th>
                <th rowspan="2">Perjalanan Dinas</th>
                <th rowspan="2">Lembur</th>
                <th rowspan="2">THR</th>
                <th rowspan="2">Pakaian Dinas</th>
                <th colspan="2">Karyawan</th>
                <th colspan="2">Perusahaan</th>
                <th rowspan="2">PPH</th>
                <th rowspan="2">Total</th>
                <th rowspan="2">Tunjangan</th>
                <th rowspan="2">No Rekening</th>
            </tr>
            <tr>
                <th>BPJS TK</th>
                <th>BPJS KES</th>
                <th>BPJS TK</th>
                <th>BPJS KES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gajis as $gaji)
            <tr>
                <td>{{ $gaji->karyawan->nama }}</td>
                <td>{{ $gaji->karyawan->nip }}</td>
                <td>{{ $gaji->gaji_pokok }}</td>
                <td>{{ $gaji->perjalanan_dinas }}</td>
                <td>{{ $gaji->lembur }}</td>
                <td>{{ $gaji->thr }}</td>
                <td>{{ $gaji->pakaian_dinas }}</td>
                <td>{{ $gaji->bpjs_tk }}</td>
                <td>{{ $gaji->bpjs_kes }}</td>
                <td>{{ $gaji->bpjs_tk_perusahaan }}</td>
                <td>{{ $gaji->bpjs_kes_perusahaan }}</td>
                <td>{{ $gaji->pph }}</td>
                <td>{{ $gaji->total }}</td>
                <td>{{ $gaji->karyawan->tunjangan }}</td>
                <td>{{ $gaji->karyawan->no_rekening ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="12" align="right">Jumlah Karyawan:</td>
                <td colspan="3">{{ $gajis->count() }} Orang</td>
            </tr>
            <tr>
                <td colspan="12" align="right">Total Seluruh Gaji:</td>
                <td colspan="3">{{ $gajis->sum('total') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
