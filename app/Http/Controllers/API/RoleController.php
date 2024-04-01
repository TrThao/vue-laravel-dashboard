<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $request->name]);

        return response()->json($role, 201);
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->name = $request->name;

        $role->save();

        return response()->json($role, 200);
    }

    // public function update(Request $request, $id)
    // {
    //     $role = Role::findOrFail($id);

    //     $request->validate([
    //         'name' => 'required|unique:roles,name,' . $role->id,
    //         'permissions' => 'array',
    //     ]);


    //     $role->name = $request->name;
    //     $role->save();
    //     if ($request->has('permissions')) {

    //         $permissionIds = $request->permissions;
    //         $permissions = Permission::whereIn('id', $permissionIds)->get();

    //         $role->syncPermissions($permissions);
    //     }

    //     return response()->json($role, 200);
    // }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(null, 204);
    }
}