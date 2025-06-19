<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'email', 'password', 'role', 'area_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function area()
{
    return $this->belongsTo(\App\Models\Area::class);
}
}   
