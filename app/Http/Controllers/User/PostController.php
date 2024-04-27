<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\PostType;
use App\Repos\PostImageRepo;
use Illuminate\Http\Request;
use App\Repos\PostRepo;
use App\Repos\PostViewHistoryRepo;
use App\Repos\ProjectRepo;
use App\Repos\UserRepo;
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
    protected ProjectRepo $projectRepo;
    protected UserRepo $userRepo;
    protected PostViewHistoryRepo $postViewHistoryRepo;

    public function __construct(PostRepo $postRepo, PostImageRepo $postImageRepo, ProjectRepo $projectRepo, UserRepo $userRepo, PostViewHistoryRepo $postViewHistoryRepo)
    {
        $this->postRepo = $postRepo;
        $this->postImageRepo = $postImageRepo;
        $this->projectRepo = $projectRepo;
        $this->userRepo = $userRepo;
        $this->postViewHistoryRepo = $postViewHistoryRepo;
    }

    public function getPostTypes()
    {
        try {
            $postType = array();
            $sells = PostType::select('type')->where('type', 'like', '%ban%')->get();
            $rents = PostType::select('type')->where('type', 'like', '%thue%')->get();
            $postType['sell'] = [];
            $postType['rent'] = [];
            foreach ($sells as $sell) {
                array_push($postType['sell'], $sell->type);
            }
            foreach ($rents as $rent) {
                array_push($postType['rent'], $rent->type);
            }
            return $this->handleSuccessJsonResponse($postType);
        } catch (Exception $e) {
            return $this->handleExceptionJsonResponse($e);
        }
    }

    /**
     * Lấy danh sách tin rao bán
     * GET /
     *
     * @param Request $request
     * @return JsonResponse
     */
    // public function getSellPost(Request $request)
    // {
    //     try {
    //         $data = $request->all();
    //         Log::info($data);
    //         $order = $request->get('order_by');
    //         $orderKey = $this->getOrderByKey($order);
    //         $data->order_by = $orderKey['order_by'];
    //         $data->order_with = $orderKey['order_with'];
    //         if ($data->endPrice) {
    //             $data->endPrice = 9999999999;
    //         }
    //         if ($data->endPrice) {
    //             $data->endPrice = 0;
    //         }
    //         if ($data->endSize) {
    //             $data->endSize = 9999999999;
    //         }
    //         if ($data->startSize) {
    //             $data->startSize = 0;
    //         }
    //         $posts = $this->postRepo->listPost($data);
    //         return $this->handleSuccessJsonResponse($posts);
    //     } catch (Exception $e) {
    //         return $this->handleExceptionJsonResponse($e);
    //     }
    // }

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
        if ($request->get('unit') === "VND") {
            $post['price_order'] = $request->get('price')/$request->get('size');
        } else if ($request->get('unit') === "Thỏa thuận") {
            $post['price_order'] = 0;
        } else {
            $post['price_order'] = $request->get('price');
        }
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
            Log::info($e->getMessage());
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
            if ($request->get('unit') === "VND") {
                $post['price_order'] = $request->get('price')/$request->get('size');
            } else if ($request->get('unit') === "Thỏa thuận") {
                $post['price_order'] = 0;
            } else {
                $post['price_order'] = $request->get('price');
            }
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
            Log::info($e);
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
            $post = $this->postRepo->delete($id);
            return $this->handleSuccessJsonResponse($post);
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
            $perPage = 4;
            $currentPage = request('page', 1);
            $pagedResults = array_slice($posts, ($currentPage - 1) * $perPage, $perPage);
            $posts = new LengthAwarePaginator($pagedResults, count($posts), $perPage, $currentPage);
            return $this->handleSuccessJsonResponse($posts);
        } catch (Exception $e) {
            Log::info($e);
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function suggestedPost($data) {
        $posts = $this->postRepo->listByDistricAndType($data->district, $data->type_id, $data->id);
        $ward = $data->ward;
        $size = $data->size;
        $price = $data->price;
        $unit = $data->unit;
        $bedroom = $data->bedroom;
        $floor = $data->floor;
        $toilet = $data->toilet;
        foreach ($posts as $post) {
            if($post->ward === $ward) {
                $point = 1;
            } else {
                $point = 0;
            }

            if(abs($post->size - $size) <= 1/5*$size) {
                $size_avg = 1 - 5*abs($post->size - $size)/$size;
            } else {
                $size_avg = 0;
            }

            if($unit === 'Thỏa Thuận') {
                $price_avg = 1;
            } else if($unit === "VND") {
                if($post->unit === 'Thỏa Thuận') {
                    $price_avg = 1;
                } else if($post->unit === 'VND') {
                    if(abs($post->price - $price) <= 1/5*$price) {
                        $price_avg = 1 - 5*abs($post->price - $price)/$price;
                    } else {
                        $price_avg = 0;
                    }
                } else {
                    if(abs($post->price*$post->size - $price) <= 1/5*$price) {
                        $price_avg = 1 - 5*abs($post->price*$post->size - $price)/$price;
                    } else {
                        $price_avg = 0;
                    }
                }
            } else {
                if($post->unit === 'Thỏa Thuận') {
                    $price_avg = 1;
                } else if($post->unit === 'VND/m2') {
                    if(abs($post->price - $price) <= 1/5*$price) {
                        $price_avg = 1 - 5*abs($post->price - $price)/$price;
                    } else {
                        $price_avg = 0;
                    }
                } else {
                    if(abs($post->price/$post->size - $price) <= 1/5*$price) {
                        $price_avg = 1 - 5*abs($post->price/$post->size - $price)/$price;
                    } else {
                        $price_avg = 0;
                    }
                }
            }

            if($bedroom) {
                $bedroom_avg = 1 - abs($post->bedroom - $bedroom)/$bedroom;
            } else {
                $bedroom_avg = 1;
            }

            if($floor) {
                $floor_avg = 1 - abs($post->floor - $floor)/$floor;
            } else {
                $floor_avg = 1;
            }

            if($toilet) {
                $toilet_avg = 1 - abs($post->toilet - $toilet)/$toilet;
            } else {
                $toilet_avg = 1;
            }
            $point_avg = $point + ($size_avg*2 + $price_avg*2 + $toilet_avg + $floor_avg + $bedroom_avg)/7;
            $post['point_avg'] = $point_avg;
        }
        $suggestedPosts = PostResource::collection($posts)->sortByDesc('point_avg')->values()->all();
        $perPage = 4;
        $currentPage = request('page', 1);
        $pagedResults = array_slice($suggestedPosts, ($currentPage - 1) * $perPage, $perPage);
        $suggestedPosts = new LengthAwarePaginator($pagedResults, count($suggestedPosts), $perPage, $currentPage);
        return $suggestedPosts;
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

            $suggestedPosts = $this->postRepo->suggested($topDistrictName, $topPostTypeId);
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
                    $size_interval = config("levelSize.$type_id");
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
            Log::info($e);
            return $this->handleExceptionJsonResponse($e);
        }
    }

    public function suggestedPostByFilter(Request $request)
    {
        try {
            $suggestedPosts = $this->suggestedPost($request);
            return $this->handleSuccessJsonResponse($suggestedPosts);
        } catch (Exception $e) {
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
            $search = $request->get('search');
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
