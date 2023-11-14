<?php
namespace App\Services\Flutterwave;

class FWResource
{
    public static function virtualAccountUserData($user): array
    {
        return [
            "email" => $user->email,
            "bvn" => $user->bvn,
            "firstname" => $user->first_name,
            "lastname" => $user->last_name,
            "phonenumber" => $user->phone_number,
            "narration" => "account creation for{$user->first_name} {$user->last_name}",
            "is_permanent" => true,
            "tx_ref" => uniqid()
        ];
    }

    public static function fwHeader(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.config('koko.FLW_SECRET_KEY')
        ];
    }
}
