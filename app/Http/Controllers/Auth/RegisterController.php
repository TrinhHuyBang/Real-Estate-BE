<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $user_phone = User::where([
                'phone' => $request->get('phone'),
            ])->first();

            $user_email = User::where([
                'email' => $request->get('email'),
            ])->first();

            if ($user_phone) {
                throw new Exception('Số điện thoại đã đăng ký');
            } elseif ($user_email) {
                throw new Exception('Email đã đăng ký');
            } else {
                $user = User::create([
                    'avatar' => $request->get('avatar'),
                    'name' => $request->get('username'),
                    'phone' => $request->get('phone'),
                    'email' => $request->get('email'),
                    'password' => bcrypt($request->get('password'))
                ]);
                return response()->json(['message' => 'Đăng ký tài khoản thành công'], 200);
            }
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
