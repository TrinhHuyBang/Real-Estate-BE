<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repos\NewsRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    use HandleJsonResponse;
    protected NewsRepo $newsRepo;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(NewsRepo $newsRepo)
    {
        $this->newsRepo = $newsRepo;
    }

    /**
     * Lấy danh sách top 5  tin tức với điều kiện lọc của người dùng
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listHeadline(Request $request)
    {
        try {
            $type = $request->get('type');
            $news = $this->newsRepo->listHeadline($type);
            return $this->handleSuccessJsonResponse($news);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy danh sách tất cả tin tức
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        try {
            $type = $request->get('type');
            $news = $this->newsRepo->list($type);
            return $this->handleSuccessJsonResponse($news);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy thông tin chi tiết tin tức
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        try {
            $news = $this->newsRepo->get($id);
            $this->newsRepo->edit($id, ['number_views' => $news->number_views + 1]);
            return $this->handleSuccessJsonResponse($news);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
