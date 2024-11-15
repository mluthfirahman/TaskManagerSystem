<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
    ];

    // relasi 1:M dengan tabel users
    public function users()
    {
        return $this->hasMany(User::class, 'id_role');
    }
}
