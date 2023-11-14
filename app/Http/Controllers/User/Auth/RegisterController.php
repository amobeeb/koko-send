<?php

namespace App\Http\Controllers\User\Auth;

use App\Actions\CreateVirtualAccountAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    use ApiResponse;
    public function __invoke(Request $request, CreateVirtualAccountAction $createVirtualAccount)
    {  
        $createAccount = $createVirtualAccount->execute($request->all());
        if ($createAccount == false) {
            return $this->error(Response::HTTP_BAD_REQUEST, 'failed', 'user virtual account creation failed, delete user record');
        } else {
            $request = $request->all();
            $request['password'] = bcrypt($request['password']);
            
            $user = User::create($request);
            $user->wallet()->create([
                'bank_name' => $createAccount['bank_name'], 
                'account_number' => $createAccount['account_number'],
                'flw_ref' => $createAccount['flw_ref'],
                'flw_order_ref' => $createAccount['order_ref'],
                'flw_account_status' => $createAccount['account_status']
            ]);

            Mail::to($user)->send(new WelcomeMail($user));

            return $this->success(Response::HTTP_OK, [], "user account created");
        }
    }
}
