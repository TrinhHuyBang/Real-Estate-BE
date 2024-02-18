<?php
namespace App\Repos;

use App\Interfaces\VerifyEmailTokenRepoInterface;
use App\Models\VerifyEmailToken;
use Carbon\Carbon;

class VerifyEmailTokenRepo implements VerifyEmailTokenRepoInterface
{
    public function get($email)
    {
        return VerifyEmailToken::where('email', $email)->first();
    }
    public function create($data)
    {
        return VerifyEmailToken::create($data);
    }
    public function edit($email, $token)
    {
        VerifyEmailToken::where('email', $email)->update(['token' => $token]);
        return;
    }
    public function delete($email)
    {
        return VerifyEmailToken::where('email', $email)->delete();
    }

    public function getByEmailAndToken($email, $token)
    {
        return VerifyEmailToken::where('email', $email)->where('token', $token)->first();
    }
}