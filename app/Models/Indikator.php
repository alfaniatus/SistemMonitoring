<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Indikator extends Model
{
    use HasFactory;

    protected $fillable = ['pertanyaan', 'area_id', 'sub_area_id', 'nama_indikator', 'tipe_jawaban', 'bobot', 'is_published'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    public function subArea()
    {
        return $this->belongsTo(SubArea::class);
    }
    public function opsiJawaban()
{
    return $this->hasMany(OpsiJawaban::class);
}
}
