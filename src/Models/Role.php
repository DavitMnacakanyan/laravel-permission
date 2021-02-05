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
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->morphedByMany(
            config('permissions.models.role_model'),
            config('permissions.columns.morphs'),
            config('permissions.tables.model_has_roles'),
            config('permissions.columns.morph_key'),
            config('permissions.columns.role_id')
        )->withTimestamps();
    }

    /**
     * @param $permission
     */
    public function syncPermissions($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->firstOrFail();
        }

        $this->permissions()->sync($permission, false);
    }

    /**
     * @param $permission
     */
    public function detachPermissions($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->firstOrFail();
        }

        $this->permissions()->detach($permission);
    }

    /**
     * @return mixed
     */
    public function getPermissionNames()
    {
        return $this->permissions->flatten()->pluck('name')->unique();
    }

    public function hasPermissions($permission): bool
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->firstOrFail();
        }

        return $this->getPermissionNames()->contains($permission->name);
    }
}
