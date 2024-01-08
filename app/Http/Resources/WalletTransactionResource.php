<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->uuid,
            'amount' => $this->amount,
            'transaction_type' => $this->transaction_type,
            'flw_tx_ref' => $this->flw_tx_ref,
            'flw_response' => $this->flw_response,
            'flw_status' => $this->flw_status,
            'flw_currency' => $this->flw_currency,
            'flw_app_fee' => $this->flw_app_fee,
            'flw_payment_type' => $this->flw_payment_type,
            'flw_account_id' => $this->flw_account_id,
            'created_date' => $this->created_at,
            'wallet' => [
                "bank_name"=> $this->wallet->bank_name,
                "account_number"=>  $this->wallet->account_number,
            ],
            'user' => [
                "uuid" => $this->user->uuid,
                "first_name"=> $this->user->first_name,
                "last_name"=> $this->user->last_name,
                "username"=> $this->user->username,
                "phone_number"=> $this->user->phone_number,
            ]


        ];
    }
}
