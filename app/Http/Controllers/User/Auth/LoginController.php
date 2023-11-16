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
        $userLogin = $login->execute($request);
        if($userLogin){
            return $this->success(Response::HTTP_OK, 'success',  $userLogin, 'user logged in');
        }
        return $this->error(Response::HTTP_BAD_REQUEST, 'failed', 'invalid username or password');
    }
}
