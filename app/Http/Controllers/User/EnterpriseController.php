<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repos\EnterpriseRepo;
use App\Repos\ProjectRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EnterpriseController extends Controller
{
    use HandleJsonResponse;
    protected EnterpriseRepo $enterpriseRepo;
    protected ProjectRepo $projectRepo;

    public function __construct(EnterpriseRepo $enterpriseRepo, ProjectRepo $projectRepo)
    {
        $this->enterpriseRepo= $enterpriseRepo;
        $this->projectRepo = $projectRepo;
    }

    /**
     * Lấy danh sách các doanh nghiệp
     * get /
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function getList(Request $request) {
        try {
            $province = $request->get('province');
            $district = $request->get('district');
            $search = $request->get('search');
            $field = $request->get('field');
            $data = [
                'province' => $province ? $province : "",
                'district' => $district ? $district : "",
                'search' => $search,
                'field' => $field
            ];
            $enterprises = $this->enterpriseRepo->listEnterprise($data, ['enterprises.id', 'address', 'name', 'abbreviation', 'logo', 'phone_number', 'address']);
            return $this->handleSuccessJsonResponse($enterprises);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy thông tin chi tiết của doanh nghiệp
     * get /
     *
     * @param Request $request
     * @return JsonResponse
     */

     public function getDetail($id) {
        try {
            $enterprise = $this->enterpriseRepo->get($id);
            $enterprise->projects = $this->projectRepo->listProjectByEnterprise($id);
            return $this->handleSuccessJsonResponse($enterprise);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
