<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Import model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function updatePassuser(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!$user = Auth::user()) {
            // Nếu không có người dùng đăng nhập, trả về lỗi
            return response()->json(['message' => 'Bạn chưa đăng nhập '], 401);
        }

        // Validate dữ liệu đầu vào
        $validatedData = $request->validate([
            'password' => 'required',
            'new_password' => 'required',
        ]);

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($validatedData['password'], $user->password)) {
            // Nếu mật khẩu cũ không khớp, trả về lỗi
            return response()->json(['message' => 'Incorrect old password'], 400);
        }

        // Cập nhật mật khẩu mới trên đối tượng $user
        $user->password = bcrypt($validatedData['new_password']);

        // Lưu thay đổi vào cơ sở dữ liệu
        $user->save();

        return response()->json(['message' => 'Password updated successfully'], 200);
    }
}