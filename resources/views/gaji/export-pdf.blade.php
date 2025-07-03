<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .title {
            font-weight: bold;
            font-size: 16px;
        }
        .bordered td, .bordered th {
            border: 1px solid #000;
            padding: 5px;
        }
        .space {
            margin-top: 20px;
        }
        .bold {
            font-weight: bold;
        }
        .thp {
            font-size: 14px;
            font-weight: bold;
            border-top: 1px solid #000;
            width: 200px;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td>
                <span class="title">PT. Sejahtera Bersama</span><br>
                Perusahaan Dagang Mainan<br><br>
            </td>
            <td class="text-right">
                <img src="{{ public_path('logo.png') }}" alt="logo" height="40"><br>
                Talenta.co
            </td>
        </tr>
    </table>

    <h3 class="text-center">CONTOH SLIP GAJI</h3>

    <table>
        <tr>
            <td>ID</td><td>: {{ $gaji->karyawan->nip }}</td>
            <td>JABATAN</td><td>: {{ $gaji->karyawan->jabatan }}</td>
        </tr>
        <tr>
            <td>NAMA</td><td>: {{ $gaji->karyawan->nama }}</td>
            <td>STS</td><td>: {{ $gaji->karyawan->status ?? '-' }}</td>
        </tr>
    </table>

    <div class="space"></div>

    <table class="bordered">
        <thead>
            <tr>
                <th class="text-center">PENERIMAAN</th>
                <th class="text-center">POTONGAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Gaji Pokok : Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}<br>
                    Tunjangan : Rp {{ number_format($gaji->karyawan->tunjangan, 0, ',', '.') }}<br>
                    Perjalanan Dinas : Rp {{ number_format($gaji->perjalanan_dinas, 0, ',', '.') }}<br>
                    Lembur : Rp {{ number_format($gaji->lembur, 0, ',', '.') }}<br>
                    THR : Rp {{ number_format($gaji->thr, 0, ',', '.') }}<br>
                    Pakaian Dinas : Rp {{ number_format($gaji->pakaian_dinas, 0, ',', '.') }}
                </td>
                <td>
                    BPJS TK : Rp {{ number_format($gaji->bpjs_tk, 0, ',', '.') }}<br>
                    BPJS KES : Rp {{ number_format($gaji->bpjs_kes, 0, ',', '.') }}<br>
                    BPJS TK (Perusahaan) : Rp {{ number_format($gaji->bpjs_tk_perusahaan, 0, ',', '.') }}<br>
                    BPJS KES (Perusahaan) : Rp {{ number_format($gaji->bpjs_kes_perusahaan, 0, ',', '.') }}<br>
                    PPH 21 : Rp {{ number_format($gaji->pph, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="bold">
                    TOTAL PENERIMAAN: Rp {{ number_format(
                        $gaji->gaji_pokok + $gaji->karyawan->tunjangan + $gaji->perjalanan_dinas + $gaji->lembur + $gaji->thr + $gaji->pakaian_dinas, 0, ',', '.') }}
                </td>
                <td class="bold">
                    TOTAL POTONGAN: Rp {{ number_format(
                        $gaji->bpjs_tk + $gaji->bpjs_kes + $gaji->bpjs_tk_perusahaan + $gaji->bpjs_kes_perusahaan + $gaji->pph, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="space"></div>

    <table>
        <tr>
            <td><strong>THP:</strong></td>
            <td class="thp">Rp {{ number_format($gaji->total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="space"></div>

    <table style="width: 100%;">
        <tr>
            <td></td>
            <td class="text-right">
                Diterima Oleh,<br><br><br><br>
                <u>{{ $gaji->karyawan->nama }}</u>
            </td>
        </tr>
    </table>
</body>
</html>
