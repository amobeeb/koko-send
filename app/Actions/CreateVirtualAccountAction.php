<?php

namespace App\Actions;

use App\Models\User;
use App\Services\Flutterwave\FWResource;
use App\Services\LoggerService;
use Illuminate\Support\Facades\Http;

class CreateVirtualAccountAction
{
    public function execute($user)
    {
        $payload = FWResource::virtualAccountUserData((object)$user);

        try {
            $baseUrl = config('koko.FLW_BASE_URL');
            $response = Http::withHeaders(FWResource::fwHeader())->post("$baseUrl/virtual-account-numbers", $payload);

            $data = json_decode($response->body(), true);
            
            if ($response->successful()) {  
                return $data['data'];
            } else {
                LoggerService::error('Non User', 1, 300, $data['message'] ?? 'Unable to create a virtual account for user', __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            LoggerService::error('Non User', 1, $e->getCode(), json_encode($e->getMessage()), __METHOD__);
            return false;
        }
    }
}
