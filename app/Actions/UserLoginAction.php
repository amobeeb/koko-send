<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserLoginAction
{
    public function execute($request)
    {
        $user = User::whereEmail($request->email)->first();
        $verifyPassword = Hash::check($request->password, $user->password);
        if($verifyPassword){
            $token = $user->createToken($request->email);
            return $token->plainTextToken;
        }
        return false;
    }
}
