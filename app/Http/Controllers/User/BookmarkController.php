<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repos\BookmarkRepo;
use App\Traits\HandleJsonResponse;
use App\Traits\OrderByKey;
use Exception;
use Illuminate\Http\Request;
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
        $userId = $request->get('user_id');
        $postId = $request->get('post_id');
        $bookmark = $this->bookmarkRepo->getByPostIdAndUserId($postId, $userId);
        try {
            if (!$bookmark) {
                $new_bookmark = $this->bookmarkRepo->create(['user_id' => $userId, 'post_id' => $postId]);
                return $this->handleSuccessJsonResponse($new_bookmark, 'success');
            } else {
                $this->bookmarkRepo->delete($bookmark->id);
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Show the pricing plan
     * GET /pricing
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listPost(Request $request)
    {
        $order = $request->get('order_by');
        $user_id = $request->get('user_id');
        try {
            $orderKey = $this->getOrderByKey($order);
            $orderBy = $orderKey['order_by'];
            $orderWith = $orderKey['order_with'];
            $bookmarks = $this->bookmarkRepo->listPostOrderBy($user_id,$orderBy,$orderWith);
            return $this->handleSuccessJsonResponse($bookmarks, 'thanh cong');
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
