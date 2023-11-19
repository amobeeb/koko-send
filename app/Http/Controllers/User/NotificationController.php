<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    use ApiResponse;
    public function show($id)
    {
        $notification = Notification::whereHas('user', function($q) use ($id) {
            $q->where('uuid', $id);
        })->latest('id');

        return $this->success(Response::HTTP_OK, 'success', $notification, 'notification retrieved');
    }
}
