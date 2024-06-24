<?php
namespace App\Repos;

use App\Enums\AdminType;
use App\Interfaces\NewsRepoInterface;
use App\Models\Admin;
use App\Models\News;
use ParagonIE\Sodium\Core\Curve25519\Fe;

class NewsRepo implements NewsRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        $news = News::where('id', $id)->first();
        $news->author = Admin::select(['id', 'name', 'avatar'])->where('id', $news->admin_id)->first();
        return $news;
    }
    public function create($data)
    {
        $news = new News();
        $news->fill($data)->save();
        return $news;
    }
    public function edit($id, $data)
    {
        $news = News::where('id', $id)->first();
        $news->fill($data)->save();
        return $news;
    }
    public function delete($id)
    {
        $news = News::where('id', $id)->first();
        $news->fill(['status' => 0])->save();
        return $news;
    }

    public function listByAdmin($search, $is_owner = false) {
        $admin  = auth('admin')->user();
        $query = News::where(function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('id', '=', $search);
            });
        if($is_owner) {
            $query->where('admin_id', $admin->id);
        } else {
            $query->where('status', 1);
        }
        $list_news = $query->orderBy('created_at', 'DESC')->paginate(10);
        return $list_news;
    }

    public function listHeadline($type) {
        $query = News::select(['id', 'created_at', 'image', 'title', 'subtitle'])->where('status', 1);
        if($type == "hcm") {
            $query->where('province', '=', 'Thành phố Hồ Chí Minh-79');
        } else if($type == "hn") {
            $query->where('province', '=', 'Thành phố Hà Nội-01');
        } else if($type == "headline") {
            $query->orderBy('number_views', 'DESC');
        }
        $news = $query->orderBy('created_at', 'DESC')->limit(5)->get();
        return $news;
    }

    public function list($type) {
        $query = News::select(['news.id', 'news.created_at', 'image', 'title', 'subtitle', 'admins.name as author'])
        ->join('admins', 'admins.id', '=', 'news.admin_id')
        ->where('news.status', 1);
        if($type == "hcm") {
            $query->where('province', '=', 'Thành phố Hồ Chí Minh-79');
        } else if($type == "hn") {
            $query->where('province', '=', 'Thành phố Hà Nội-01');
        }
        $news = $query->orderBy('news.created_at', 'DESC')->paginate(6);
        return $news;
    }
}