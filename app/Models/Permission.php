<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * RBAC Permission Model
 *
 * Stores granular action permissions using dot notation.
 * Examples: users.create, aqars.delete, reports.view
 *
 * @property int    $id
 * @property string $name    dot-notation key, e.g. "users.create"
 * @property string $label   human-readable, e.g. "Create Users"
 * @property string $module  grouping key, e.g. "users"
 */
class Permission extends Model
{
    protected $fillable = ['name', 'label', 'module'];

    // ─────────────────────────────────────────────────────────
    // Relationships
    // ─────────────────────────────────────────────────────────

    /**
     * The roles that own this permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'role_permissions',
            'permission_id',
            'role_id'
        );
    }
}
