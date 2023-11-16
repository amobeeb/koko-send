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
            $user->tokens()->delete();
            $token = $user->createToken($request->email);
            return [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'is_pin_created' => !empty($user->pin),
               'token' => $token->plainTextToken
            ];
        }
        return false;
    }
}
