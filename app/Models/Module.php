<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'image', 'status'];

    public function livecodeTutorials()
    {
        return $this->hasMany(LivecodeTutorial::class);
    }
}
