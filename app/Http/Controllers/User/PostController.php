<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PostType;
use App\Repos\PostImageRepo;
use Illuminate\Http\Request;
use App\Repos\PostRepo;
use App\Repos\ProjectRepo;
use App\Repos\UserRepo;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Traits\HandleJsonResponse;

class PostController extends Controller
{
    use HandleJsonResponse;

    protected PostRepo $postRepo;
    protected PostImageRepo $postImageRepo;
    protected ProjectRepo $projectRepo;
    protected UserRepo $userRepo;

    public function __construct(PostRepo $postRepo, PostImageRepo $postImageRepo, ProjectRepo $projectRepo, UserRepo $userRepo)
    {
        $this->postRepo = $postRepo;
        $this->postImageRepo = $postImageRepo;
        $this->projectRepo = $projectRepo;
        $this->userRepo = $userRepo;
    }

    public function getPostTypes()
    {
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
        return $postType;
    }

    /**
     * Lấy danh sách tin rao bán
     * GET /
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getSellPost(Request $request)
    {
        try {
            $data = $request->all();
            $order = $request->get('order_by');
            $postType = $request->get('post_type');
            $type = $request->get('type');
            $data['endPrice'] = 9999999999;
            $startPrice = 0;
            $startSize = 0;
            $endSize = 9999999999;
            $province = $request->get('province');
            $district = $request->get('district');
            $ward = $request->get('ward');
            $project = $request->get('project');
            $bedRoom = $request->get('bed_room'); 
            if ($request->get('endPrice')) {
                $endPrice = $request->get('endPrice');
            }
            if ($request->get('startPrice')) {
                $startPrice = $request->get('startPrice');
            }
            if ($request->get('endSize')) {
                $endSize = $request->get('endSize');
            }
            if ($request->get('startSize')) {
                $startSize = $request->get('startSize');
            }

            // return $this->handleSuccessJsonResponse($posts);
        } catch (Exception $e) {
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
        $post = $this->postRepo->get($id);
        try {
            if (!$post) {
                throw new Exception('Bài đăng không tồn tại');
            }
            return $this->handleSuccessJsonResponse(['post' => $post]);
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
        $post = $request->except('images');
        if ($request->get('unit') === "VND") {
            array_push($post, ['price_order' => $request->get('price') / $request->get('size')]);
        } else if ($request->get('unit') === "Thỏa thuận") {
            array_push($post, ['price_order' => 0]);
        } else {
            array_push($post, ['price_order' => $request->get('price')]);
        }
        $postImages = $request->get('images');
        Log::info($postImages);
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
}
