<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'amount' => $this->amount,
            'flw_ref' => $this->flw_ref,
            'flw_account_status' => $this->flw_account_status,
            'created_at' => $this->created_at,
        ];
    }
}
