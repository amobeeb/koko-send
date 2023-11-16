<?php

namespace App\Http\Controllers\User\Auth;

use App\Actions\ForgetPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForgetPasswordController extends Controller
{
    use ApiResponse;
    public function __invoke(ForgetPasswordRequest $request, ForgetPasswordAction $forgetPassword)
    {
        $forgetPassword = $forgetPassword->execute($request->all());
        if($forgetPassword){
            return $this->success(Response::HTTP_OK, 'success', [], 'OTP sent');
        }
        return $this->error(Response::HTTP_BAD_REQUEST, 'failed', 'unable to send OTP');
    }
}
