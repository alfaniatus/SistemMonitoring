<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpsiJawaban extends Model
{
    use HasFactory;
    protected $fillable = ['indikator_id', 'opsi', 'teks', 'bobot'];

    public function indikator()
    {
        return $this->belongsTo(Indikator::class);
    }
}
