<?php

namespace App\Actions;

use App\Helpers\AppHelper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VerifyOtpAction
{
    public function execute(array $request): bool
    {
        $user = User::whereEmail($request['email'])->first();

        #check otp expiration
        $timeInterval = AppHelper::dateInterval($user->otp_at, now());
        if(!$timeInterval || $timeInterval > 30){
           return false;
        }else {
            $checkOtp = Hash::check($request['otp'], $user->otp);
            if($checkOtp){
               return true;
            }
        }



    }
}
