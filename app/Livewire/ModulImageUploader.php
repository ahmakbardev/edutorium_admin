<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class ModulImageUploader extends Component
{
    use WithFileUploads;

    public $imagePath;
    public $image;

    protected $rules = [
        'image' => 'nullable|image|max:1024',
    ];

    public function updatedImage()
    {
        $this->validate([
            'image' => 'nullable|image|max:1024', // 1MB Max
        ]);

        if ($this->image) {
            $imagePath = $this->image->store('modul_images', 'public');
            session(['imagePath' => $imagePath]);
            $this->image = null; // Reset image input
        }
    }

    public function render()
    {
        return view('livewire.modul-image-uploader');
    }
}
