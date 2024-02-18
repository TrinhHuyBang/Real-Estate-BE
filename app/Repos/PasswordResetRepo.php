<?php
namespace App\Repos;

use App\Interfaces\PasswordResetRepoInterface;
use App\Models\PasswordReset;

class PasswordResetRepo implements PasswordResetRepoInterface
{
    public function get($email)
    {
        return PasswordReset::where('email', $email)->first();
    }
    public function create($data)
    {
        return PasswordReset::create($data);
    }
    public function edit($email, $token)
    {
        PasswordReset::where('email', $email)->update(['token' => $token]);
        return;
    }
    public function delete($id)
    {

    }

    public function getByToken($token)
    {
        return PasswordReset::where('token', $token)->first();
    }
}