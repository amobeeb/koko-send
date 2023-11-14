<?php

namespace App\Services;

use App\Models\Log;

class LoggerService
{
    public static function error(string $model_type = 'User', int $model_id, int $status = 400, string $description= '', string $method):void
    {
        Log::create([
            'status' => $status,
            'method' => $method,
            'description' => $description,
            'loggable_id' => $model_id,
            'loggable_type' => $model_type
        ]);
    }
}
