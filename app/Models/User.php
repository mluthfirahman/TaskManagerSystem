<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'id_role', // Make sure this matches your database field
    ];

    // Relasi dengan Role model (jika ada)
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

        public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

}
