<?php

namespace App\Helpers;

use App\Models\Country;
use App\Models\WalletTransaction;

class AppHelper
{
    public static function generateOTP(): ?string
    {
        $randomNumber = mt_rand(000000000, 99999999);
        return substr($randomNumber, 0, 6);
    }

    public static function dateInterval($previousTime, $currentTime): string|bool
    {
        if(empty($previousTime)){
            return false;
        }

        $previousTime = new \DateTime($previousTime);
        $currentTime = new \DateTime($currentTime);
        $interval = $previousTime->diff($currentTime);
        $intervalInminutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
        return $intervalInminutes;
    }

    public static function formatFlwIncomingTransaction(array $request)
    {
        $request = $request['data'];
        return [
            'tx_ref' => $request['tx_ref'],
            'flw_ref' => $request['flw_ref'],
            'amount' => $request['amount'],
            'currency' => $request['currency'],
            'charged_amount' => $request['charged_amount'],
            'app_fee' => $request['app_fee'],
            'processor_response' => $request['processor_response'],
            'narration' => $request['narration'],
            'status' => $request['status'],
            'account_id' => $request['account_id'],
            'payment_type' => $request['payment_type'],
            'customer_name' => $request['customer']['name'],
            'customer_phone_number' => $request['customer']['phone_number'],
            'customer_email' => $request['customer']['email']
        ];
    }

    public static function totalWalletTransactionByType($id, $type)
    {
        $total = WalletTransaction::whereHas('user', function($q) use ($id, $type){
            $q->where(['uuid' => $id, 'transaction_type' => $type]);
        })->sum('amount');
        return $total;
    }

    public static function generateTransactionRef(): ?string
    {
        return time().uniqid();
    }

    public static function formatBillPaymentPayload(array $request): array
    {
        return [
            "amount" => $request['amount'],
            "country" => $request['country'],
            "customer" => $request['phone_no'],
            "package_data" => $request['package_data'],
            "recurrence" => $request['recurrence'],
            "type" => $request['type'],
            "biller_name" => $request['type'],
            "reference" => self::generateTransactionRef(),
        ];
    }

    public  static function currentCountry()
    {
        return Country::where('status', true)->first();
    }


}
