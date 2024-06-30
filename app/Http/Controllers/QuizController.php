<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    //
    public function index()
    {
        $quizzes = Quiz::with('module')->get();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('quizzes.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'questions' => 'required|json',
        ]);

        Quiz::create([
            'module_id' => $request->module_id,
            'questions' => $request->questions,
        ]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully.');
    }

    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        $modules = Module::all();
        return view('quizzes.edit', compact('quiz', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'questions' => 'required|json',
        ]);

        $quiz = Quiz::findOrFail($id);
        $quiz->update([
            'module_id' => $request->module_id,
            'questions' => $request->questions,
        ]);

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
}
