<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhirAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tugas_akhir_id',
        'user_id',
        'kriteria_penilaian',
    ];

    protected $casts = [
        'kriteria_penilaian' => 'array',
    ];

    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
