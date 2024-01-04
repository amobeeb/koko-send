<?php

namespace App\Actions\Admin;

use App\Models\User;

class SoftDeletesUser
{
    public function execute($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        $user->delete();
        return true;
    }

    public function restored($uuid)
    {
        User::where('uuid', $uuid)->restore();
        return true;
    }

    public function list()
    {
        return User::onlyTrashed()->get();
    }
}


