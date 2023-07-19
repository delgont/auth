<?php

namespace Delgont\Auth\Models;

use Illuminate\Database\Eloquent\Model;

use Delgont\Auth\Models\Role;

class RoleGroup extends Model
{
    protected $fillable = ['name'];

    /**
     * A permission may belong to specific group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roles()
    {
        return $this->hasMany(Role::class, 'role_group_id');
    }

}
