<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    // Table name if not following Laravel convention
    protected $table = 'role_permission';

    // Disable timestamps if your table does not have `created_at` and `updated_at`
    public $timestamps = false;

    // Fillable attributes to protect against mass assignment vulnerability
    protected $fillable = ['role_id', 'permission_id'];

    /**
     * Define the relationship with the Role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Define the relationship with the Permission model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
