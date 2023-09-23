<?php
namespace App\Repos;

use App\Interfaces\PostRepoInterface;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Project;
use App\Models\User;

class PostRepo implements PostRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        $post = Post::where('id', $id)->first();
        if ($post) {
            $images = PostImage::where('post_id', $post->id)->get();
            $imageUrls = [];
            foreach ($images as $image) {
                array_push($imageUrls, $image->url);
            }
            $post->images = $imageUrls;
            $post->project = Project::where('id', $post->project_id)->first();
            $post->user = User::where('id', $post->user_id)->first();
        }
        return $post;
    }
    public function create($data)
    {
        return Post::create($data);
    }
    public function edit($id, $data)
    {

    }
    public function delete($id)
    {

    }

    public function listPost($data)
    {
        return Post::get();
    }
}