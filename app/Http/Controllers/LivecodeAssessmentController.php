<?php

namespace App\Http\Controllers;

use App\Models\LivecodeAssessment;
use App\Models\LivecodeTutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LivecodeAssessmentController extends Controller
{
    public function index()
    {
        $progress = DB::table('progress')
            ->join('users', 'progress.user_id', '=', 'users.id')
            ->join('modules', 'progress.module_id', '=', 'modules.id')
            ->select('progress.*', 'users.name as user_name', 'modules.name as module_name')
            ->whereNotNull('progress.livecode')
            ->get()
            ->groupBy('module_id');

        $assessments = LivecodeAssessment::all();

        foreach ($assessments as $assessment) {
            $kriteriaPenilaian = json_decode($assessment->kriteria_penilaian, true);
            if (is_array($kriteriaPenilaian)) {
                $totalScore = array_sum(array_column($kriteriaPenilaian, 'nilai'));
                $averageScore = $totalScore / count($kriteriaPenilaian);
                $assessment->average_score = $averageScore;
            } else {
                $assessment->average_score = null;
            }
        }

        return view('livecode_assessments.index', compact('progress', 'assessments'));
    }


    public function create($livecode_id)
    {
        $progress = DB::table('progress')
            ->where('id', $livecode_id)
            ->first();

        $user = DB::table('users')->where('id', $progress->user_id)->first();
        $livecodeTutorials = LivecodeTutorial::where('module_id', $progress->module_id)->get();

        // Retrieve the `kriteria` from the corresponding livecode tutorial
        $livecodeTutorial = LivecodeTutorial::where('module_id', $progress->module_id)->first();
        $kriteria = $livecodeTutorial ? json_decode($livecodeTutorial->kriteria, true) : [];

        $livecode = json_decode($progress->livecode, true);

        return view('livecode_assessments.create', compact('livecodeTutorials', 'progress', 'user', 'livecode', 'kriteria'));
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

        // Validate the incoming request data
        $validatedData = $request->validate([
            'livecode_tutorial_id' => 'required|exists:livecode_tutorials,id',
            'user_id' => 'required|exists:users,id',
            'kriteria_penilaian' => 'required|array', // Validate as an array
        ]);

        // Encode the kriteria_penilaian to JSON without backslashes
        $jsonKriteriaPenilaian = json_encode($kriteria_penilaian, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        // Assign the properly encoded JSON string back to the validated data
        $validatedData['kriteria_penilaian'] = $jsonKriteriaPenilaian;

        // Create a new livecode assessment with the validated data
        LivecodeAssessment::create($validatedData);

        // Redirect back to the assessments index with a success message
        return redirect()->route('livecode_assessments.index')->with('success', 'Penilaian livecode berhasil dibuat.');
    }


    public function edit($id)
    {
        $assessment = LivecodeAssessment::findOrFail($id);
        $progress = DB::table('progress')
            ->where('user_id', $assessment->user_id)
            ->where('module_id', $assessment->livecode_tutorial_id)
            ->first();

        $user = DB::table('users')->where('id', $assessment->user_id)->first();
        $livecodeTutorials = LivecodeTutorial::where('module_id', $progress->module_id)->get();

        // Retrieve the `kriteria` from the corresponding livecode tutorial
        $livecodeTutorial = LivecodeTutorial::where('module_id', $progress->module_id)->first();
        $kriteria = $livecodeTutorial ? json_decode($livecodeTutorial->kriteria, true) : [];

        $livecode = json_decode($progress->livecode, true);

        return view('livecode_assessments.edit', compact('assessment', 'livecodeTutorials', 'progress', 'user', 'livecode', 'kriteria'));
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

        // Validate the incoming request data
        $validatedData = $request->validate([
            'livecode_tutorial_id' => 'required|exists:livecode_tutorials,id',
            'user_id' => 'required|exists:users,id',
            'kriteria_penilaian' => 'required|array', // Validate as an array
        ]);

        // Encode the kriteria_penilaian to JSON without backslashes
        $jsonKriteriaPenilaian = json_encode($kriteria_penilaian, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        // Find the existing assessment and update it
        $assessment = LivecodeAssessment::findOrFail($id);
        $assessment->livecode_tutorial_id = $request->livecode_tutorial_id;
        $assessment->user_id = $request->user_id;
        $assessment->kriteria_penilaian = $jsonKriteriaPenilaian;
        $assessment->save();

        // Redirect back to the assessments index with a success message
        return redirect()->route('livecode_assessments.index')->with('success', 'Penilaian livecode berhasil diperbarui.');
    }


    public function destroy(LivecodeAssessment $assessment)
    {
        $assessment->delete();

        return redirect()->route('livecode_assessments.index')->with('success', 'Penilaian livecode berhasil dihapus.');
    }
}
