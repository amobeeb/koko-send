<?php

namespace App\Http\Controllers;

use App\Actions\VerifyOtpAction;
use App\Http\Requests\VerifyOTPRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OTPController extends Controller
{
    use ApiResponse;
    public function verify(VerifyOTPRequest $request, VerifyOtpAction $verifyOtp)
    {
        $verify = $verifyOtp->execute($request->all());
        if($verify){
            return $this->success(Response::HTTP_OK, 'success', [], "otp verified");
        }
        return $this->error(Response::HTTP_BAD_REQUEST, 'failed', 'otp expired');
    }
}
