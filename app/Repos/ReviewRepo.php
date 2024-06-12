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

    public function list() {
        $reviews = Review::select(['users.name', 'users.avatar', 'users.id', 'review', 'rating', 'reviews.created_at'])
        ->leftJoin('users', 'users.id', '=', 'reviews.user_id')
        ->paginate(10);
        return $reviews;
    }

    public function getAvgRating()
    {
        $avgRating = Review::avg('rating');
        return (float)number_format($avgRating, 1);
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

    public function countReview() {
        return Review::count();
    }
}