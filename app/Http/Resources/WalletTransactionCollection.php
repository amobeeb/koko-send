<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WalletTransactionCollection extends ResourceCollection
{
    public static $wrap = null;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
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
        ];
    }
}
