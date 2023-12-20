<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserPinAction
{
    public function newPin($request)
    { 
        
        $message = [];
        $user = User::whereUuid($request->user()->uuid)->first(); 
      
        if($request->newPin != $request->confirmPin){
            $message['error'] =  'pin not matched';
            return $message;
        }
        
        if(!empty($user)){
            $user->update([
                'pin' => Hash::make($request->newPin)
            ]);
            $message['success'] =  'pin saved successfully';
            return $message;
        }
        return false;
    }

    public function changePin($request)
    {  
        $message = [];
        $user = User::whereUuid($request->user()->uuid)->first(); 

         
        if(!Hash::check($request->oldPin, $user->pin)){
            $message['error'] =  'unable to verify old pin';
        } 
         
        if(!empty($user)){
            $user->update([
                'pin' => Hash::make($request->new_pin)
            ]);
            $message['success'] =  'pin updated successfully';
            return $message;
        }
        return false;
    }
    
}
