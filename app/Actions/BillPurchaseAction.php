<?php

namespace App\Actions;

use App\Helpers\AppHelper;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\Flutterwave\BillPayment;

class BillPurchaseAction
{
    public function execute(array $request)
    {
        $payload = AppHelper::formatBillPaymentPayload($request);

        if (!$this->checkWallet($payload['amount'])) {
            $response['error'] = 'insufficient amount on wallet';
            return $response;
        }

        Transaction::create([
            'reference' => $payload['reference'],
            'user_id' => request()->user()->id,
            'type' => $payload['type'],
            'biller_name' => $payload['biller_name'],
            'amount' => $payload['amount'],
            'package_data' => $payload['package_data'],
            'recurrence' => $payload['recurrence'],
            'country' => $payload['country'],
            'customer' => $payload['customer'],
            'customer_type'  => 'Phone'
        ]);

        $response = BillPayment::purchase($payload);

        if (is_array($response)) {
            if (array_key_exists('error', $response)) {
                return $response;
            }

            if (!$response) {
                $response['error'] = 'error';
                return $response;
            }

            if (array_key_exists('success', $response)) {
                $response['success'] = 'success';
                return $response;
            }
        }
        $response['error'] = 'error';
        return $response;
    }

    public function checkWallet($billAmount): bool
    {
        $wallet = Wallet::whereUserId(request()->user()->id)->first();
        $walletCurrentAmount = $wallet->amount;

        if ($walletCurrentAmount < $billAmount) {
            return false;
        }
        return true;
    }
}
