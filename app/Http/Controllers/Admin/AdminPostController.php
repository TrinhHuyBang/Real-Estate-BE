<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Repos\NotificationRepo;
use App\Repos\PostRepo;
use App\Traits\HandleJsonResponse;
use App\Traits\OrderByKey;
use App\Enums\NotificationType;
Use App\Enums\NotificationAction;
use App\Events\Notify\PostNotifyEvent;
use App\Jobs\SendNotification;
use App\Models\Admin;
use App\Models\Post;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AdminPostController extends Controller
{
    use HandleJsonResponse;
    use OrderByKey;
    protected PostRepo $postRepo;
    protected NotificationRepo $notificationRepo;

    public function __construct(PostRepo $postRepo, NotificationRepo $notificationRepo)
    {
        $this->postRepo = $postRepo;
        $this->notificationRepo = $notificationRepo;
    }

    // Lấy ra danh tất cả các bài đăng đang hiển thị
    public function getList(Request $request)
    {
        $order = $request->get('order_by');
        $type = $request->get('type');
        try {
            if(Gate::forUser(auth('admin')->user())->allows('view-any-post', Post::class)) {
                $orderKey = $this->getOrderByKey($order);
                $orderBy = $orderKey['order_by'];
                $orderWith = $orderKey['order_with'];
                $search = $request->get('search');
                if($type == 'sell') {
                    $postType = config('postType.sell');
                } else {
                    $postType = config('postType.rent');
                }
                $posts = $this->postRepo->listByAdminWithStatus($search, config('status.displayPost'),$postType, $orderBy, $orderWith);
                $posts = PostResource::collection($posts)->values()->all();
                $perPage = 10;
                $currentPage = request('page', 1);
                $pagedResults = array_slice($posts, ($currentPage - 1) * $perPage, $perPage);
                $posts = new LengthAwarePaginator($pagedResults, count($posts), $perPage, $currentPage);
                return $this->handleSuccessJsonResponse($posts);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy thông tin chi tiết một bài đăng
     * GET /
     *
     * @param int $id  ( id của bài đăng cần lấy thông tin )
     * @return JsonResponse
     */
    public function get($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('view-any-post', Post::class)) {
                $post = $this->postRepo->get($id);
                if (!$post) {
                    throw new Exception('Bài đăng không tồn tại');
                }
                return $this->handleSuccessJsonResponse($post);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Xoá một bài đăng
     * DELETE /
     *
     * @param int $id
     * @return JsonResponse
     */

     public function delete($id)
     {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('delete-post', Post::class)) {
                $post = $this->postRepo->delete($id);
                $post = $this->postRepo->getPost($id);
                SendNotification::dispatch($post->user_id, NotificationType::POST, $id, NotificationAction::DELETE)->onQueue('notification');
                return $this->handleSuccessJsonResponse($post);
            } else {
                throw new Exception("Bạn không có quyền để thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
     }

    // Lấy ra danh sách tất cả các bài đăng đang chờ duyệt
    public function getListRequest(Request $request)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('view-any-post', Post::class)) {
                $search = $request->get('search');
                $order = $request->get('order_by');
                $type = $request->get('type');
                $orderKey = $this->getOrderByKey($order);
                $orderBy = $orderKey['order_by'];
                $orderWith = $orderKey['order_with'];
                if($type == 'sell') {
                    $postType = config('postType.sell');
                } else {
                    $postType = config('postType.rent');
                }
                $posts = $this->postRepo->listByAdminWithStatus($search, config('status.hiddenPost'), $postType, $orderBy, $orderWith);
                $posts = PostResource::collection($posts)->values()->all();
                $perPage = 10;
                $currentPage = request('page', 1);
                $pagedResults = array_slice($posts, ($currentPage - 1) * $perPage, $perPage);
                $posts = new LengthAwarePaginator($pagedResults, count($posts), $perPage, $currentPage);
                return $this->handleSuccessJsonResponse($posts);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    //Từ chối yêu cầu
    public function rejectRequest($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('update-post', Post::class)) {
                $this->postRepo->edit($id, ['status' => config('status.reject')]);
                $post = $this->postRepo->getPost($id);
                SendNotification::dispatch($post->user_id, NotificationType::POST, $id, NotificationAction::REJECT)->onQueue('notification');
                return $this->handleSuccessJsonResponse();
            } else {
                throw new Exception("Bạn không có quyền để thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    //Chấp nhận yêu cầu đăng bài
    public function acceptRequest($id)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('update-post', Post::class)) {
                $day_display = 30;
                $published_at = Carbon::now();
                $expired_at = Carbon::now()->addDays($day_display);
                $this->postRepo->edit($id, ['status' => config('status.displayPost'), 'published_at' => $published_at, 'expired_at' => $expired_at]);
                $post = $this->postRepo->getPost($id);
                SendNotification::dispatch($post->user_id, NotificationType::POST, $id, NotificationAction::ACCEPT)->onQueue('notification');
                return $this->handleSuccessJsonResponse();
            } else {
                throw new Exception("Bạn không có quyền để thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            Log::error($e);
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
