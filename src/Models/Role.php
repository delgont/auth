<?php

namespace Delgont\Auth\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


use Delgont\Auth\Concerns\ModelHasPermissions;

use Delgont\Auth\Models\Permission;
use Delgont\Auth\Models\RoleGroup;

use Delgont\Auth\Contracts\Role as RoleContract;

class Role extends Model implements RoleContract
{
  use ModelHasPermissions;


  public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }
  

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group() : BelongsTo
    {
        return $this->belongsTo(RoleGroup::class, 'role_group_id');
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
