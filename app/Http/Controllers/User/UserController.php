<?php

namespace App\Http\Controllers\User;

use App\Actions\ChangePasswordAction;
use App\Actions\UploadPicture;
use App\Actions\UserPinAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangePinRequest;
use App\Http\Requests\NewPinRequest;
use App\Http\Requests\uploadPictureRequest;
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

    public function  newPin(NewPinRequest $request, UserPinAction $userPin)
    { 
        $changePin = $userPin->newPin($request);
        
        if(isset($changePin['error'])){
            return $this->error(Response::HTTP_OK, 'failed', $changePin['error']);
        }

        if(isset($changePin['success'])){
            return $this->success(Response::HTTP_OK, 'success', [],$changePin['success'] );
        } 
    }

    public function changePin(ChangePinRequest $request, UserPinAction $userPin)
    {
     
        $passwordChange = $userPin->changePin($request);
        if(isset($passwordChange['error'])){
            return $this->error(Response::HTTP_OK, 'failed', $passwordChange['error']);
        }

        if(isset($passwordChange['success'])){
            return $this->success(Response::HTTP_OK, 'success', [],$passwordChange['success'] );
        } 
    }

    public function uploadPicture(uploadPictureRequest $request, UploadPicture $upload)
    {
        $response = $upload->execute($request); 
        if(isset($response['success'])){
            return $this->success(Response::HTTP_OK, 'success', [], $response['success']);
        }
    }

    

}
