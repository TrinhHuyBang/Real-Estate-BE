<?php
namespace App\Repos;

use App\Interfaces\BookmarkRepoInterface;
use App\Models\Bookmark;
use App\Models\Post;

class BookmarkRepo implements BookmarkRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {

    }
    public function create($data)
    {
        return Bookmark::create($data);
    }
    public function edit($id, $data)
    {
    }
    public function delete($id)
    {
        return Bookmark::destroy($id);
    }

    public function getByPostId($postId)
    {
    }

    public function getByPostIdAndUserId($postId, $userId)
    {
        return Bookmark::where('post_id', $postId)->where('user_id', $userId)->first();
    }

    public function listPostOrderBy($postType, $orderBy, $orderWith)
    {
        return Bookmark::rightJoin('posts', 'bookmarks.post_id', '=', 'posts.id')
            ->where('bookmarks.user_id', auth()->user()->id)
            ->whereIn('posts.type_id', $postType)
            ->where('posts.status', config('status.displayPost'))
            ->orderBy($orderWith, $orderBy)
            ->get();
    }
}