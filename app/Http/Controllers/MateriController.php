<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MateriController extends Controller
{
    //
    public function index()
    {
        $materis = Materi::with('modul')->orderBy('urutan_materi')->get()->groupBy('modul_id');
        return view('materi.index', compact('materis'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('materi.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'modul_id' => 'required|exists:modules,id',
            'urutan_materi' => 'required|integer',
            'nama_materi' => 'required|string|max:255',
            'materi' => 'required|string',
            'file_gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $materi = new Materi();
        $materi->modul_id = $request->modul_id;
        $materi->urutan_materi = $request->urutan_materi;
        $materi->nama_materi = $request->nama_materi;
        $materi->materi = $request->materi;

        if ($request->hasFile('file_gambar')) {
            $file = $request->file('file_gambar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/materi', $filename);
            $materi->file_gambar = $filename;
        }

        $materi->save();

        return redirect()->route('materi.index')->with('success', 'Materi baru telah berhasil dibuat.');
    }


    public function edit(Materi $materi)
    {
        $modules = Module::all();
        return view('materi.edit', compact('materi', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'modul_id' => 'required|exists:modules,id',
            'urutan_materi' => 'required|integer',
            'nama_materi' => 'required|string|max:255',
            'materi' => 'required|string',
            'file_gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $materi = Materi::findOrFail($id);
        $materi->modul_id = $request->modul_id;
        $materi->urutan_materi = $request->urutan_materi;
        $materi->nama_materi = $request->nama_materi;
        $materi->materi = $request->materi;

        if ($request->hasFile('file_gambar')) {
            // Hapus gambar lama jika ada
            if ($materi->file_gambar) {
                Storage::delete('public/materi/' . $materi->file_gambar);
            }
            // Upload file_gambar baru
            $file = $request->file('file_gambar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/materi', $filename);
            $materi->file_gambar = $filename;
        }

        $materi->save();
        // Menyimpan pesan ke dalam session
        session()->flash('success', 'Materi berhasil diperbarui.');
        return redirect()->route('materi.index')->with('success', 'Materi berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        // Hapus gambar jika ada
        if ($materi->gambar) {
            Storage::delete('public/materi/' . $materi->gambar);
        }

        $materi->delete();

        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus.');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $extension = $file->getClientOriginalExtension();
            $mime = $file->getMimeType();
            $allowedExtensions = ['png', 'jpeg', 'jpg'];
            $allowedMimes = ['image/png', 'image/jpeg'];

            if (in_array(strtolower($extension), $allowedExtensions) && in_array($mime, $allowedMimes)) {
                $filename = Str::uuid() . '.' . $extension;
                $path = $file->storeAs('public/materi', $filename);

                // URL to the image in the storage
                $url = Storage::url($path);

                return response()->json([
                    'uploaded' => true,
                    'url' => asset($url)
                ]);
            } else {
                return response()->json(['uploaded' => false, 'error' => ['message' => 'Invalid file type or mime type']], 400);
            }
        }

        return response()->json(['uploaded' => false, 'error' => ['message' => 'No file uploaded']], 400);
    }

    public function uploadTutorial(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $extension = $file->getClientOriginalExtension();
            $mime = $file->getMimeType();
            $allowedExtensions = ['png', 'jpeg', 'jpg'];
            $allowedMimes = ['image/png', 'image/jpeg'];

            if (in_array(strtolower($extension), $allowedExtensions) && in_array($mime, $allowedMimes)) {
                $filename = Str::uuid() . '.' . $extension;
                $path = $file->storeAs('public/livecode_tutorials', $filename);

                // URL to the image in the storage
                $url = Storage::url($path);

                return response()->json([
                    'uploaded' => true,
                    'url' => asset($url)
                ]);
            } else {
                return response()->json(['uploaded' => false, 'error' => ['message' => 'Invalid file type or mime type']], 400);
            }
        }

        return response()->json(['uploaded' => false, 'error' => ['message' => 'No file uploaded']], 400);
    }

    public function uploadTugasAkhir(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $extension = $file->getClientOriginalExtension();
            $mime = $file->getMimeType();
            $allowedExtensions = ['png', 'jpeg', 'jpg'];
            $allowedMimes = ['image/png', 'image/jpeg'];

            if (in_array(strtolower($extension), $allowedExtensions) && in_array($mime, $allowedMimes)) {
                $filename = Str::uuid() . '.' . $extension;
                $path = $file->storeAs('public/tugas_akhir', $filename);

                // URL to the image in the storage
                $url = Storage::url($path);

                return response()->json([
                    'uploaded' => true,
                    'url' => asset($url)
                ]);
            } else {
                return response()->json(['uploaded' => false, 'error' => ['message' => 'Invalid file type or mime type']], 400);
            }
        }

        return response()->json(['uploaded' => false, 'error' => ['message' => 'No file uploaded']], 400);
    }
}
