<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Imports\PenghasilanImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreDataRequest;
use App\Http\Requests\UpdateDataRequest;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Data::all();
        return view('data.index', compact('datas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDataRequest $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new PenghasilanImport, $request->file('file'));

        toast()->success('Data berhasil diimport');
        return redirect()->route('import.data')->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(Data $data)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Data $data)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDataRequest $request, Data $data)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Data $data)
    {
        //
    }
}
