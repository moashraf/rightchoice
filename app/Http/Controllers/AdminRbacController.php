<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

/**
 * AdminRbacController (Example / Reference Controller)
 *
 * Shows best-practice patterns for enforcing RBAC permissions
 * inside admin controllers using constructor middleware.
 *
 * Copy the relevant middleware() calls into your own controllers.
 *
 * ─────────────────────────────────────────────────────────────
 * PATTERN A: Constructor middleware (recommended for resource controllers)
 * ─────────────────────────────────────────────────────────────
 *
 * class AdminUserController extends Controller
 * {
 *     public function __construct()
 *     {
 *         // All methods require viewing permission
 *         $this->middleware('permission:users.view');
 *
 *         // Write operations require higher permissions
 *         $this->middleware('permission:users.create')->only(['create', 'store']);
 *         $this->middleware('permission:users.update')->only(['edit', 'update']);
 *         $this->middleware('permission:users.delete')->only(['destroy', 'forceDeleteUser', 'restoreUser']);
 *         $this->middleware('permission:users.block')->only(['block', 'activate']);
 *         $this->middleware('permission:users.export')->only(['exportUsers']);
 *     }
 * }
 *
 * ─────────────────────────────────────────────────────────────
 * PATTERN B: Role check in method body (for complex logic)
 * ─────────────────────────────────────────────────────────────
 *
 * public function destroy(User $user)
 * {
 *     $authUser = Auth::guard('admin')->user();
 *
 *     if (!$authUser->hasPermission('users.delete')) {
 *         abort(403, 'You do not have permission to delete users.');
 *     }
 *
 *     $user->delete();
 *     return redirect()->route('sitemanagement.users.index')->with('success', 'Deleted.');
 * }
 *
 * ─────────────────────────────────────────────────────────────
 * PATTERN C: In Blade views (UI enforcement — hides buttons)
 * ─────────────────────────────────────────────────────────────
 *
 * @haspermission('users.create')
 *     <a href="{{ route('sitemanagement.users.create') }}" class="btn btn-primary">Add New</a>
 * @endhaspermission
 *
 * @haspermission('users.delete')
 *     <a href="{{ route('sitemanagement.users.delete', $user->id) }}" class="btn btn-danger">Delete</a>
 * @endhaspermission
 *
 * @role('admin')
 *     <p>Only visible to admins</p>
 * @endrole
 *
 * @vieweronly
 *     <div class="alert alert-warning">You have read-only access.</div>
 * @endvieweronly
 *
 * ─────────────────────────────────────────────────────────────
 * PATTERN D: Programmatic check in any class
 * ─────────────────────────────────────────────────────────────
 *
 * $user = Auth::guard('admin')->user();
 *
 * if ($user->hasRole('admin')) { ... }
 * if ($user->hasRole(\App\Enums\RoleEnum::ADMIN)) { ... }
 * if ($user->hasPermission('reports.view')) { ... }
 * if ($user->canViewOnly()) { /* viewer role — read-only * / }
 * if ($user->isAdminRole()) { /* new RBAC admin check * / }
 *
 * ─────────────────────────────────────────────────────────────
 * PATTERN E: Route middleware (already applied in routes/web.php)
 * ─────────────────────────────────────────────────────────────
 *
 * Route::post('/users')->middleware('permission:users.create');
 * Route::delete('/users/{id}')->middleware('permission:users.delete');
 * Route::get('/admin/...')->middleware('role:admin');
 * Route::get('/admin/...')->middleware('role:admin,viewer');  // OR — any of these
 */
class AdminRbacController extends Controller
{
    // This class is a reference/documentation controller only.
    // It is not registered in routes.
}
