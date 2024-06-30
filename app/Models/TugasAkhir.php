<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    use HasFactory;

    protected $fillable = [
        'modul_id',
        'nama',
        'deskripsi',
        'deskripsi_pdf',
        'deadline',
        'kriteria_penilaian'
    ];

    protected $casts = [
        'kriteria_penilaian' => 'array'
    ];

    public function modul()
    {
        return $this->belongsTo(Module::class);
    }
}
