<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanIndikator extends Model
{
    protected $fillable = [
        'indikator_id', 'periode_id', 'jawaban', 'nilai', 'persen', 'catatan', 'bukti', 'link'
    ];
    public function indikator()
{
    return $this->belongsTo(\App\Models\Indikator::class, 'indikator_id');
}

}
