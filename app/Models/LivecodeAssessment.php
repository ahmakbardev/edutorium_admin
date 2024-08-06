<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivecodeAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'livecode_tutorial_id',
        'user_id',
        'kriteria_penilaian',
    ];

    protected $casts = [
        'kriteria_penilaian' => 'array',
    ];

    public function livecodeTutorial()
    {
        return $this->belongsTo(LivecodeTutorial::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
