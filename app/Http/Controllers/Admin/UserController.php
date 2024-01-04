<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\SoftDeletesUser;
use App\Actions\Admin\SuspendUser;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use ApiResponse;
    private const PerPage = 20;

    public function index()
    {
        $user = User::latest('id')->paginate(self::PerPage);
        return $this->success(Response::HTTP_OK, 'success', UserResource::collection($user), 'retrieved user', true);
    }

    public function suspend($id, SuspendUser $suspendUser)
    {
        $response = $suspendUser->execute($id);
       if(isset($response['success'])){
           return $this->success(Response::HTTP_OK,'success', [], $response['success']);
       }

        if(isset($response['error'])){
            return $this->error(Response::HTTP_BAD_REQUEST,'success', $response['error']);
        }
    }

    public function delete($id, SoftDeletesUser $softDeletesUser)
    {
        if($softDeletesUser->execute($id)){
            return $this->success(Response::HTTP_OK,'success', [], 'user deleted successfully');
        }
    }

    public function restore($id, SoftDeletesUser $softDeletesUser)
    {
        if($softDeletesUser->restored($id)){
            return $this->success(Response::HTTP_OK,'success', [], 'deleted user restored successfully');
        }
    }

    public function deletedList(SoftDeletesUser $softDeletesUser)
    {
            return $this->success(Response::HTTP_OK,'success', UserResource::collection($softDeletesUser->list()), 'deleted user retrieved');
    }
}
