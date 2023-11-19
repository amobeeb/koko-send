<?php

namespace App\Http\Controllers\User\Auth;

use App\Actions\ResetPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ResetPasswordController extends Controller
{
    use ApiResponse;

    public function __invoke(ResetPasswordRequest $request, ResetPasswordAction $resetPassword)
    {
        $reset = $resetPassword->execute($request->all());
        if ($reset) {
            return $this->success(Response::HTTP_OK, 'success', [], "password reset");
        }
        return $this->error(Response::HTTP_BAD_REQUEST, 'failed', 'unable to reset password');
    }
}
