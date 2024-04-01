<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;

class RolePermissionController extends Controller
{
    public function getRolePermissions(Role $role)
    {

        $permissions = $role->permissions;
        return response()->json($permissions);
    }
    public function assignPermissions(Request $request, Role $role)
    {
        $permissionIds = $request->input('permission_ids');

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $permissions = Permission::whereIn('id', $permissionIds)->get();


        $role->syncPermissions($permissions);
        return response()->json(['message' => 'Permissions assigned successfully'], 200);
    }
}