<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repos\ReviewRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{

    use HandleJsonResponse;
    protected ReviewRepo $reviewRepo;

    public function __construct(ReviewRepo $reviewRepo)
    {
        $this->reviewRepo = $reviewRepo;
    }


    /**
     * Lấy thông tin về số sao trung bình của hệ thống
     * GET /
     *
     * @return JsonResponse
     */
    public function getAvgRating()
    {
        try {
            $avgRating = $this->reviewRepo->getAvgRating();
            return $this->handleSuccessJsonResponse(['avgRating' => $avgRating, 1]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Thêm review mới hoặc cập nhật lại review của người dùng
     * POST /
     *
     * @param Request $request  
     * @return JsonResponse
     */
    public function createOrUpdate(Request $request)
    {
        try {
            $data = $request->all();
            $user_id = Auth::id();
            if(!$user_id) {
                throw new Exception('Bạn phải đăng nhập để thêm đánh giá');
            }
            $data['user_id'] = $user_id;
            $review = $this->reviewRepo->createOrUpdate($data);
            if(!$review) {
                throw new Exception('Thêm hoặc cập nhật đánh giá không thành công');
            }
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
