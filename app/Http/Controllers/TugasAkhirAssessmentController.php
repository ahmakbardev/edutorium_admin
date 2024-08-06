<?php

namespace App\Http\Controllers;

use App\Models\TugasAkhir;
use App\Models\TugasAkhirAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TugasAkhirAssessmentController extends Controller
{
    public function index()
    {
        $progress = DB::table('tugas_akhir_submissions')
            ->join('users', 'tugas_akhir_submissions.user_id', '=', 'users.id')
            ->join('tugas_akhirs', 'tugas_akhir_submissions.tugas_akhir_id', '=', 'tugas_akhirs.id')
            ->select('tugas_akhir_submissions.*', 'users.name as user_name', 'tugas_akhirs.nama as tugas_akhir_name')
            ->get();

        $assessments = TugasAkhirAssessment::all();

        foreach ($assessments as $assessment) {
            $kriteriaPenilaian = json_decode($assessment->kriteria_penilaian, true);
            if ($kriteriaPenilaian) {
                $totalScore = array_sum(array_column($kriteriaPenilaian, 'nilai'));
                $averageScore = $totalScore / count($kriteriaPenilaian);
                $assessment->average_score = $averageScore;
            } else {
                $assessment->average_score = null;
            }
        }

        return view('tugas_akhir_assessments.index', compact('progress', 'assessments'));
    }

    public function create($tugas_akhir_id, $user_id)
    {
        $tugasAkhir = TugasAkhir::find($tugas_akhir_id);

        if (!$tugasAkhir) {
            return redirect()->route('tugas_akhir_assessments.index')->with('error', 'Tugas Akhir tidak ditemukan.');
        }

        $submission = DB::table('tugas_akhir_submissions')
            ->where('tugas_akhir_id', $tugas_akhir_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$submission) {
            return redirect()->route('tugas_akhir_assessments.index')->with('error', 'Tugas Akhir Submission tidak ditemukan.');
        }

        $user = DB::table('users')->where('id', $submission->user_id)->first();

        if (!$user) {
            return redirect()->route('tugas_akhir_assessments.index')->with('error', 'User tidak ditemukan.');
        }

        $kriteria = $tugasAkhir ? json_decode($tugasAkhir->kriteria_penilaian, true) : [];

        return view('tugas_akhir_assessments.create', compact('submission', 'user', 'tugasAkhir', 'kriteria'));
    }

    public function store(Request $request)
    {
        $kriteria_penilaian = [];
        foreach ($request->input('kriteria_penilaian') as $kriteria => $nilai) {
            $kriteria_penilaian[] = [
                'kriteria' => $kriteria,
                'nilai' => (int) $nilai
            ];
        }

        $validatedData = $request->validate([
            'tugas_akhir_id' => 'required|exists:tugas_akhirs,id',
            'user_id' => 'required|exists:users,id',
            'kriteria_penilaian' => 'required|array',
        ]);

        $jsonKriteriaPenilaian = json_encode($kriteria_penilaian, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $validatedData['kriteria_penilaian'] = $jsonKriteriaPenilaian;

        TugasAkhirAssessment::create($validatedData);

        return redirect()->route('tugas_akhir_assessments.index')->with('success', 'Penilaian tugas akhir berhasil dibuat.');
    }

    public function edit($id)
    {
        $assessment = TugasAkhirAssessment::findOrFail($id);
        $submission = DB::table('tugas_akhir_submissions')
            ->where('tugas_akhir_id', $assessment->tugas_akhir_id)
            ->where('user_id', $assessment->user_id)
            ->first();

        if (!$submission) {
            return redirect()->route('tugas_akhir_assessments.index')->with('error', 'Tugas Akhir Submission tidak ditemukan.');
        }

        $user = DB::table('users')->where('id', $assessment->user_id)->first();
        $tugasAkhir = TugasAkhir::find($assessment->tugas_akhir_id);
        $kriteria = $tugasAkhir ? json_decode($tugasAkhir->kriteria_penilaian, true) : [];

        return view('tugas_akhir_assessments.edit', compact('assessment', 'submission', 'user', 'tugasAkhir', 'kriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria_penilaian = [];
        foreach ($request->input('kriteria_penilaian') as $kriteria => $nilai) {
            $kriteria_penilaian[] = [
                'kriteria' => $kriteria,
                'nilai' => (int) $nilai
            ];
        }

        $validatedData = $request->validate([
            'tugas_akhir_id' => 'required|exists:tugas_akhirs,id',
            'user_id' => 'required|exists:users,id',
            'kriteria_penilaian' => 'required|array',
        ]);

        $jsonKriteriaPenilaian = json_encode($kriteria_penilaian, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $assessment = TugasAkhirAssessment::findOrFail($id);
        $assessment->tugas_akhir_id = $request->tugas_akhir_id;
        $assessment->user_id = $request->user_id;
        $assessment->kriteria_penilaian = $jsonKriteriaPenilaian;
        $assessment->save();

        return redirect()->route('tugas_akhir_assessments.index')->with('success', 'Penilaian tugas akhir berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $assessment = TugasAkhirAssessment::findOrFail($id);
        $assessment->delete();

        return redirect()->route('tugas_akhir_assessments.index')->with('success', 'Penilaian tugas akhir berhasil dihapus.');
    }
}
