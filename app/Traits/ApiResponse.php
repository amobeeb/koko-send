<?php

namespace App\Traits;

trait ApiResponse
{
    public function success($code, $status, $data, $message = '')
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
            'message' => $message
        ], $code);
    }

    public function error($code, $status, $message)
    {
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $code);
    }
}
