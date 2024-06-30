<?php

namespace App\Livewire;

use App\Models\Module;
use Livewire\Component;

class ModuleUpdateStatus extends Component
{
    public $module;
    public $status;

    public function mount(Module $module)
    {
        $this->module = $module;
        $this->status = $module->status;
    }

    public function updateStatus($status)
    {
        $this->status = $status;
        $this->module->update(['status' => $status]);
        $this->dispatch('statusUpdated'); // Emit event to parent component
    }

    public function render()
    {
        return view('livewire.module-update-status');
    }
}
