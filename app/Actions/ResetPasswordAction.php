<?php

namespace App\Actions;

use App\Models\User;

class ResetPasswordAction
{
    public function execute(array $request)
    {
        $user = User::whereEmail($request['email'])->first();
        if($user){
            User::whereEmail($request['email'])->update([
                'password' => bcrypt($request['password'])
            ]);
            return true;
        }
        return false;
    }
}
