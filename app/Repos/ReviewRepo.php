<?php
namespace App\Repos;

use App\Interfaces\ReviewRepoInterface;
use App\Models\Review;
use Illuminate\Support\Arr;

class ReviewRepo implements ReviewRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        return Review::where('id', $id)->first();
    }
    public function create($data)
    {
        
    }
    public function edit($id, $data)
    {
        return Review::where('id', $id)->update($data);
    }
    public function delete($id)
    {

    }

    public function getAvgRating()
    {
        $avgRating = Review::avg('rating');
        return $avgRating;
    }

    public function createOrUpdate($data)
    {
        $review = Review::where('user_id', Arr::get($data, 'user_id'))->first();
        if($review) {
            $review->fill($data)->save();
            return $review;
        } else {
            $review = new Review;
            $review->fill($data)->save();
            return $review;
        }
    }
}