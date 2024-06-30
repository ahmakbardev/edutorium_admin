<?php

namespace App\Livewire;

use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateModule extends Component
{
    public $name;
    public $description;
    public $imagePath;
    public $status = 'draft';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|in:draft,publish',
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'description.required' => 'Deskripsi wajib diisi.',
        'status.required' => 'Status wajib diisi.',
        'status.in' => 'Status harus berupa draft atau publish.',
    ];

    public function mount()
    {
        $this->imagePath = session('imagePath', null);
    }

    public function save()
    {
        $this->validate();
        $this->imagePath = session('imagePath'); // Retrieve the image path from the session

        Module::create([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->imagePath,
            'status' => $this->status,
            'user_id' => Auth::id(),
        ]);

        session()->flash('message', 'Modul berhasil dibuat.');
        $this->reset(['name', 'description', 'imagePath', 'status']);

        // Forget the session data for image path
        session()->forget('imagePath');

        // Emit event to close modal
        $this->dispatch('modulCreated');
    }

    public function render()
    {
        return view('livewire.create-module');
    }
}
