<?php


namespace JetBox\Permission\Traits;

use JetBox\Permission\Models\Role;


trait HasRoles
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->morphToMany(
            config('permissions.models.role_model'),
            config('permissions.columns.morphs'),
            config('permissions.tables.model_has_roles'),
            config('permissions.columns.morph_key'),
            config('permissions.columns.role_id')
        )->withTimestamps();
    }

    /**
     * @param $role
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::whereName($role)->firstOrFail();
        }

        $this->roles()->sync($role, false);
    }

    /**
     * @param $role
     */
    public function detachRole($role)
    {
        if (is_string($role)) {
            $role = Role::whereName($role)->firstOrFail();
        }

        $this->roles()->detach($role);
    }

    /**
     * @return mixed
     */
    public function abilities()
    {
        return $this->roles->map->permissions->flatten()->pluck('name')->unique();
    }

    /**
     * @return mixed
     */
    public function getRoleNames()
    {
        return $this->roles->pluck('name')->unique(); // $this->roles->map->name->unique();
    }

    /**
     * @param $roles
     * @return mixed
     */
    public function hasRole($roles): bool
    {
        if (is_string($roles)) {
            $roles = Role::whereName($roles)->firstOrFail();
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }

            return false;
        }

        return $this->roles->contains($roles);
    }

    /**
     * @param $roles
     * @return bool
     */
    public function hasAnyRole($roles): bool
    {
        return $this->hasRole($roles);
    }

    /**
     * @param $ability
     * @return bool
     */
    public function hasPermission($ability): bool
    {
        return $this->abilities()->contains($ability);
    }
}
