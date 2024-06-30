<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Repos\PostImageRepo;
use Illuminate\Http\Request;
use App\Repos\PostRepo;
use App\Repos\PostViewHistoryRepo;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Traits\HandleJsonResponse;
use App\Traits\OrderByKey;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use HandleJsonResponse;
    use OrderByKey;

    protected PostRepo $postRepo;
    protected PostImageRepo $postImageRepo;
    protected PostViewHistoryRepo $postViewHistoryRepo;

    public function __construct(PostRepo $postRepo, PostImageRepo $postImageRepo, PostViewHistoryRepo $postViewHistoryRepo)
    {
        $this->postRepo = $postRepo;
        $this->postImageRepo = $postImageRepo;
        $this->postViewHistoryRepo = $postViewHistoryRepo;
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
            $post = $this->postRepo->get($id);
            if (!$post) {
                throw new Exception('Bài đăng không tồn tại');
            }
            return $this->handleSuccessJsonResponse($post);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Thêm một bài đăng mới
     * POST /
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $user_id = Auth::id();
        $post = $request->except('images');
        $post['user_id'] = $user_id;
        $postImages = $request->get('images');
        try {
            $newPost = $this->postRepo->create($post);
            if (!$newPost) {
                throw new Exception('Thêm bài đăng không thành công');
            }
            foreach ($postImages as $postImage) {
                $image = $this->postImageRepo->create(['url' => $postImage, 'post_id' => $newPost->id]);
                if (!$image) {
                    throw new Exception('Thêm ảnh không thành công');
                }
            }
            return $this->handleSuccessJsonResponse($newPost, 'Thêm thành công');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Cập nhật thông tin cho bài đăng
     * PUT /
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        try {
            $user_id = Auth::id();
            if(!$this->postRepo->checkAuth($id)) {
                throw new Exception('Bạn không phải chủ của bài đăng này');
            }
            $post = $request->except('images');
            $post['user_id'] = $user_id;
            $postImages = $request->get('images');
        
            $newPost = $this->postRepo->edit($id, $post);
            if (!$newPost) {
                throw new Exception('Thêm bài đăng không thành công');
            }
            $this->postImageRepo->delete($id);
            foreach ($postImages as $postImage) {
                $image = $this->postImageRepo->create(['url' => $postImage, 'post_id' => $id]);
                if (!$image) {
                    throw new Exception('Thêm ảnh không thành công');
                }
            }
            return $this->handleSuccessJsonResponse($newPost, 'Thêm thành công');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Xoá một bài đăng
     * PUT /
     *
     * @param int $id
     * @return JsonResponse
     */

    public function delete($id)
    {
        try {
            $this->postRepo->delete($id);
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Đưa ra danh sách top 4 thành phố có số lượng bài đăng lớn nhất và tổng số bài đăng từng thành phố
     * GET /
     *
     * @return JsonResponse
     */
    public function locationRealEstate() {
        try {
            $data = $this->postRepo->numberPostByLocation();
            return $this->handleSuccessJsonResponse($data);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function getList(Request $request) {
        try {
            $order = $request->get('order_by');
            $orderKey = $this->getOrderByKey($order);
            $type_id = $request->get('type_id');
            $endPrice = $request->get('endPrice');
            $startPrice = $request->get('startPrice');
            $endSize = $request->get('endSize');
            $startSize = $request->get('startSize');
            $province = $request->get('province');
            $district = $request->get('district');
            $ward = $request->get('ward');
            $type = $request->get('type');
            $project_id = $request->get('project_id');
            $priceSelected = $request->get('priceSelected');
            $data = [
                'endPrice' => $endPrice ? $endPrice : 9999999999,
                'startPrice' => $startPrice ? $startPrice : 0,
                'endSize' => $endSize ? $endSize : 9999999999,
                'startSize' => $startSize ? $startSize : 0,
                'province' => $province ? $province : "-",
                'district' => $district ? $district : "-",
                'ward' => $ward ? $ward : "-",
                'type_id' => $type_id,
                'order_by' => $orderKey['order_by'],
                'order_with' => $orderKey['order_with'],
                'type' => $type,
                'priceSelected' => $priceSelected,
                'project_id' => $project_id
            ];
            $posts = $this->postRepo->listPost($data);
            $posts = PostResource::collection($posts)->values()->all();
            $perPage = 5;
            $currentPage = request('page', 1);
            $pagedResults = array_slice($posts, ($currentPage - 1) * $perPage, $perPage);
            $posts = new LengthAwarePaginator($pagedResults, count($posts), $perPage, $currentPage);
            return $this->handleSuccessJsonResponse($posts);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function suggestedPostByHistory(Request $request)
    {
        try {
            if(Auth::check()) {
                $user_id = auth()->user()->id;
            } else {
                $user_id = $request->get('guest_id');
            }
            $history = $this->postViewHistoryRepo->topLatestHistory($user_id);

            $topDistricts = $this->postViewHistoryRepo->topDistricts($user_id);
            $topDistrictName = [];
            foreach ($topDistricts as $topDistrict) {
                array_push($topDistrictName, $topDistrict['district']); // Lấy top tên các district
            }

            $topPostTypes = $this->postViewHistoryRepo->topPostType($user_id);
            $topPostTypeId = [];
            foreach ($topPostTypes as $topPostType) {
                array_push($topPostTypeId, $topPostType['type_id']); // Lấy top các type_id
            }
            $topPrices = $this->postViewHistoryRepo->topPrice($user_id, $topPostTypeId);
            // return $topPrices;
            $topSizes = $this->postViewHistoryRepo->topSize($user_id, $topPostTypeId);
            $topWards = $this->postViewHistoryRepo->topWards($user_id);

            $suggestedPosts = $this->postRepo->suggested($topDistrictName, $topPostTypeId, $history);
            if(!count($suggestedPosts)) {
                $posts = $this->postRepo->getListAll();
                $posts = PostResource::collection($posts)->values()->all();
                $perPage = 4;
                $currentPage = request('page', 1);
                $pagedResults = array_slice($posts, ($currentPage - 1) * $perPage, $perPage);
                $posts = new LengthAwarePaginator($pagedResults, count($posts), $perPage, $currentPage);
                return $this->handleSuccessJsonResponse($posts);
            }
            foreach ($suggestedPosts as $suggestPost) {
                $point = 0;

                $orderOfMagnitude_price = floor(log10($suggestPost->price));
                $range_price = $orderOfMagnitude_price >= 1 ? 10 ** ($orderOfMagnitude_price) : 1;
                $post_price_level = floor(($suggestPost->price/$range_price) + 10*$orderOfMagnitude_price);
                
                $orderOfMagnitude_size = floor(log10($suggestPost->size));
                $range = $orderOfMagnitude_size >= 1 ? 10 ** ($orderOfMagnitude_size) : 1;
                $post_size_level = floor(($suggestPost->size/$range) + 10*$orderOfMagnitude_size);
                
                foreach($topWards as $ward) {
                    if($suggestPost->ward == $ward['ward']) {
                        $point += $ward['percent'];
                        break;
                    }
                }

                foreach($topPrices as $type_id => $topPrice) {
                    if($suggestPost->type_id == $type_id){
                        foreach ($topPrice as $price) {
                            if($post_price_level == $price['price_level']) {
                                $point += $price['percentage']; 
                                break;
                            }
                        }
                        break;
                    }
                }

                foreach($topSizes as $type_id => $topSize) {
                    if($suggestPost->type_id == $type_id){
                        foreach ($topSize as $size) {
                            if($post_size_level == $size['size_level']) {
                                $point += $size['percentage']; 
                                break;
                            }
                        }
                        break;
                    }
                }
                $suggestPost['point_avg'] = $point/3;
            }
            $suggestedPosts = PostResource::collection($suggestedPosts)->sortByDesc('point_avg')->values()->all();
            $perPage = 4;
            $currentPage = request('page', 1);
            $pagedResults = array_slice($suggestedPosts, ($currentPage - 1) * $perPage, $perPage);
            $suggestedPosts = new LengthAwarePaginator($pagedResults, count($suggestedPosts), $perPage, $currentPage);
            return $this->handleSuccessJsonResponse($suggestedPosts);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy danh sách bài đăng của chính người dùng đang đăng nhập
     * get /
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function listOwnerPost(Request $request) {
        try {
            $search = $request->get('search');
            $type = $request->get('type');
            $postType = config("postType.$type");
            $status = $request->get('status');
            $status = config("status.$status");
            $posts = $this->postRepo->listByStatus($status, $postType, $search);
            $posts = PostResource::collection($posts)->values()->all();
            $perPage = 5; 
            $currentPage = request('page', 1);
            $pagedResults = array_slice($posts, ($currentPage - 1) * $perPage, $perPage);
            $posts = new LengthAwarePaginator($pagedResults, count($posts), $perPage, $currentPage);
            return $this->handleSuccessJsonResponse($posts);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy danh sách bài đăng của người dùng khác
     * get /
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function listUserPost(Request $request) {
        try {
            $user_id = $request->get('user_id');
            $type = $request->get('type');
            $postType = config("postType.$type");
            $posts = $this->postRepo->listByUser($user_id, $postType);
            $posts = PostResource::collection($posts)->values()->all();
            $perPage = 10; 
            $currentPage = request('page', 1);
            $pagedResults = array_slice($posts, ($currentPage - 1) * $perPage, $perPage);
            $posts = new LengthAwarePaginator($pagedResults, count($posts), $perPage, $currentPage);
            return $this->handleSuccessJsonResponse($posts);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
