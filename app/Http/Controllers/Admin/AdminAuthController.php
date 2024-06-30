<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repos\AdminRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    use HandleJsonResponse;
    protected AdminRepo $adminRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AdminRepo $adminRepo)
    {
        $this->adminRepo = $adminRepo;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $username = $request->get('username');
            $password = $request->get('password');
            
            $credentials = [
                'email' => $username,
                'password' => $password
            ];


            if (!$token = auth('admin')->attempt($credentials)) {
                throw new Exception('Sai tài khoản hoặc mật khẩu', 401);
            }

            if (!$this->adminRepo->checkStatus($username)) {
                throw new Exception('Tài khoản đang bị khoá', 401);
            }
            return $this->respondWithToken($token);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        try {
            $admin_id = auth('admin')->user()->id;
            if(!$admin_id) {
                throw new Exception('Chưa đăng nhập', 403);
            }
            $admin = $this->adminRepo->get($admin_id);
            return $this->handleSuccessJsonResponse($admin);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function updateProfile(Request $request)
    {
        $admin = auth('admin')->user();
        $avatar = $request->get('avatar');
        $name = $request->get('name');
        try {
            $info = $this->adminRepo->edit($admin->id, ['avatar' => $avatar, 'name' => $name]);
            return $this->handleSuccessJsonResponse($info);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function updatePassword(Request $request)
    {
        $password = $request->get('password');
        $new_password = $request->get('new_password');
        try {
            $id = auth('admin')->user()->id;
            $token = auth('admin')->attempt(['id' => $id, 'password' => $password]);
            if ($token) {
                $password = $this->adminRepo->edit($id, ['password' => bcrypt($new_password)]);
                return $this->handleSuccessJsonResponse($token);
            } else {
                throw new Exception('Không nhập đúng mật khẩu');
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Log the admin out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('admin')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 7200,
            'admin' => auth('admin')->user()
        ]);
    }

}
