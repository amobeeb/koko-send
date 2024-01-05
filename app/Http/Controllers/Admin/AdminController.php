<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    use ApiResponse;
    public function profile()
    {
        if(auth()->check()){
            return $this->success(Response::HTTP_OK,'success', auth()->user(), 'admin profile retrieved');
        }
    }
}
