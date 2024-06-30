<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repos\BrokerRepo;
use App\Repos\EnterpriseRepo;
use App\Repos\PostRepo;
use App\Repos\ProjectRepo;
use App\Repos\ReviewRepo;
use App\Repos\UserRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    use HandleJsonResponse;
    protected UserRepo $userRepo;
    protected PostRepo $postRepo;
    protected ProjectRepo $projectRepo;
    protected ReviewRepo $reviewRepo;
    protected BrokerRepo $brokerRepo;
    protected EnterpriseRepo $enterpriseRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        UserRepo $userRepo,
        PostRepo $postRepo,
        ProjectRepo $projectRepo,
        ReviewRepo $reviewRepo,
        BrokerRepo $brokerRepo,
        EnterpriseRepo $enterpriseRepo
    )
    {
        $this->userRepo = $userRepo;
        $this->postRepo = $postRepo;
        $this->projectRepo = $projectRepo;
        $this->reviewRepo = $reviewRepo;
        $this->brokerRepo = $brokerRepo;
        $this->enterpriseRepo = $enterpriseRepo;
    }

    /**
     * Thống kê số lượng từng loại dữ liệu cần quản lý
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function overview()
    {
        try {
            $broker = [
                'name' => 'broker_accounts',
                'label' => 'Nhà môi giới',
            ];
            $enterprise = [
                'name' => 'enterprise_accounts',
                'label' => 'Doanh nghiệp',
            ];
            $rating = [
                'name' => 'rating',
                'label' => 'Đánh giá',
            ];
            $user = [
                'name' => 'user_accounts',
                'label' => 'Người dùng',
            ];
            $post = [
                'name' => 'posts',
                'label' => 'Tin đăng',
            ];
            $project = [
                'name' => 'projects',
                'label' => 'Dự án',
            ];
            $broker['count'] = $this->brokerRepo->countBroker();
            $broker['request'] = $this->brokerRepo->countRequest();

            $enterprise['count'] = $this->enterpriseRepo->countEnterprise();
            $enterprise['request'] = $this->enterpriseRepo->countRequest();

            $user['count'] = $this->userRepo->countUser();
            $user['active'] = $this->userRepo->countActive();

            $post['count'] = $this->postRepo->countPost();
            $post['request'] = $this->postRepo->countRequest();

            $project['count'] = $this->projectRepo->countProject();
            $project['request'] = $this->projectRepo->countRequest();

            $rating['count'] = $this->reviewRepo->countReview();
            $rating['avg_rating'] = $this->reviewRepo->getAvgRating();

            $data = [$post, $project, $user, $enterprise, $broker, $rating];
            return $this->handleSuccessJsonResponse($data);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Thống kê số lượng từng loại dữ liệu cần quản lý
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function listReview() {
        try {
            $reviews = $this->reviewRepo->list();
            return $this->handleSuccessJsonResponse($reviews);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleErrorJsonResponse($e);
        }
        
    }

}
