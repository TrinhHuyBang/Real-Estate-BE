<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Repos\PostImageRepo;
use App\Repos\PostRepo;
use App\Repos\PostViewHistoryRepo;
use App\Traits\HandleJsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostViewHistoryController extends Controller
{
    use HandleJsonResponse;
    protected PostViewHistoryRepo $postViewHistoryRepo;
    protected PostRepo $postRepo;
    protected PostImageRepo $postImageRepo;

    public function __construct(PostViewHistoryRepo $postViewHistoryRepo, PostRepo $postRepo, PostImageRepo $postImageRepo)
    {
        $this->postViewHistoryRepo = $postViewHistoryRepo;
        $this->postRepo = $postRepo;
        $this->postImageRepo = $postImageRepo;
    }

    /**
     * Thêm lịch sử xem mới
     * POST /
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createHistory(Request $request)
    {
        try {
            $post_id = $request->get('post_id');
            if(Auth::check()){
                $user_id = auth()->user()->id;
                $post = $this->postRepo->get($post_id);
                if($user_id === $post->user_id) {
                    return $this->handleSuccessJsonResponse('Bạn là chủ của bài đăng');
                }
                $history = $this->postViewHistoryRepo->getByUserIdAndPostId($user_id, $post_id);
                if($history) {
                    $history = $this->postViewHistoryRepo->edit($history->id, ['viewed_at' => Carbon::now()]);
                    return $this->handleSuccessJsonResponse($history);
                } else {
                    $new_history = $this->postViewHistoryRepo->create(['user_id'=>$user_id,'post_id'=>$post_id, 'viewed_at' => Carbon::now()]);
                }
            } else {
                $guest_id = $request->get('guest_id');
                $history = $this->postViewHistoryRepo->getByGuestIdAndPostId($guest_id, $post_id);
                if($history) {
                    $history = $this->postViewHistoryRepo->edit($history->id, ['viewed_at' => Carbon::now()]);
                    return $this->handleSuccessJsonResponse($history);
                } else {
                    $new_history = $this->postViewHistoryRepo->create(['guest_id'=>$guest_id,'post_id'=>$post_id, 'viewed_at' => Carbon::now()]);
                }
            }
            return $this->handleSuccessJsonResponse($new_history);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
        
        $post_id = $request->get('post_id');

    }

    /**
     * Lấy danh sách lịch sử xem của người dùng
     * get /
     *
     * @return JsonResponse
     */
    public function listPostViewHistory(Request $request)
    {
        try {
            if(Auth::check()) {
                $user_id = auth()->user()->id;   
            } else {
                $user_id = $request->get('guest_id');
            }
            $latestHistory = $this->postViewHistoryRepo->latestHistory($user_id);
            $latestHistoryId = $latestHistory ? $latestHistory->post_id : null;
            $postViewHistories = $this->postViewHistoryRepo->listPostByUserId($user_id, $latestHistoryId);
            $postViewHistories = PostResource::collection($postViewHistories)->values()->all();
            $perPage = 4;
            $currentPage = request('page', 1);
            $pagedResults = array_slice($postViewHistories, ($currentPage - 1) * $perPage, $perPage);
            $postViewHistories = new LengthAwarePaginator($pagedResults, count($postViewHistories), $perPage, $currentPage);
            return $this->handleSuccessJsonResponse($postViewHistories);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
