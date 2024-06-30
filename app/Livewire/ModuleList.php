<?php

namespace App\Livewire;

use App\Models\Module;
use Livewire\Component;

class ModuleList extends Component
{
    public $modules;

    protected $listeners = [
        'modulCreated' => 'refreshModules',
        'statusUpdated' => 'refreshModules',
        'moduleDeleted' => 'refreshModules',
        'moduleUpdated' => 'refreshModules'
    ];

    public function mount()
    {
        $this->refreshModules();
    }

    public function refreshModules()
    {
        $this->modules = Module::all();
    }

    public function refreshModulesWithDelay()
    {
        // This method is called by the JavaScript after 3 seconds delay
        $this->refreshModules();
    }

    public function deleteModule($moduleId)
    {
        $module = Module::find($moduleId);
        if ($module) {
            $module->delete();
            session()->flash('message', 'Modul berhasil dihapus.');
            $this->dispatch('moduleDeleted');
        }
    }

    public function updateModule($moduleId, $name, $description, $status)
    {
        $module = Module::find($moduleId);

        if ($module) {
            $module->update([
                'name' => $name,
                'description' => $description,
                // 'status' => $status,
            ]);
            session()->flash('message', 'Modul berhasil diupdate.');

            $this->dispatch('moduleUpdated');
        }
    }

    public function render()
    {
        return view('livewire.module-list');
    }
}
