<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * AdminRolesPermissionsController
 *
 * Full RBAC management panel:
 *  - List all roles with their permissions
 *  - Edit permissions for any role (checkbox matrix)
 *  - Create / delete custom roles
 *  - Add / delete permissions
 */
class AdminRolesPermissionsController extends Controller
{
    // ─────────────────────────────────────────────────────────────────
    // Main matrix page: show all roles × all permissions
    // ─────────────────────────────────────────────────────────────────

    public function index()
    {
        $roles       = Role::with('permissions')->orderBy('name')->get();
        $permissions = Permission::orderBy('module')->orderBy('name')->get();

        // Group permissions by module for clean display
        $grouped = $permissions->groupBy('module');

        return view('admin_rbac.index', compact('roles', 'permissions', 'grouped'));
    }

    // ─────────────────────────────────────────────────────────────────
    // Save the full permission matrix for ALL roles at once (AJAX)
    // ─────────────────────────────────────────────────────────────────

    public function updateMatrix(Request $request)
    {
        $data = $request->validate([
            'matrix'   => 'nullable|array',
            'matrix.*' => 'nullable|array',
        ]);

        $matrix  = $request->input('matrix', []);   // [role_id => [permission_id, ...]]
        $roles   = Role::all();

        DB::transaction(function () use ($roles, $matrix) {
            foreach ($roles as $role) {
                $permIds = array_map('intval', $matrix[$role->id] ?? []);
                $role->permissions()->sync($permIds);
            }
        });

        return back()->with('success', '✅ تم حفظ الصلاحيات بنجاح.');
    }

    // ─────────────────────────────────────────────────────────────────
    // Roles CRUD
    // ─────────────────────────────────────────────────────────────────

    public function storeRole(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|regex:/^[a-z_]+$/|unique:roles,name',
            'label' => 'required|string|max:80',
            'description' => 'nullable|string|max:255',
        ], [
            'name.regex' => 'اسم الدور يجب أن يكون بالإنجليزية بحروف صغيرة وشُرَط سفلية فقط (مثال: super_admin)',
        ]);

        Role::create($request->only('name', 'label', 'description'));

        return back()->with('success', '✅ تم إضافة الدور بنجاح.');
    }

    public function destroyRole(Role $role)
    {
        // Prevent deleting the three core roles
        if (in_array($role->name, ['admin', 'user', 'viewer'])) {
            return back()->with('error', '❌ لا يمكن حذف الأدوار الأساسية (admin, user, viewer).');
        }

        $role->permissions()->detach();
        $role->delete();

        return back()->with('success', '✅ تم حذف الدور بنجاح.');
    }

    // ─────────────────────────────────────────────────────────────────
    // Permissions CRUD
    // ─────────────────────────────────────────────────────────────────

    public function storePermission(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|regex:/^[a-z_.]+$/|unique:permissions,name',
            'label'  => 'required|string|max:80',
            'module' => 'required|string|max:60',
        ], [
            'name.regex' => 'اسم الصلاحية يجب أن يكون بالإنجليزية بالصيغة module.action (مثال: reports.view)',
        ]);

        Permission::create($request->only('name', 'label', 'module'));

        return back()->with('success', '✅ تم إضافة الصلاحية بنجاح.');
    }

    public function destroyPermission(Permission $permission)
    {
        $permission->roles()->detach();
        $permission->delete();

        return back()->with('success', '✅ تم حذف الصلاحية بنجاح.');
    }
}
