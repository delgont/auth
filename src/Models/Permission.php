<?php

namespace Delgont\Auth\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Delgont\Auth\Models\Role;
use Delgont\Auth\Models\PermissionGroup;

use Delgont\Auth\Contracts\Permission as PermissionContract;


class Permission extends Model implements PermissionContract
{

    protected $guarded = [];
    

    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }


    /**
     * A permission may belong to specific group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group() : BelongsTo
    {
        return $this->belongsTo(PermissionGroup::class, 'permission_group_id');
    }

    /**
     * Get permissions of specific group.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfGroup($query, $group)
    {
        return $query->whereHas('group', function($groupQuery) use ($group){
            $groupQuery->whereName($group);
        });
    }

}
