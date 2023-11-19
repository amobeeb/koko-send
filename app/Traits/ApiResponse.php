<?php

namespace App\Traits;

trait ApiResponse
{
    public function success($code, $status, $data, $message = '', $paginated = false)
    {
        $dataResponse = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];

        if($paginated){
            $dataResponse['data'] = $data->response()->getData(true);
        }
        return response()->json($dataResponse, $code);
    }

    public function error($code, $status, $message)
    {
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $code);
    }
}
