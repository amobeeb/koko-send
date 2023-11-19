<?php

namespace App\Actions;

use App\Helpers\AppHelper;
use App\Models\User;
use App\Models\WalletTransaction;

class IncomingTransactionWebhookAction
{
    public function execute($request)
    {
        $incomingTransaction = AppHelper::formatFlwIncomingTransaction($request);
        $user = User::whereEmail($incomingTransaction['customer_email'])->first();
        $checkTransaction = WalletTransaction::where('flw_ref', $incomingTransaction['flw_ref'])->first();
        if (empty($checkTransaction)) {
            WalletTransaction::create([
                'user_id' => $user->id,
                'wallet_id' => $user->wallet->id,
                'amount' => $incomingTransaction['amount'],
                'transaction_type' => 'credit',
                'flw_tx_ref' => $incomingTransaction['tx_ref'],
                'flw_ref' => $incomingTransaction['flw_ref'],
                'flw_response' => $incomingTransaction['processor_response'],
                'flw_status' => $incomingTransaction['status'],
                'flw_currency' => $incomingTransaction['currency'],
                'flw_app_fee' => $incomingTransaction['app_fee'],
                'flw_payment_type' => $incomingTransaction['payment_type'],
                'flw_account_id' => $incomingTransaction['account_id'],
            ]);
            $user->wallet->increment('amount', $incomingTransaction['amount']);
        }

    }
}
