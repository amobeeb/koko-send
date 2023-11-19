<?php

namespace App\Http\Controllers\User;

use App\Actions\ChangePasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use ApiResponse;
    public function profile()
    {
        return $this->success(Response::HTTP_OK, 'success', (new UserResource(request()->user())),'user profile' );
    }

    public function changePassword($id, ChangePasswordRequest $request, ChangePasswordAction $changePassword)
    {
        $passwordChange = $changePassword->execute($id, $request->all());
        if(isset($passwordChange['error'])){
            return $this->error(Response::HTTP_OK, 'failed', $passwordChange['error']);
        }

        if(isset($passwordChange['success'])){
            return $this->success(Response::HTTP_OK, 'success', [],$passwordChange['success'] );
        }

    }

}
