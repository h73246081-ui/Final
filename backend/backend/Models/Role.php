<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    // Role ke multiple permissions ho sakte hain
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_has_permissions', // pivot table
            'role_id',
            'permission_id'
        );
    }

}
