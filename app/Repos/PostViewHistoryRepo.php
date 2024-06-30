<?php
namespace App\Repos;

use App\Interfaces\PostViewHistoryRepoInterface;
use App\Models\PostViewHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostViewHistoryRepo implements PostViewHistoryRepoInterface
{
    public function getInstance($fields)
    {
    }
    public function get($id)
    {
    }
    public function create($data)
    {
        return PostViewHistory::create($data);
    }
    public function edit($id, $data = [])
    {
        return PostViewHistory::where('id', $id)->update($data);
    }
    public function delete($id)
    {
        return PostViewHistory::where('id', $id)->delete();
    }

    public function getByUserIdAndPostId($user_id, $post_id)
    {
        return PostViewHistory::where('user_id', $user_id)->where('post_id', $post_id)->first();
    }

    public function getByGuestIdAndPostId($guest_id, $post_id)
    {
        return PostViewHistory::where('guest_id', $guest_id)->where('post_id', $post_id)->first();
    }

    public function listPostByUserId($user_id, $latest)
    {
        $posts = PostViewHistory::join('posts', 'post_view_histories.post_id', '=', 'posts.id')
        ->where(function ($query) use ($user_id){
            $query->where('post_view_histories.user_id', $user_id)
                ->orWhere('post_view_histories.guest_id', $user_id);
        })
        ->where('post_view_histories.post_id', '!=', $latest)
        ->orderBy('post_view_histories.viewed_at', 'desc')
        ->select('posts.*')
        ->get();
        return $posts;
    }

    public function latestHistory($user_id)
    {
        $post = PostViewHistory::where('post_view_histories.user_id', $user_id)->orWhere('post_view_histories.guest_id', $user_id)
        ->orderBy('post_view_histories.viewed_at', 'desc')->first();
        return $post;
    }

    public function topLatestHistory($user_id)
    {
        $posts = PostViewHistory::where(function ($query) use ($user_id){
            $query->where('post_view_histories.user_id', $user_id)
                ->orWhere('post_view_histories.guest_id', $user_id);
        })
        ->get()->pluck('post_id');
        return $posts;
    }

    // Đưa ra top các district mà có số lượt xem lớn nhất (lớn hơn hoặc bẳng mức trung bình)
    // Ví dụ : trong số các bài đăng đã xem trong 2 ngày gần nhất có 3 district thì district nào
    // có số lượng trung bình lớn hơn hoặc bằng 1/3 thì sẽ được lấy ra
    public function topDistricts($user_id)
    {
        $result = PostViewHistory::join('posts', 'post_view_histories.post_id', '=', 'posts.id')
            ->where(function ($query) use ($user_id){
                $query->where('post_view_histories.user_id', $user_id)
                    ->orWhere('post_view_histories.guest_id', $user_id);
            })
            ->where('post_view_histories.viewed_at', '>=', Carbon::now()->subDays(2))
            ->select(DB::raw('posts.district as district'), DB::raw('COUNT(*) as post_count'))
            ->groupBy('posts.district')
            ->orderBy('post_count', 'desc')
            ->get();

        $totalPosts = $result->sum('post_count');
        $top = count($result);

        $resultArray = $result->map(function ($row) use ($totalPosts, $top) {
            if($row->post_count / ($totalPosts ?: 1) >= 1/($top ?: 1)) {
                return [
                    'district' => $row->district,
                    'percent' => ($row->post_count / ($totalPosts ?: 1)),
                ];
            }
        })->filter();
        return $resultArray->values()->toArray();
    }

    public function topWards($user_id)
    {
        $result = PostViewHistory::join('posts', 'post_view_histories.post_id', '=', 'posts.id')
            ->where(function ($query) use ($user_id){
                $query->where('post_view_histories.user_id', $user_id)
                    ->orWhere('post_view_histories.guest_id', $user_id);
            })
            ->where('post_view_histories.viewed_at', '>=', Carbon::now()->subDays(2))
            ->select(DB::raw('posts.ward as ward'), DB::raw('COUNT(*) as ward_count'))
            ->groupBy('posts.ward')
            ->orderBy('ward_count', 'desc')
            ->get();
        $totalPosts = $result->sum('ward_count');
        $top = count($result);
        $resultArray = $result->map(function ($row) use ($totalPosts, $top) {
            if($row->ward_count / ($totalPosts ?: 1) >= 1/($top ?: 1)) {
                return [
                    'ward' => $row->ward,
                    'percent' => ($row->ward_count / ($totalPosts ?: 1)),
                ];
            }
        })->filter();
        return $resultArray->values()->toArray();
    }

    // Đưa ra top các type mà có số lượt xem lớn nhất (lớn hơn hoặc bẳng mức trung bình)
    // Ví dụ : trong số các bài đăng đã xem trong 2 ngày gần nhất có 3 type thì type nào
    // có số lượng trung bình lớn hơn hoặc bằng 1/3 thì sẽ được lấy ra
    public function topPostType($user_id)
    {
        $result = PostViewHistory::join('posts', 'post_view_histories.post_id', '=', 'posts.id')
            ->where(function ($query) use ($user_id){
                $query->where('post_view_histories.user_id', $user_id)
                    ->orWhere('post_view_histories.guest_id', $user_id);
            })
            ->where('post_view_histories.viewed_at', '>=', Carbon::now()->subDays(2))
            ->select(DB::raw('posts.type_id as type_id'), DB::raw('COUNT(*) as type_count'))
            ->groupBy('posts.type_id')
            ->orderBy('type_count', 'desc')
            ->get();
        $totalPosts = $result->sum('type_count');
        $top = count($result);
        $resultArray = $result->map(function ($row) use ($totalPosts, $top) {
            if($row->type_count / ($totalPosts ?: 1) >= 1/($top ?: 1)) {
                return [
                    'type_id' => $row->type_id,
                    'percent' => ($row->type_count / ($totalPosts ?: 1)),
                ];
            }
        })->filter();
        return $resultArray->values()->toArray();
    }

    // Đưa ra top các mức giá mà có số lượt xem lớn nhất tƯơng ứng với từng loại bài đăng (lớn hơn hoặc bẳng mức trung bình)
    // Ví dụ : trong số các bài đăng đã xem trong 2 ngày gần nhất xét với mảng top type_id đã lấy được
    // có 2 mức giá là 2,3 thì lấy ra mức giá có mức xuất hiện lớn hơn
    // Mức giá được tính tương ứng với từng loại bài đăng ví dụ : Bán nhà riêng thì khoảng giá giao động từng mức có thể là 1 tỷ
    public function topPrice($user_id, $topPostType) {
        $result = [];
    
        foreach ($topPostType as $type_id) {
            $posts = PostViewHistory::join('posts', 'post_view_histories.post_id', '=', 'posts.id')
                ->where(function ($query) use ($user_id) {
                    $query->where('post_view_histories.user_id', $user_id)
                        ->orWhere('post_view_histories.guest_id', $user_id);
                })
                ->where('post_view_histories.viewed_at', '>=', Carbon::now()->subDays(2))
                ->where('type_id', $type_id)
                ->get();
    
            // Tính tổng số bài đăng cho mỗi type
            $total_posts = $posts->count();
    
            // Tính toán mức giá và phần trăm cho từng mức giá
            $price_data = $posts->groupBy(function ($post) {
                $price = $post->price;
                $orderOfMagnitude = floor(log10($price));
                $range = $orderOfMagnitude >= 1 ? 10 ** ($orderOfMagnitude) : 1;
                return floor(($price/$range) + 10*$orderOfMagnitude);
            })->map(function ($priceGroup) use ($total_posts) {
                $count = $priceGroup->count();
                $percentage = ($count / $total_posts);
    
                return [
                    'percentage' => $percentage,
                ];
            });
    
            // Chuyển đổi dữ liệu để có được mức giá và phần trăm tương ứng
            $formatted_data = $price_data->map(function ($item, $key) use ($price_data) {
                if ($item['percentage'] >= 1 / count($price_data)) {
                    return [
                        'price_level' => $key,
                        'percentage' => $item['percentage'],
                    ];
                }
            })->filter();
    
            $result[$type_id] = $formatted_data->values();
        }
    
        return $result;
    }

    public function topSize($user_id, $topPostType) {
        $result = [];
        foreach ($topPostType as $type_id) {
            $posts = PostViewHistory::join('posts', 'post_view_histories.post_id', '=', 'posts.id')
                ->where(function ($query) use ($user_id){
                    $query->where('post_view_histories.user_id', $user_id)
                        ->orWhere('post_view_histories.guest_id', $user_id);
                })
                ->where('post_view_histories.viewed_at', '>=', Carbon::now()->subDays(2))
                ->where('type_id', $type_id)->get();

            // Tính tổng số bài đăng cho mỗi type
            $total_posts = $posts->count();

            // Tính toán mức giá và phần trăm cho từng mức giá
            $size_data = $posts->groupBy(function ($post) {
                $size = $post->size;
                $orderOfMagnitude = floor(log10($size));
                $range = $orderOfMagnitude >= 1 ? 10 ** ($orderOfMagnitude) : 1;
                return floor(($size/$range) + 10*$orderOfMagnitude);
            })->map(function ($priceGroup) use ($total_posts) {
                $count = $priceGroup->count();
                $percentage = ($count / $total_posts);
    
                return [
                    'percentage' => $percentage,
                ];
            });

            // Chuyển đổi dữ liệu để có được mức giá và phần trăm tương ứng
            $formatted_data = $size_data->map(function ($item, $key) use ($size_data) {
                if($item['percentage'] >= 1/count($size_data)) {
                    return [
                        'size_level' => $key,
                        'percentage' => $item['percentage'],
                    ];
                }
            })->filter();

            $result[$type_id] = $formatted_data->values();
        }
        return $result;
    }
}