<?php

namespace JetBox\Permission\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(
            config('permissions.models.permission')
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->morphedByMany(
            config('permissions.models.role'),
            config('permissions.columns.morphs'),
            config('permissions.tables.model_has_roles'),
            config('permissions.columns.morph_key'),
            config('permissions.columns.role_id')
        )->withTimestamps();
    }

    /**
     * @param $permissions
     */
    public function syncPermissions($permissions)
    {
        $permissions = collect($permissions)->flatten()->map(function ($permission) {
            // 1 | [1, 2, 3] | "1"
            if (is_numeric($permission)) {
                $permission = intval($permission);
                $ids[] = Permission::whereId($permission)->first()->id;
            }

            // 'view_article' | ['view_article', 'edit_article]
            if (is_string($permission)) {
                $ids[] = Permission::whereName($permission)->first()->id;
            }

            // instanceof Permission Model
            if (is_object($permission)) {
                if ($permission instanceof Permission) {
                    $ids[] = Permission::whereName($permission->name)->first()->id;
                }
            }

            return $ids;
        })->flatten();

        $this->permissions()->sync($permissions);
    }

    /**
     * @return mixed
     */
    public function getPermissionNames()
    {
        return $this->permissions->flatten()->pluck('name')->unique();
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission): bool
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->first();
        }

        return $this->getPermissionNames()->contains($permission->name);
    }
}
