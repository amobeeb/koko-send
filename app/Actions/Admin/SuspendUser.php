<?php

namespace App\Actions\Admin;

use App\Models\User;

class SuspendUser
{
    public function execute($uuid)
    {
        $status = 0;
        $message = [];

        if(in_array(request()->k, ['active', 'inactive'])){
            if(request()->k == 'active'){
                $status = User::ACTIVE;
            }

            if(request()->k == 'inactive'){
                $status = User::IN_ACTIVE;
            }

            $user = User::where('uuid', $uuid)->first();
            if(!empty($user)){
                $user->is_active = $status;
                $user->save();
                $keyStatus = $status == 0 ? 'suspended' : 'unsuspended';
                $message['success'] =  'user account '.$keyStatus;

                return $message;
            }
            $message["error"] = 'unable to retrieve user details';
            return $message;
        }

        $message['error'] = 'invalid status [active, inactive] required';
        return $message;
    }
}
