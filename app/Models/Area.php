<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function indikators()
    {
        return $this->hasMany(Indikator::class);
    }
    public function subAreas()
{
    return $this->hasMany(SubArea::class);
}
}
