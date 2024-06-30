<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = [
        'modul_id',
        'urutan_materi',
        'nama_materi',
        'materi',
        'file_gambar'
    ];

    public function modul()
    {
        return $this->belongsTo(Module::class);
    }
}
