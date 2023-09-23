<?php

namespace App\Traits;

use Exception;

trait HandleJsonResponse
{
    public function handleExceptionJsonResponse(Exception $e)
    {
        return response()->json([
            'error' => $e->getMessage(),
            'code' => $e->getCode(),
        ], 400);
    }

    public function handleExceptionResponse(Exception $e)
    {
        return [
            'error' => $e->getMessage(),
            'code' => $e->getCode(),
        ];
    }

    public function handleSuccessJsonResponse($data = null, string $message = '')
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function handleSuccessRequest($data, string $message = '')
    {
        return [
            'data' => $data,
            'message' => $message,
        ];
    }
}