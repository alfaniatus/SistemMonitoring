<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Indikator extends Model
{
   use HasFactory;

    protected $fillable = ['name', 'area_id'];

    // Relasi ke Area
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
