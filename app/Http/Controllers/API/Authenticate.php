<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class Authenticate extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required| same:password'
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

        // $success['token'] = $user->createToken('myApp')->plainTextToken;
        $success['user'] = $user;
        // dd($success);

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User register Success'

        ];
        return response()->json($response, 200);
    }
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user  = Auth::user()->load('roles.permissions');
            $success['token'] = $user->createToken('myApp')->plainTextToken;
            $success['user'] = $user;
            // dd($success);
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'Đăng nhập thành công'

            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'Thông tin tài khoản hoặc mật khẩu không đúng'

            ];
            return response()->json($response);
        }
    }
}