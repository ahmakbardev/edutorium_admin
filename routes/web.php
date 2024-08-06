<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LivecodeAssessmentController;
use App\Http\Controllers\LivecodeTutorialController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ModulImageUploadController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TugasAkhirAssessmentController;
use App\Http\Controllers\TugasAkhirController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/modul', function () {
    return view('modul.index');
})->name('modul');

Route::post('/upload-image', [ModulImageUploadController::class, 'upload'])->name('upload.image');

Route::resource('materi', MateriController::class)->names([
    'index' => 'materi.index',
    'create' => 'materi.create',
    'store' => 'materi.store',
    'edit' => 'materi.edit',
    'update' => 'materi.update',
    'destroy' => 'materi.destroy',
]);

Route::post('upload-image-materi', [MateriController::class, 'upload'])->name('materi.upload');
// Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('upload-image');

Route::resource('livecode_tutorials', LivecodeTutorialController::class)->names([
    'index' => 'livecode_tutorials.index',
    'create' => 'livecode_tutorials.create',
    'store' => 'livecode_tutorials.store',
    'edit' => 'livecode_tutorials.edit',
    'update' => 'livecode_tutorials.update',
    'destroy' => 'livecode_tutorials.destroy',
]);
Route::post('upload-image-livecode', [MateriController::class, 'uploadTutorial'])->name('livecode_tutorials.upload');

Route::resource('quizzes', QuizController::class)->names([
    'index' => 'quizzes.index',
    'create' => 'quizzes.create',
    'store' => 'quizzes.store',
    'edit' => 'quizzes.edit',
    'update' => 'quizzes.update',
    'destroy' => 'quizzes.destroy',
]);

Route::resource('tugas-akhir', TugasAkhirController::class)->names([
    'index' => 'tugasAkhir.index',
    'create' => 'tugasAkhir.create',
    'store' => 'tugasAkhir.store',
    'edit' => 'tugasAkhir.edit',
    'update' => 'tugasAkhir.update',
    'destroy' => 'tugasAkhir.destroy',
]);

Route::post('upload-image-tugas-akhir', [MateriController::class, 'uploadTugasAkhir'])->name('tugasAkhir.upload');

Route::get('/livecode_assessments', [LivecodeAssessmentController::class, 'index'])->name('livecode_assessments.index');
Route::get('livecode_assessments/create/{livecode_id}', [LivecodeAssessmentController::class, 'create'])->name('livecode_assessments.create');
Route::post('livecode_assessments/store', [LivecodeAssessmentController::class, 'store'])->name('livecode_assessments.store');
Route::get('livecode_assessments/{assessment}/edit', [LivecodeAssessmentController::class, 'edit'])->name('livecode_assessments.edit');
Route::put('livecode_assessments/{assessment}', [LivecodeAssessmentController::class, 'update'])->name('livecode_assessments.update');
Route::delete('livecode_assessments/{assessment}', [LivecodeAssessmentController::class, 'destroy'])->name('livecode_assessments.destroy');

Route::get('/tugas-akhir-assessments', [TugasAkhirAssessmentController::class, 'index'])->name('tugas_akhir_assessments.index');
Route::get('/tugas-akhir-assessments/create/{tugas_akhir_id}/{user_id}', [TugasAkhirAssessmentController::class, 'create'])->name('tugas_akhir_assessments.create');
Route::post('/tugas-akhir-assessments', [TugasAkhirAssessmentController::class, 'store'])->name('tugas_akhir_assessments.store');
Route::get('/tugas-akhir-assessments/edit/{id}', [TugasAkhirAssessmentController::class, 'edit'])->name('tugas_akhir_assessments.edit');
Route::put('/tugas-akhir-assessments/{id}', [TugasAkhirAssessmentController::class, 'update'])->name('tugas_akhir_assessments.update');
Route::delete('/tugas-akhir-assessments/{id}', [TugasAkhirAssessmentController::class, 'destroy'])->name('tugas_akhir_assessments.destroy');

Route::resource('banners', BannerController::class);
