<?php

namespace App\Http\Controllers;

use App\Models\LivecodeTutorial;
use App\Models\Module;
use Illuminate\Http\Request;

class LivecodeTutorialController extends Controller
{
    public function index()
    {
        $livecodeTutorials = LivecodeTutorial::with('module')->get();
        return view('livecode_tutorials.index', compact('livecodeTutorials'));
    }

    public function create()
    {
        $modules = Module::all();
        return view('livecode_tutorials.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tutorial' => 'required|string',
            'deadline' => 'required|date',
            'kriteria' => 'nullable|string', // Change validation rule to string
        ]);

        // dd($request->all());

        LivecodeTutorial::create([
            'module_id' => $request->module_id,
            'name' => $request->name,
            'description' => $request->description,
            'tutorial' => $request->tutorial,
            'deadline' => $request->deadline,
            'kriteria' => $request->kriteria, // Directly save JSON string
        ]);

        return redirect()->route('livecode_tutorials.index')->with('success', 'Livecode Tutorial berhasil dibuat.');
    }

    public function edit($id)
    {
        $livecodeTutorial = LivecodeTutorial::findOrFail($id);
        $modules = Module::all();
        return view('livecode_tutorials.edit', compact('livecodeTutorial', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'tutorial' => 'required|string',
            'deadline' => 'required|date',
            'kriteria' => 'nullable|string', // Change validation rule to string
        ]);

        $livecodeTutorial = LivecodeTutorial::findOrFail($id);
        $livecodeTutorial->update([
            'module_id' => $request->module_id,
            'name' => $request->name,
            'description' => $request->description,
            'tutorial' => $request->tutorial,
            'deadline' => $request->deadline,
            'kriteria' => $request->kriteria, // Directly save JSON string
        ]);

        return redirect()->route('livecode_tutorials.index')->with('success', 'Livecode Tutorial updated successfully.');
    }

    public function destroy($id)
    {
        $livecodeTutorial = LivecodeTutorial::findOrFail($id);
        $livecodeTutorial->delete();

        return redirect()->route('livecode_tutorials.index')->with('success', 'Livecode Tutorial deleted successfully.');
    }
}
