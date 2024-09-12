<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'permissions']; // Add permissions to the fillable array

    protected $casts = [
        'permissions' => 'array', // Cast permissions column to an array
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }


}
