<?php

namespace App\Actions;

use App\Helpers\AppHelper;
use App\Mail\ForgetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordAction
{
    public function execute($request)
    {
        $user = User::whereEmail($request['email'])->first();
        if(!empty($user)) {
            $otp = AppHelper::generateOTP();

            User::whereEmail($request['email'])->update([
                'otp' => bcrypt($otp),
                'otp_at' => now()
            ]);

            Mail::to($user)->send(new ForgetPasswordMail($user, $otp));
            return true;
        }
        return false;
    }
}
