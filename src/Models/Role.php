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
        if (is_string($permissions)) {
            $permissions = Permission::whereName($permissions)->firstOrFail();
        }

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
            $permission = Permission::whereName($permission)->firstOrFail();
        }

        return $this->getPermissionNames()->contains($permission->name);
    }
}
