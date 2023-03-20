<?php

namespace Delgont\Auth\Models;


use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{

   /**
     * Find a permission by its name (and optionally guardName).
     *
     * @param string $name
     * @param string|null $guardName
     */
    public static function scopeFindByName($query, string $name, $guardName = null)
    {
        return $query->whereName($name);
    }


    /**
     * Find a permission by its id (and optionally guardName).
     *
     * @param int $id
     * @param string|null $guardName
     *
     */
    public static function scopeFindById($query, int $id, $guardName = null)
    {
        return $query->whereId($id);
    }


}
