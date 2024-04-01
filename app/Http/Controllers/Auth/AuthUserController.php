<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthUserController extends Controller
{
    public function index()
    {

        $users = User::with('roles')->get();
        return response()->json($users, 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('myApp')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'success' => 'true',
            'data' => $success,
            'message' => 'User register Success'

        ];
        return response()->json($response, 200);
    }
    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json($user, 200);
        } else {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }
    public function update(Request $request, User $user)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'email',
            'role_id' => 'nullable'
        ]);

        if ($request->has('password') && $request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        }
        $role = Role::find($request->role_id);
        $user->update($validatedData);
        $user->syncRoles([$role->name]);
        return response()->json($user, 200);
    }



    public function delete(User $user)
    {
        if ($user) {
            $user->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['message' => 'user not found'], 404);
        }
    }
}