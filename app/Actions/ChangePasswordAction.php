<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    public function execute($id, $request)
    {
        $message = [];
        $user = User::whereUuid($id)->first();

        if (empty($user)) {
            $message['error'] = 'user not found';
        }

        if ($request['current_password'] == $request['password']) {
            $message['error'] = 'new password matched current password';
            return $message;
        }

        if (!empty($user)) {
            $checkCurrentPassword = Hash::check($request['current_password'], $user->password);
            if ($checkCurrentPassword) {
                User::whereId($user->id)->update([
                    'password' => bcrypt($request['password'])
                ]);
                $message['success'] = 'password changed';
            }
            return $message;
        }

    }
}
