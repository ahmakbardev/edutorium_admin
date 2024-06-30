<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasAkhirController extends Controller
{
    //

    public function index()
    {
        $tugasAkhirs = TugasAkhir::with('modul')->get();
        return view('tugasAkhir.index', compact('tugasAkhirs'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('tugasAkhir.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'modul_id' => 'required|exists:modules,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deskripsi_pdf' => 'nullable|file|mimes:pdf',
            'deadline' => 'required|date',
            'kriteria_penilaian' => 'required|json'
        ]);

        // dd($validatedData);

        if ($request->hasFile('deskripsi_pdf')) {
            $path = $request->file('deskripsi_pdf')->store('public/deskripsi_pdf');
            $validatedData['deskripsi_pdf'] = $path;
        }

        TugasAkhir::create($validatedData);

        return redirect()->route('tugasAkhir.index')->with('success', 'Tugas Akhir berhasil dibuat.');
    }

    public function edit(TugasAkhir $tugasAkhir)
    {
        $modules = Module::all();
        return view('tugasAkhir.edit', compact('tugasAkhir', 'modules'));
    }

    public function update(Request $request, TugasAkhir $tugasAkhir)
    {
        $data = $request->validate([
            'modul_id' => 'required|exists:modules,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deskripsi_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'deadline' => 'required|date',
            'kriteria_penilaian' => 'required|json',
        ]);

        if ($request->hasFile('deskripsi_pdf')) {
            if ($tugasAkhir->deskripsi_pdf) {
                Storage::delete('public/' . $tugasAkhir->deskripsi_pdf);
            }
            $pdfPath = $request->file('deskripsi_pdf')->store('tugas_akhir', 'public');
            $data['deskripsi_pdf'] = $pdfPath;
        }

        $tugasAkhir->update($data);

        return redirect()->route('tugasAkhir.index')->with('success', 'Tugas Akhir updated successfully');
    }


    public function destroy(TugasAkhir $tugasAkhir)
    {
        Storage::delete($tugasAkhir->deskripsi_pdf);
        $tugasAkhir->delete();
        return redirect()->route('tugasAkhir.index')->with('success', 'Tugas Akhir berhasil dihapus.');
    }
}
