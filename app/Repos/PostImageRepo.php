<?php
namespace App\Repos;

use App\Interfaces\PostImageRepoInterface;
use App\Models\PostImage;

class PostImageRepo implements PostImageRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {

    }
    public function create($data)
    {
        return PostImage::create($data);
    }
    public function edit($id, $data)
    {
    }
    public function delete($id)
    {
        PostImage::where('post_id', $id)->delete();
    }

    public function getByPostId($postId)
    {
        $images = PostImage::where('post_id', $postId)->get();
        $result = [];
        foreach ($images as $image) {
            array_push($result, $image->url);
        }
        return $result;
    }
}