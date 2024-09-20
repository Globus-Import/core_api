<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $role = Role::where('name', $request->role)->firstOrFail();
        $user->roles()->sync($role);

        return response()->json(['message' => 'Role assigned successfully']);
    }

    public function assignPermission(Request $request, User $user)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $permissions = Permission::whereIn('name', $request->permissions)->get();
        $user->permissions()->sync($permissions);

        return response()->json(['message' => 'Permissions assigned successfully']);
    }

    public function getUserRolesAndPermissions(User $user)
    {
        return response()->json([
            'roles' => $user->roles,
            'permissions' => $user->permissions,
        ]);
    }

    public function createRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        $role = Role::create($request->all());

        return response()->json($role, 201);
    }

    public function createPermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        $permission = Permission::create($request->all());

        return response()->json($permission, 201);
    }
}
