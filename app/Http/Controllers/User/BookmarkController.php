<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Repos\BookmarkRepo;
use App\Traits\HandleJsonResponse;
use App\Traits\OrderByKey;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class BookmarkController extends Controller
{
    use HandleJsonResponse;
    use OrderByKey;
    protected BookmarkRepo $bookmarkRepo;

    public function __construct(BookmarkRepo $bookmarkRepo)
    {
        $this->bookmarkRepo = $bookmarkRepo;
    }
    public function createOrDelete(Request $request)
    {
        $userId = auth()->user()->id;
        $postId = $request->get('post_id');
        $bookmark = $this->bookmarkRepo->getByPostIdAndUserId($postId, $userId);
        try {
            if (!$bookmark) {
                $new_bookmark = $this->bookmarkRepo->create(['user_id' => $userId, 'post_id' => $postId]);
            } else {
                $this->bookmarkRepo->delete($bookmark->id);
            }
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Get list post bookmark 
     * GET /list-bookmark
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listPost(Request $request)
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
            $bookmarks = $this->bookmarkRepo->listPostOrderBy($postType, $orderBy, $orderWith);
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
}
