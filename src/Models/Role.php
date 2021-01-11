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
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * @param $permission
     */
    public function syncPermissions($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->findOrFail();
        }

        $this->permissions()->sync($permission, false);
    }

    /**
     * @param $permission
     */
    public function detachPermissions($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->findOrFail();
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
}
