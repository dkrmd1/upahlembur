<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Lembur;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->format('Y-m');
        $search = $request->search;

        $gajis = Gaji::with('karyawan')
            ->where('bulan', $bulan)
            ->when($search, function ($query) use ($search) {
                $query->whereHas('karyawan', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                      ->orWhere('nip', 'like', "%$search%");
                });
            })
            ->get();

        $karyawans = Karyawan::all();
        $daftarBulan = collect(range(0, 11))->map(fn($i) => Carbon::now()->subMonths($i)->format('Y-m'));

        $lemburTotals = [];
        foreach ($karyawans as $karyawan) {
            $totalLembur = Lembur::where('karyawan_id', $karyawan->id)
                ->whereYear('tanggal', Carbon::parse($bulan)->year)
                ->whereMonth('tanggal', Carbon::parse($bulan)->month)
                ->sum('upah');
            $lemburTotals[$karyawan->id] = $totalLembur;
        }

        return view('gaji.index', compact('gajis', 'karyawans', 'bulan', 'lemburTotals', 'daftarBulan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id'      => 'required|exists:karyawans,id',
            'bulan'            => 'required|date_format:Y-m',
            'gaji_pokok'       => 'required',
            'perjalanan_dinas' => 'required',
            'lembur'           => 'required',
            'thr'              => 'required',
            'pakaian_dinas'    => 'required',
            'bpjs_kes'         => 'required',
            'bpjs_tk'          => 'required',
            'pph'              => 'nullable',
        ]);

        $clean = fn($val) => intval(str_replace('.', '', preg_replace('/[^\d]/', '', $val)));
        $karyawan = Karyawan::findOrFail($request->karyawan_id);

        $data = [
            'gaji_pokok'           => $clean($request->gaji_pokok),
            'tunjangan'            => $karyawan->tunjangan ?? 0,
            // rekening tidak disimpan di gaji, ambil dari relasi karyawan saat tampil
            'perjalanan_dinas'     => $clean($request->perjalanan_dinas),
            'lembur'               => $clean($request->lembur),
            'thr'                  => $clean($request->thr),
            'pakaian_dinas'        => $clean($request->pakaian_dinas),
            'bpjs_kes'             => $clean($request->bpjs_kes),
            'bpjs_tk'              => $clean($request->bpjs_tk),
            'bpjs_tk_perusahaan'   => $karyawan->bpjs_tk_perusahaan ?? 0,
            'bpjs_kes_perusahaan'  => $karyawan->bpjs_kes_perusahaan ?? 0,
            'pph'                  => $clean($request->pph ?? 0),
        ];

        $data['total'] =
            $data['gaji_pokok'] +
            $data['tunjangan'] +
            $data['perjalanan_dinas'] +
            $data['lembur'] +
            $data['thr'] +
            $data['pakaian_dinas'] -
            ($data['bpjs_kes'] + $data['bpjs_tk']);

        Gaji::create([
            'karyawan_id' => $request->karyawan_id,
            'bulan'       => $request->bulan,
        ] + $data);

        return back()->with('success', 'Data gaji berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gaji_pokok'       => 'required',
            'perjalanan_dinas' => 'required',
            'lembur'           => 'required',
            'thr'              => 'required',
            'pakaian_dinas'    => 'required',
            'bpjs_kes'         => 'required',
            'bpjs_tk'          => 'required',
            'pph'              => 'nullable',
        ]);

        $gaji = Gaji::findOrFail($id);
        $karyawan = $gaji->karyawan;
        $clean = fn($val) => intval(str_replace('.', '', preg_replace('/[^\d]/', '', $val)));

        $data = [
            'gaji_pokok'           => $clean($request->gaji_pokok),
            'tunjangan'            => $karyawan->tunjangan ?? 0,
            // rekening tidak disimpan di gaji, ambil dari relasi karyawan saat tampil
            'perjalanan_dinas'     => $clean($request->perjalanan_dinas),
            'lembur'               => $clean($request->lembur),
            'thr'                  => $clean($request->thr),
            'pakaian_dinas'        => $clean($request->pakaian_dinas),
            'bpjs_kes'             => $clean($request->bpjs_kes),
            'bpjs_tk'              => $clean($request->bpjs_tk),
            'bpjs_tk_perusahaan'   => $karyawan->bpjs_tk_perusahaan ?? 0,
            'bpjs_kes_perusahaan'  => $karyawan->bpjs_kes_perusahaan ?? 0,
            'pph'                  => $clean($request->pph ?? 0),
        ];

        $data['total'] =
            $data['gaji_pokok'] +
            $data['tunjangan'] +
            $data['perjalanan_dinas'] +
            $data['lembur'] +
            $data['thr'] +
            $data['pakaian_dinas'] -
            ($data['bpjs_kes'] + $data['bpjs_tk']);

        $gaji->update($data);

        return back()->with('success', 'Data gaji berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $gaji = Gaji::find($id);

        if (!$gaji) {
            return redirect()->route('gaji.index')->with('error', 'Data gaji tidak ditemukan.');
        }

        try {
            $gaji->delete();
            return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('gaji.index')->with('error', 'Gagal menghapus data gaji.');
        }
    }

    public function getTotalLembur(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'bulan'       => 'required|date_format:Y-m',
        ]);

        $totalLembur = Lembur::where('karyawan_id', $request->karyawan_id)
            ->whereYear('tanggal', Carbon::parse($request->bulan)->year)
            ->whereMonth('tanggal', Carbon::parse($request->bulan)->month)
            ->sum('upah');

        return response()->json(['total_lembur' => $totalLembur]);
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->format('Y-m');
        $search = $request->search;

        $query = Gaji::with('karyawan')->where('bulan', $bulan);

        if ($search) {
            $query->whereHas('karyawan', function ($q) use ($search) {
                $q->where('nip', 'like', "%$search%")
                  ->orWhere('nama', 'like', "%$search%");
            });
        }

        $gajis = $query->get();
        $customSize = [0, 0, 184.25, 297.64];

        $pdf = Pdf::loadView('gaji.slip-batch', [
            'gajis' => $gajis,
            'bulan' => $bulan,
        ])->setPaper($customSize, 'portrait');

        return $pdf->download('slip-gaji-' . $bulan . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->format('Y-m');
        $search = $request->search;

        $query = Gaji::with('karyawan')->where('bulan', $bulan);

        if ($search) {
            $query->whereHas('karyawan', function ($q) use ($search) {
                $q->where('nip', 'like', "%$search%")
                  ->orWhere('nama', 'like', "%$search%");
            });
        }

        $gajis = $query->get();

        $view = View::make('gaji.export-excel', [
            'gajis' => $gajis,
            'bulan' => $bulan,
        ])->render();

        return response()->streamDownload(function () use ($view) {
            echo $view;
        }, 'laporan-gaji-' . $bulan . '.xls');
    }
}
