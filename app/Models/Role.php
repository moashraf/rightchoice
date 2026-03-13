<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Permission;

/**
 * RBAC Role Model
 *
 * Represents a named role (e.g. admin, user, viewer).
 * Roles hold collections of permissions via the role_permissions pivot.
 *
 * @property int    $id
 * @property string $name
 * @property string $label
 * @property string $description
 */
class Role extends Model
{
    protected $fillable = ['name', 'label', 'description'];

    // ─────────────────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────────────────

    /**
     * The permissions that belong to this role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions',
            'role_id',
            'permission_id'
        );
    }

    /**
     * The users that have this role.
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }

    // ─────────────────────────────────────────────────────────
    // Helper Methods
    // ─────────────────────────────────────────────────────────

    /**
     * Grant a permission to this role.
     */
    public function grantPermission(string $permissionName): void
    {
        $permission = Permission::where('name', $permissionName)->firstOrFail();
        $this->permissions()->syncWithoutDetaching($permission->id);
    }

    /**
     * Revoke a permission from this role.
     */
    public function revokePermission(string $permissionName): void
    {
        $permission = Permission::where('name', $permissionName)->first();
        if ($permission) {
            $this->permissions()->detach($permission->id);
        }
    }

    /**
     * Check whether this role has a given permission.
     */
    public function hasPermission(string $permissionName): bool
    {
        return $this->permissions->contains('name', $permissionName);
    }
}
