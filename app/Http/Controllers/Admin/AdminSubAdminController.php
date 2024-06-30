<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdminType;
use App\Http\Controllers\Controller;
use App\Repos\AdminRepo;
use App\Repos\RoleRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminSubAdminController extends Controller
{
    use HandleJsonResponse;
    protected AdminRepo $adminRepo;
    protected RoleRepo $roleRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(AdminRepo $adminRepo, RoleRepo $roleRepo)
    {
        $this->adminRepo = $adminRepo;
        $this->roleRepo = $roleRepo;
    }

    /**
     * Lấy danh sách subadmin
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        try {
            if(auth('admin')->user()->role === AdminType::ADMIN) {
                $search = $request->get('search');
                $admins = $this->adminRepo->list($search);
                foreach ($admins as $admin) {
                    $roles = $this->roleRepo->getByAdminId($admin->id);
                    $admin->roles = $roles;
                }
                return $this->handleSuccessJsonResponse($admins);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Create a new account for sub admin
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createSubAdmin(Request $request)
    {
        try {
            if(auth('admin')->user()->role === AdminType::ADMIN) {
                $email = $this->adminRepo->findAccount($request->get('email'));
                if ($email) {
                    throw new Exception('Email đã có tài khoản');
                } else {
                    $admin = $this->adminRepo->create([
                        'name' => $request->get('name'),
                        'email' => $request->get('email'),
                        'password' => bcrypt($request->get('password'))
                    ]);
                    return $this->handleSuccessJsonResponse($admin);
                }
            } else {
                throw new Exception("Bạn không có quyền thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Khoá tài khoản của nhân sự
     * put /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function blockAccount($id)
    {
        try {
            if(auth('admin')->user()->role === AdminType::ADMIN) {
                $message = $this->adminRepo->blockAccount($id);
                return $this->handleSuccessJsonResponse($message);
            } else {
                throw new Exception("Bạn không có quyền thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Cập nhật quyền cho nhân sự
     * put /
     *
     * @param Int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateRole($id, Request $request)
    {
        try {
            if(auth('admin')->user()->role === AdminType::ADMIN) {
                $roles = $request->get('roles');
                $this->adminRepo->updateRole($id, $roles);
                return $this->handleSuccessJsonResponse();
            } else {
                throw new Exception("Bạn không có quyền thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
