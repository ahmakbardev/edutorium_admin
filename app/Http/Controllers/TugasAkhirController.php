<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasAkhirController extends Controller
{
    public function index()
    {
        $tugasAkhirs = TugasAkhir::all(); // Tidak lagi menggunakan with('modul')
        return view('tugasAkhir.index', compact('tugasAkhirs'));
    }

    public function create()
    {
        return view('tugasAkhir.create'); // Tidak lagi mengirimkan data modules
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deskripsi_pdf' => 'nullable|file|mimes:pdf',
            'deadline' => 'required|date',
            'kriteria_penilaian' => 'required|json'
        ]);

        if ($request->hasFile('deskripsi_pdf')) {
            $path = $request->file('deskripsi_pdf')->store('public/deskripsi_pdf');
            $validatedData['deskripsi_pdf'] = str_replace('public/', '', $path);
        }

        TugasAkhir::create($validatedData);

        return redirect()->route('tugasAkhir.index')->with('success', 'Tugas Akhir berhasil dibuat.');
    }

    public function edit(TugasAkhir $tugasAkhir)
    {
        return view('tugasAkhir.edit', compact('tugasAkhir'));
    }

    public function update(Request $request, TugasAkhir $tugasAkhir)
    {
        $data = $request->validate([
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
            $pdfPath = $request->file('deskripsi_pdf')->store('public/deskripsi_pdf');
            $data['deskripsi_pdf'] = str_replace('public/', '', $pdfPath);
        }

        $tugasAkhir->update($data);

        return redirect()->route('tugasAkhir.index')->with('success', 'Tugas Akhir berhasil diperbarui.');
    }

    public function destroy(TugasAkhir $tugasAkhir)
    {
        if ($tugasAkhir->deskripsi_pdf) {
            Storage::delete($tugasAkhir->deskripsi_pdf);
        }

        $tugasAkhir->delete();

        return redirect()->route('tugasAkhir.index')->with('success', 'Tugas Akhir berhasil dihapus.');
    }
}
