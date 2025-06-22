<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubArea extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'area_id'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
