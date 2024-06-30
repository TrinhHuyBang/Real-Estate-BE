<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Repos\NewsRepo;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AdminNewsController extends Controller
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
     * Lấy danh sách tin tức
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('view-any-news', News::class)) {
                $search = $request->get('search');
                $is_owner = $request->get('tab') == "listOwner" ? true : false;
                $news = $this->newsRepo->listByAdmin($search, $is_owner);
                return $this->handleSuccessJsonResponse($news);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
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
            if(Gate::forUser(auth('admin')->user())->allows('view-news', $news)) {
                $news = $this->newsRepo->get($id);
                return $this->handleSuccessJsonResponse($news);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Thêm tin tức mới
     * post /
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        try {
            if(Gate::forUser(auth('admin')->user())->allows('create-news', News::class)) {
                $admin = auth('admin')->user();
                $data = $request->all();
                $data['admin_id'] = $admin->id;
                $news = $this->newsRepo->create($data);
                return $this->handleSuccessJsonResponse($news);
            } else {
                throw new Exception("Bạn không có quyền truy cập vào trang này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Cập nhật thông tin tin tức
     * put /
     *
     * @param Int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        try {
            $news = $this->newsRepo->get($id);
            if(Gate::forUser(auth('admin')->user())->allows('create-news', $news)) {
                $admin = auth('admin')->user();
                $data = $request->all();
                $news = $this->newsRepo->edit($id, $data);
                return $this->handleSuccessJsonResponse($news);
            } else {
                throw new Exception("Bạn không có quyền thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Xoá tin tức
     * delete /
     *
     * @param Int $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        try {
            $news = $this->newsRepo->get($id);
            if(Gate::forUser(auth('admin')->user())->allows('delete-news', $news)) {
                $this->newsRepo->delete($id);
                return $this->handleSuccessJsonResponse();
            } else {
                throw new Exception("Bạn không có quyền thực hiện hành động này", 403);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
