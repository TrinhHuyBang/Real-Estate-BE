<?php
namespace App\Repos;

use App\Interfaces\UserRepoInterface;
use App\Models\Bookmark;
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
        return User::select(['name', 'email', 'phone', 'avatar', 'address'])->where('id', $id)->first();
    }
}