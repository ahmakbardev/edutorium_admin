<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivecodeTutorial extends Model
{
    use HasFactory;


    protected $fillable = [
        'module_id',
        'name',
        'description',
        'tutorial',
        'kriteria',
        'deadline'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
