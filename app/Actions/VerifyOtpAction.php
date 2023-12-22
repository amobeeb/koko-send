<?php

namespace App\Actions;

use App\Helpers\AppHelper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VerifyOtpAction
{
    public function execute(array $request): ?array
    {
        $message = [];
        $user = User::whereEmail($request['email'])->first();

        #check otp expiration
        $timeInterval = AppHelper::dateInterval($user->otp_at, now());
        if(!$timeInterval || $timeInterval > 30){
            $message['error'] = 'OTP expired'; 
        }else {
            $checkOtp = Hash::check($request['otp'], $user->otp);
            if($checkOtp){
                $message['success'] = 'OTP verification successful'; 
            } else {
                $message['error'] = 'Invalid OTP'; 
            }
        }
        return $message;


    }
}
