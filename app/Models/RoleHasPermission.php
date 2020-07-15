<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    public $table = 'roles_has_permissions';

    public $incrementing = false;

    public $timestamps = false;

    protected $primaryKey = null;

    protected $fillable = [
        'role_id', 'permission_id'
    ];

    public function permission()
    {
        return $this->belongsTo(\App\Models\Permission::class, 'permission_id');
    }

}
