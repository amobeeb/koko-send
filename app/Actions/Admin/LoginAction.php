<?php
namespace App\Actions\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function execute(array $request)
    {
        $admin = Admin::where('email', $request['email'])->first();
        $verifyPassword = Hash::check($request['password'], $admin->password);
        if($verifyPassword){
            $admin->tokens()->delete();
            $token = $admin->createToken($admin->email);
            return [ 
                'name' => $admin->name,
                'email' => $admin->email,
                'token' => $token->plainTextToken
            ];
        }

        return false;

    }
}