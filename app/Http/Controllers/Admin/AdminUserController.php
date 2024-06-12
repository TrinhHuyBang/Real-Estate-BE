<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repos\UserRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminUserController extends Controller
{
    use HandleJsonResponse;
    protected UserRepo $userRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Lấy danh sách người dùng
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('view-any-user', User::class)) {
                $search = $request->get('search');
                $admins = $this->userRepo->list($search);
                return $this->handleSuccessJsonResponse($admins);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Khoá tài khoản của người dùng
     * put /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function blockAccount($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('update-user', User::class)) {
                $message = $this->userRepo->blockAccount($id);
                return $this->handleSuccessJsonResponse($message);
            } else {
                throw new Exception("Bạn không có quyền thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
