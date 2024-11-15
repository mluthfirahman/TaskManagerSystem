<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Define the table name (optional if the table name matches the plural of the model)
    protected $table = 'task'; // Use 'tasks' if the table is plural

    // The attributes that are mass assignable
    protected $fillable = [
        'title',
        'description',
        'status',
        'assigned_to',
    ];

    // The attributes that should be hidden for arrays
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // Define relationship with the User model (assuming you are assigning tasks to users)
    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Scopes can be added to simplify queries
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
