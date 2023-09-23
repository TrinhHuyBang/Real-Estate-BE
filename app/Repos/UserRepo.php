<?php
namespace App\Repos;

use App\Interfaces\UserRepoInterface;
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
        
    }
    public function edit($id, $data)
    {
        return User::where('id', $id)->update($data);
    }
    public function delete($id)
    {

    }
}