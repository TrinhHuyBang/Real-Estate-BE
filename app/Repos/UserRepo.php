<?php
namespace App\Repos;

use App\Interfaces\UserRepoInterface;
use App\Models\Bookmark;
use App\Models\Post;
use App\Models\User;

class UserRepo implements UserRepoInterface
{
    public function getInstance($fields)
    {

    }
    public function get($id)
    {
        return User::where('id', $id)->first();
    }
    public function create($data)
    {
        return User::create($data);
    }
    public function edit($id, $data)
    {
        return User::where('id', $id)->update($data);
    }
    public function delete($id)
    {

    }
    public function findUserByEmail($email) {
        return User::where('email', $email)->first();
    }
    public function findUserByPhone($phone) {
        return User::where('phone', $phone)->first();
    }
    public function checkStatus($username) {
        return User::where(function ($query) use ($username){
            $query->where('email', $username)
                ->orWhere('phone', $username);
        })->where('status', 1)->first();
    }

    public function getNumberBookmark($id) {
        return Bookmark::where('user_id', $id)->get()->count();
    }

    public function getDetail($id) {
        $user =  User::select(['name', 'email', 'phone', 'avatar'])->where('id', $id)->first();
        $display_count = Post::where('user_id', $id)->where('status', 1)->count();
        $expired_count = Post::where('user_id', $id)->where('status', 2)->count();
        $all_count = Post::where('user_id', $id)->whereIn('status', [config('status.expired'), config('status.displayPost')])->count();
        $user->display_count = $display_count;
        $user->expired_count = $expired_count;
        $user->all_count = $all_count;
        return $user;
    }
}