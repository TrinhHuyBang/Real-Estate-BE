<?php

namespace App\Repos;

use App\Interfaces\PostRepoInterface;
use App\Models\Bookmark;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\PostViewHistory;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostRepo implements PostRepoInterface
{
    public function getInstance($fields)
    {
    }
    public function get($id)
    {
        $post = Post::where('id', $id)->first();
        if ($post) {
            $type_id = $post->type_id;
            if ($type_id < 12) {
                $type = 'sell';
            } else {
                $type = 'rent';
            }
            $images = PostImage::where('post_id', $post->id)->get();
            $imageUrls = [];
            foreach ($images as $image) {
                array_push($imageUrls, $image->url);
            }
            $post->images = $imageUrls;
            $post->type = $type;
            $post->project = Project::where('id', $post->project_id)->first();
            $post->user = User::select('name', 'id', 'email', 'phone', 'avatar')->where('id', $post->user_id)->first();
            $post->user->numberPost = $this->getNumberPostByType($id, $post->user_id, config("postType.$type"));
        }
        return $post;
    }

    public function getPost($id)
    {
        $post = Post::where('id', $id)->first();
        return $post;
    }

    public function create($data)
    {
        return Post::create($data);
    }
    public function edit($id, $data)
    {
        return Post::where('id', $id)->update($data);
    }
    public function delete($id)
    {
        Bookmark::where('post_id', $id)->delete();
        return Post::where('id', $id)->update(['status' => config('status.deleted')]);
    }

    public function checkAuth($id)
    {
        $post = Post::where('id', $id)->first();
        if ($post->user_id === Auth::id()) {
            return true;
        } else {
            return false;
        }
    }

    public function listPost($data)
    {
        $query = Post::where('status', config('status.displayPost'))
            ->where('size', '>=', $data['startSize'])->where('size', '<=', $data['endSize']);
        if(Arr::get($data, 'project_id')) {
            $query->where('project_id', Arr::get($data, 'project_id'));
        } else {
            $query->where('province', 'like', '%' . $data['province'] . '%')->where('district', 'like', '%' . $data['district'] . '%')
            ->where('ward', 'like', '%' . $data['ward'] . '%');
        }
        if (!$data['type_id']) {
            if ($data['type'] === 'sell') {
                $query->whereIn('type_id', config('postType.sell'));
            } else {
                $query->whereIn('type_id', config('postType.rent'));
            }
        } else {
            $query->where('type_id', $data['type_id']);
        }
        if ($data['priceSelected'] == 'Thoả thuận') {
            $query->where('unit', 'Thỏa Thuận');
        } else {
            $query->where('price', '>=', $data['startPrice'])->where('price', '<=', $data['endPrice']);
        }
        $posts = $query->orderBY($data['order_with'], $data['order_by'])->get();
        return $posts;
    }

    public function numberPostByLocation()
    {
        $topProvinces = Post::where('status', config('status.displayPost'))->select('province', DB::raw('count(*) as total'))->groupBy('province')->orderByDesc('total')->take(4)->get();
        return $topProvinces;
    }

    public function getListAll()
    {
        $query = Post::where('status', config('status.displayPost'));
        if(auth()->check()) {
            $query->where('user_id', '!=', auth()->user()->id);
        }
        $posts = $query->orderByDesc('published_at')->get();
        return $posts;
    }

    // Lấy danh sách các bài đăng dựa vào loại tin đăng ( Thuê/ bán) và trạng thái của bài đăng đó
    public function listByStatus($status, $postType, $search = '')
    {
        if ($status == config('status.all')) {
            $posts = Post::where('user_id', auth()->user()->id)->whereIn('type_id', $postType)
                ->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                })->orderByDesc('created_at')->get();
        } else {
            $posts = Post::where('user_id', auth()->user()->id)->whereIn('type_id', $postType)->where('status', $status)
                ->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                })->orderByDesc('created_at')->get();
        }
        return $posts;
    }

    public function getNumberPostByType($id, $user_id, $type)
    {
        return Post::where('user_id', $user_id)->where('id', '!=', $id)->whereIn('type_id', $type)->where('status', config('status.displayPost'))->get()->count();
    }

    // Lấy danh sách bài đăng của người dùng khác
    public function listByUser($id, $postType)
    {
        $posts = Post::where('user_id', $id)->whereIn('type_id', $postType)->whereIn('status', [config('status.displayPost'), config('status.expired')])->orderByDesc('published_at')->get();
        return $posts;
    }

    // Lấy danh sách id bài đăng của chính mình
    public function listByOwner($user_id)
    {
        $posts = Post::select(['id'])
            ->where('user_id', $user_id)
            ->get()->pluck('id');
        return $posts;
    }

    public function suggested($topDistricts, $topPostTypes, $histories = [])
    {
        // Danh sách các bài đăng gợi ý phải nằm ngoài lịch sử xem của người dùng
        $query = Post::where('status', config('status.displayPost'))->whereNotIn('id', $histories);
        if(auth()->check()) {
            $query->where('user_id', '!=', auth()->user()->id);
        }
        // Chỉ lấy danh sách các bài đăng nằm trong top tỉnh
        $query->whereIn('district', $topDistricts);
        // Chỉ lấy danh sách các bài đăng nằm trong top các type_id
        $query->whereIn('type_id', $topPostTypes);

        $postSuggests = $query->get(); // Lấy ra danh sách các bài đăng chưa tất cả các điều kiện trên
        return $postSuggests;
    }

    public function updateExpiredPost()
    {
        $current_date = Carbon::now();
        Post::where('status', config('status.displayPost'))
            ->where('expired_at', '<=', $current_date)
            ->update(['status' => config('status.expired')]);
    }

    // Lấy ra danh sách các bài đăng cho admin theo status
    public function listByAdminWithStatus( $search, $status, $postType, $orderBy, $orderWith)
    {
        return Post::whereIn('type_id', $postType)
            ->where('status', $status)
            ->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('id', '=', $search);
                })
            ->orderBY($orderWith, $orderBy)->get();
    }

    public function countPost() {
        return Post::whereIn('status', [config('status.displayPost'), config('status.expired')])->count();
    }

    public function countRequest() {
        return Post::where('status', config('status.hiddenPost'))->count();
    }
}