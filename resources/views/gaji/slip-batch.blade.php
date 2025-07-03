<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 4px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
        }

        .slip {
            border: 1px solid #3498db;
            border-radius: 4px;
            padding: 6px;
            margin-bottom: 4px;
        }

        .title {
            font-weight: bold;
            font-size: 8.5px;
            text-align: center;
            margin-bottom: 3px;
            border-bottom: 1px dashed #3498db;
            padding-bottom: 1px;
        }

        table {
            width: 100%;
            font-size: 7.5px;
        }

        td {
            padding: 1px;
            vertical-align: top;
        }

        .text-right {
            text-align: right;
        }

        .section-title {
            font-weight: bold;
            background-color: #ecf6fd;
            border-top: 1px solid #3498db;
            margin-top: 2px;
            padding-top: 1px;
        }

        .divider {
            margin: 3px 0;
            border-top: 1px dashed #ccc;
        }

        .highlight {
            background-color: #f0f8ff;
        }
    </style>
</head>
<body>
    @foreach($gajis as $index => $gaji)
    <div class="slip">
        <div class="title">
            Slip Gaji<br>
            {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}
        </div>

        <table>
            <tr><td>Nama</td><td>: {{ $gaji->karyawan->nama }}</td></tr>
            <tr><td>NIP</td><td>: {{ $gaji->karyawan->nip }}</td></tr>
            <tr><td>Jabatan</td><td>: {{ $gaji->karyawan->jabatan }}</td></tr>
        </table>

        <div class="divider"></div>

        <table>
            <tr><td>Gaji Pokok</td><td class="text-right">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td></tr>
            <tr><td>Tunjangan</td><td class="text-right">Rp {{ number_format($gaji->karyawan->tunjangan, 0, ',', '.') }}</td></tr>
            <tr><td>Perjalanan Dinas</td><td class="text-right">Rp {{ number_format($gaji->perjalanan_dinas, 0, ',', '.') }}</td></tr>
            <tr><td>Lembur</td><td class="text-right">Rp {{ number_format($gaji->lembur, 0, ',', '.') }}</td></tr>
            <tr><td>THR</td><td class="text-right">Rp {{ number_format($gaji->thr, 0, ',', '.') }}</td></tr>
            <tr><td>Pakaian Dinas</td><td class="text-right">Rp {{ number_format($gaji->pakaian_dinas, 0, ',', '.') }}</td></tr>
        </table>

        <div class="section-title">Potongan (Karyawan)</div>
        <table>
            <tr><td>BPJS TK</td><td class="text-right">Rp {{ number_format($gaji->bpjs_tk, 0, ',', '.') }}</td></tr>
            <tr><td>BPJS KES</td><td class="text-right">Rp {{ number_format($gaji->bpjs_kes, 0, ',', '.') }}</td></tr>
            <tr><td>PPH</td><td class="text-right">Rp {{ number_format($gaji->pph, 0, ',', '.') }}</td></tr>
        </table>

        <div class="section-title">Tanggungan (Perusahaan)</div>
        <table>
            <tr><td>BPJS TK</td><td class="text-right">Rp {{ number_format($gaji->bpjs_tk_perusahaan, 0, ',', '.') }}</td></tr>
            <tr><td>BPJS KES</td><td class="text-right">Rp {{ number_format($gaji->bpjs_kes_perusahaan, 0, ',', '.') }}</td></tr>
        </table>

        <div class="divider"></div>

        <table>
            <tr class="highlight">
                <td><b>Total Diterima</b></td>
                <td class="text-right"><b>Rp {{ number_format($gaji->total, 0, ',', '.') }}</b></td>
            </tr>
        </table>
    </div>

    @if (!$loop->last)
    <div style="page-break-after: always;"></div>
    @endif
    @endforeach
</body>
</html>
