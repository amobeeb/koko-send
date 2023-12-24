<?php
namespace App\Actions;

use App\Helpers\AppHelper;
use App\Models\User;
use Illuminate\Support\Facades\File;

class UploadPicture 
{
    public function execute($request)
    {
        $message = [];
        $user = User::find(request()->user()->id);
        if (!empty($user)) { 
            File::delete(dirname(__FILE__, 5) . "/public/profile_picture/" . $user->picture);
            $file = $request->file('image');
            $fileName = AppHelper::generateFileName($file);
            $request->file('image')->storeAs("public/profile_picture", $fileName);
        }
        $user->photo = env('APP_URL')."/storage/profile_picture/".$fileName;
        $user->save(); 
        $message['success'] = "profile picture saved successfully";
        return $message;

    }
}