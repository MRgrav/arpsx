<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of users with their permissions.
     */
    public function index()
    {
        $users = User::with('permissions')->get();

        return Inertia::render('school-admin/Users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Show permission editing form for a specific user.
     */
    public function editPermissions(User $user)
    {
        $user->load('permissions');
        $allPermissions = Permission::all()->groupBy('group');

        return Inertia::render('school-admin/Users/EditPermissions', [
            'user' => $user,
            'userPermissions' => $user->permissions->pluck('id')->toArray(),
            'permissionsByGroup' => $allPermissions,
        ]);
    }

    /**
     * Update permissions for a specific user.
     */
    public function updatePermissions(Request $request, User $user)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $user->permissions()->sync($request->input('permissions', []));

        return redirect()->route('school-admin.users.index')
            ->with('success', 'User permissions updated successfully.');
    }
}
