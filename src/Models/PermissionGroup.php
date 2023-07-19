<?php

namespace Delgont\Auth\Models;

use Illuminate\Database\Eloquent\Model;

use Delgont\Auth\Models\Permission;

class PermissionGroup extends Model
{
    protected $fillable = ['name'];

    /**
     * A permission may belong to specific group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_group_id');
    }

}
