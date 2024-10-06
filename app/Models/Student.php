<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Specify the fillable attributes
    protected $fillable = [
        'user_id', 'full_name', 'student_number', 'group_id', 'series_id',  // Use _id for foreign keys
        'year', 'semester', 'faculty_id', 'speciality_id', 'date_of_birth',
        'birth_place', 'address', 'city', 'phone'
    ];


    // A student belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A student belongs to a group
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    // A student belongs to a series
    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }
}
