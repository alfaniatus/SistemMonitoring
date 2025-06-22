<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $fillable = ['nama', 'tahun'];

    public function indikators()
    {
        return $this->hasMany(Indikator::class);
    }
}

