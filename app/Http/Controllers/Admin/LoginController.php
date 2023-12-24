<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
       return (new LoginAction)->execute($request->all());
    }
}
