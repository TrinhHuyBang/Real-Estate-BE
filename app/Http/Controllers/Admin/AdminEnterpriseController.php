<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EnterpriseRequestStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repos\EnterpriseRepo;
use App\Repos\UserRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AdminEnterpriseController extends Controller
{
    use HandleJsonResponse;
    protected UserRepo $userRepo;
    protected EnterpriseRepo $enterpriseRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepo $userRepo, EnterpriseRepo $enterpriseRepo)
    {
        $this->userRepo = $userRepo;
        $this->enterpriseRepo = $enterpriseRepo;
    }

    /**
     * Lấy danh sách doanh nghiệp
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('view-any-user', User::class)) {
                $search = $request->get('search');
                $tab = $request->get('tab');
                $status = $tab == "listRequest" ? 0 : 1;
                $enterprises = $this->enterpriseRepo->listEnterpriseByAdmin($search, $status);
                return $this->handleSuccessJsonResponse($enterprises);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Khoá tài khoản của doanh nghiệp
     * put /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function blockAccount($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('update-user', User::class)) {
                $message = $this->enterpriseRepo->blockAccount($id);
                return $this->handleSuccessJsonResponse($message);
            } else {
                throw new Exception("Bạn không có quyền thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Từ chối yêu cầu thành doanh nghiệp
     * put /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function rejectRequest($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('update-user')) {
                $this->enterpriseRepo->edit($id, ['status' => EnterpriseRequestStatus::REJECTED]);
                return $this->handleSuccessJsonResponse();
            } else {
                throw new Exception("Bạn không có quyền để thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    
    /**
     * Chấp nhận yêu cầu đăng ký thành doanh nghiệp
     * put /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function acceptRequest($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('update-user')) {
                $enterprise = $this->enterpriseRepo->edit($id, ['status' => EnterpriseRequestStatus::ACCEPTED]);
                $this->userRepo->edit($enterprise->user_id, ['role' => UserRole::ENTERPRISE]);
                return $this->handleSuccessJsonResponse();
            } else {
                throw new Exception("Bạn không có quyền để thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
