<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdminType;
use App\Http\Controllers\Controller;
use App\Repos\PermissionRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminPermissionController extends Controller
{
    use HandleJsonResponse;

    protected PermissionRepo $permissionRepo;

    public function __construct(PermissionRepo $permissionRepo)
    {
        $this->permissionRepo = $permissionRepo;
    }

    // Lấy ra danh tất cả các quyền
    public function getList(Request $request)
    {
        try {
            if(auth('admin')->user()->role === AdminType::ADMIN) {
                $permissions = $this->permissionRepo->list();
                return $this->handleSuccessJsonResponse($permissions);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
