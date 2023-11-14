<?php

namespace App\Http\Controllers\User\Auth;

use App\Actions\UserLoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ApiResponse;
    public function __invoke(LoginRequest $request, UserLoginAction $login)
    {
        $userLoginToken = $login->execute($request);
        if($userLoginToken){
            return $this->success(Response::HTTP_OK, 'success', ['token' => $userLoginToken], 'user login');
        }
        return $this->error(Response::HTTP_BAD_REQUEST, 'failed', 'invalid username or password');
    }
}
