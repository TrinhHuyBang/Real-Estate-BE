<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request){
        try {
            $username = $request->input('username');
            $password = $request->input('passwordd');
    
            $user = User::where('phone', $username)->orWhere('email', $username)->first();
    
            if ($user) {
                if (Auth::attempt(['id' => $user->id, 'password' => $password])) {
                    Log::info("Đăng nhập thành công");
                    return response()->json(['message' => 'Đăng nhập thành công'], 200);
                } else {
                    Log::info("Sai mật khẩu");
                    return response()->json(['message' => 'Sai mật khẩu'], 401);
                }
            } else {
                Log::info("Người dùng không tồn tại");
                return response()->json(['message' => 'Người dùng không tồn tại'], 401);
            }
        } catch (Exception $e) {
            Log::error('Lỗi đăng nhập: ' . $e->getMessage());
            return response()->json(['message' => 'Đã xảy ra lỗi trong quá trình đăng nhập'], 500);
        }
    }

    public function logout(){
        Auth::logout();
        return response()->json(['message' => 'Đăng xuất thành công'], 200);
    }
}
