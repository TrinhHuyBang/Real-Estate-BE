<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdminType;
use App\Http\Controllers\Controller;
use App\Repos\RoleRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminRoleController extends Controller
{
    use HandleJsonResponse;

    protected RoleRepo $roleRepo;

    public function __construct(RoleRepo $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    // Lấy ra danh tất cả các quyền
    public function getList(Request $request)
    {
        try {
            if(auth('admin')->user()->role === AdminType::ADMIN) {
                $search = $request->get('search');
                $roles = $this->roleRepo->list($search);
                return $this->handleSuccessJsonResponse($roles);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    // Lấy ra danh tất cả các quyền
    public function listOption()
    {
        try {
            $roles = $this->roleRepo->getInstance();
            return $this->handleSuccessJsonResponse($roles);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Xoá quyền
     * delete /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            if(auth('admin')->user()->role === AdminType::ADMIN) {
                $this->roleRepo->delete($id);
                return $this->handleSuccessJsonResponse();
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Thêm quyền mới
     * post /
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        try {
            if(auth('admin')->user() && auth('admin')->user()->role === AdminType::ADMIN) {
                $role_name = $request->get('name');
                $checkExist = $this->roleRepo->get($role_name);
                if($checkExist) {
                    throw new Exception("Tên quyền đã tồn tại, hãy đổi lại tên quyền!");
                }
                $permissions = $request->get('permissions');
                $this->roleRepo->createRole(['name'  => $role_name], $permissions);
                return $this->handleSuccessJsonResponse();
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Cập nhật quyền
     * put /
     *
     * @param Int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        try {
            if(auth('admin')->user() && auth('admin')->user()->role === AdminType::ADMIN) {
                $role_name = $request->get('name');
                $checkExist = $this->roleRepo->get($role_name);
                if($checkExist && $checkExist->id != $id) {
                    throw new Exception("Tên quyền đã tồn tại, hãy đổi lại tên quyền!");
                }
                $permissions = $request->get('permissions');
                $this->roleRepo->updateRole($id, ['name'  => $role_name], $permissions);
                return $this->handleSuccessJsonResponse();
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
