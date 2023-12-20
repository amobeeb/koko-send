<?php

namespace App\Actions;

use App\Helpers\AppHelper;
use App\Services\Flutterwave\BillPayment;

class BillPurchaseAction
{
    public function execute(array $request)
    {
        $payload = AppHelper::formatBillPaymentPayload($request);
        $response = BillPayment::purchase($payload);

        if(array_key_exists('error', $response)){
            return $response;
        }

        if(!$response){
            $response['error'] = 'error';
            return $response;
        }

        if (array_key_exists('success', $response)){
           $response['success'] = 'success';
           return $response;
        }

    }

}
