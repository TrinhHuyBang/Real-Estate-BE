<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Repos\PostRepo;
use App\Traits\HandleJsonResponse;
use App\Traits\OrderByKey;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PostController extends Controller
{
    use HandleJsonResponse;
    use OrderByKey;
    protected PostRepo $postRepo;

    public function __construct(PostRepo $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    // Lấy ra danh sách tất cả các bài đăng đang chờ duyệt
    public function getListRequest(Request $request)
    {
        $order = $request->get('order_by');
        $type = $request->get('type');
        try {
            $orderKey = $this->getOrderByKey($order);
            $orderBy = $orderKey['order_by'];
            $orderWith = $orderKey['order_with'];
            if($type == 'sell') {
                $postType = config('postType.sell');
            } else {
                $postType = config('postType.rent');
            }
            $bookmarks = $this->postRepo->listRequest($postType, $orderBy, $orderWith);
            $bookmarks = PostResource::collection($bookmarks)->values()->all();
            $perPage = 5;
            $currentPage = request('page', 1);
            $pagedResults = array_slice($bookmarks, ($currentPage - 1) * $perPage, $perPage);
            $bookmarks = new LengthAwarePaginator($pagedResults, count($bookmarks), $perPage, $currentPage);
            return $this->handleSuccessJsonResponse($bookmarks);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    //Từ chối yêu cầu
    public function rejectRequest($id)
    {
        try {
            $this->postRepo->edit($id, ['status' => config('status.reject')]);
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    //Chấp nhận yêu cầu đăng bài
    public function acceptRequest($id)
    {
        try {
            $day_display = 14;
            $published_at = Carbon::now();
            $expired_at = Carbon::now()->addDays($day_display);
            $this->postRepo->edit($id, ['status' => config('status.displayPost'), 'published_at' => $published_at, 'expired_at' => $expired_at]);
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
