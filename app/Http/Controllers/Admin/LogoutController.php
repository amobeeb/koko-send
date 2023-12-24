<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LogoutController extends Controller
{
    use ApiResponse;

    public function __invoke()
    {
        if (request()->user()->currentAccessToken()) {
            request()->user()->tokens()->delete();
            return $this->success(Response::HTTP_OK, 'success',  [], 'user logout successfully');
        }
        return $this->error(Response::HTTP_BAD_REQUEST, 'failed', 'invalid session');
    }
}
