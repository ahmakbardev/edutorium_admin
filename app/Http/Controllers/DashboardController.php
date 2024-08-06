<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->get();

        $progress = DB::table('progress')
            ->join('modules', 'progress.module_id', '=', 'modules.id')
            ->join('users', 'progress.user_id', '=', 'users.id')
            ->select('progress.*', 'modules.name as module_name', 'users.name as user_name', 'users.sekolah')
            ->orderBy('progress.updated_at', 'desc')
            ->get();

        $history = DB::table('progress')
            ->join('modules', 'progress.module_id', '=', 'modules.id')
            ->select('progress.*', 'modules.name as module_name')
            ->orderBy('progress.updated_at', 'desc')
            ->get();

        $latestProgress = DB::table('progress')
            ->join('modules', 'progress.module_id', '=', 'modules.id')
            ->select('progress.*', 'modules.name as module_name')
            ->orderBy('progress.updated_at', 'desc')
            ->first();

        $userLivecodes = DB::table('progress')
            ->join('modules', 'progress.module_id', '=', 'modules.id')
            ->whereNotNull('livecode')
            ->select('progress.*', 'modules.name as module_name')
            ->get();

        $allLivecodes = DB::table('progress')
            ->join('modules', 'progress.module_id', '=', 'modules.id')
            ->whereNotNull('livecode')
            ->select('progress.*', 'modules.name as module_name')
            ->get();

        $tugasAkhirAssessments = DB::table('tugas_akhir_assessments')
            ->join('tugas_akhirs', 'tugas_akhir_assessments.tugas_akhir_id', '=', 'tugas_akhirs.id')
            ->join('users', 'tugas_akhir_assessments.user_id', '=', 'users.id')
            ->select('tugas_akhir_assessments.*', 'tugas_akhirs.nama as tugas_akhir_name', 'users.name as user_name')
            ->get();

        $livecodeAssessments = DB::table('livecode_assessments')
            ->join('progress', 'livecode_assessments.livecode_tutorial_id', '=', 'progress.module_id')
            ->select('livecode_assessments.*', 'progress.module_id')
            ->get();

        $assessments = collect();
        foreach ($livecodeAssessments as $assessment) {
            $cleanedJsonString = str_replace('\\"', '"', trim($assessment->kriteria_penilaian, '"'));
            $kriteriaPenilaian = json_decode($cleanedJsonString, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($kriteriaPenilaian)) {
                $totalScore = array_sum(array_column($kriteriaPenilaian, 'nilai'));
                $averageScore = $totalScore / count($kriteriaPenilaian);
                $assessment->average_score = $averageScore;
            } else {
                $assessment->average_score = null;
            }

            $assessments->push($assessment);
        }

        foreach ($userLivecodes as $livecode) {
            $livecodeAssessment = $assessments->firstWhere('module_id', $livecode->module_id);
            $livecode->average_score = $livecodeAssessment->average_score ?? null;
        }

        $progressPercentage = 0;
        if ($latestProgress) {
            $totalMateri = DB::table('materis')
                ->where('modul_id', $latestProgress->module_id)
                ->count();

            $completedMateri = count(json_decode($latestProgress->materi, true));

            $progressPercentage = ($completedMateri / $totalMateri) * 100;

            if ($completedMateri == $totalMateri) {
                $progressPercentage = 100;
            }
        }

        return view('index', compact('users', 'progress', 'history', 'latestProgress', 'userLivecodes', 'allLivecodes', 'tugasAkhirAssessments', 'progressPercentage', 'assessments'));
    }
}
