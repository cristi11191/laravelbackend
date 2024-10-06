<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = ['group_name', 'year'];
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
