<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SendContactEmail;
use App\Traits\HandleJsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    use HandleJsonResponse;

    public function sendContactEmail(Request $request) {
        try {
            $user_name = $request->get('user_name');
            $phone = $request->get('phone');
            $content = $request->get('content');
            $to_email = $request->get('to_email');
            SendContactEmail::dispatch($user_name, $phone, $to_email, $content)->onQueue('email');
            return $this->handleSuccessJsonResponse();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->handleExceptionJsonResponse($e);
        }
    }
}
