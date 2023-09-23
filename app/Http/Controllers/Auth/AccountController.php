<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repos\UserRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    use HandleJsonResponse;
    protected UserRepo $userRepo;

    public function __construct (UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function updateProfile($id, Request $request)
    {
        $avatar = $request->get('avatar');
        $name = $request->get('name');
        $tax = $request->get('tax_code');
        try {
            $info = $this->userRepo->edit($id, ['avatar' => $avatar, 'name' => $name, 'tax_code' => $tax]);
            return $this->handleSuccessJsonResponse($info, 'success');
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
        
        return $info;
    }

    public function updatePassword($id, Request $request)
    {
        $password = $request->get('password');
        $new_password = $request->get('new_password');
        Log::info($password);
        try {
            if (Auth::attempt(['id' => $id, 'password' => $password])) {
                $password = $this->userRepo->edit($id, ['password' => bcrypt($new_password)]);
                return $this->handleSuccessJsonResponse($password, 'success');
            } else {
                throw new Exception('Password is not true');
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function deleteAccount($id, Request $request)
    {
        $password = $request->get('password');
        try {
            if (Auth::attempt(['id' => $id, 'password' => $password])) {
                $password = $this->userRepo->edit($id, ['status' => 0]);
                return $this->handleSuccessJsonResponse($password, 'success');
            } else {
                throw new Exception('Mật khẩu không đúng');
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
