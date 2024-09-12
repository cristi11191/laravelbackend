<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function toArray()
    {
        // Call the parent toArray method
        $array = parent::toArray();

        // Add role and permissions to the array
        $role = $this->role; // Assuming role is already loaded

        // Initialize permissions array
        $permissionNames = [];

        // Check if role is loaded and has permissions
        if ($role) {
            // Get the permissions directly from the role
            $permissionNames = $role->permissions; // This should directly give the array of names
        }

        // Add role and permissions to the array
        $array['role'] = [
            'name' => $role ? $role->name : null,
            'permissions' => $permissionNames
        ];

        return $array;
    }







}
