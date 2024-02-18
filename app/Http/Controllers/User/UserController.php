<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repos\UserRepo;
use App\Traits\HandleJsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use HandleJsonResponse;
    protected UserRepo $userRepo;
    
    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    public function get ($id)
    {
        $user = $this->userRepo->getDetail($id);
        return $this->handleSuccessJsonResponse($user);
    }
}
