<?php

namespace App\Services\Flutterwave;

use App\Helpers\AppHelper;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Services\LoggerService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BillPayment
{

    public static function airtimeCategory()
    {
        try {
            $baseUrl = config('koko.FLW_BASE_URL');
            $response = Http::withHeaders(FWResource::fwHeader())->get("$baseUrl/bill-categories");
            $data = json_decode($response->body(), true);

            if ($response->successful()) {
                $data = $data['data'];
                $airtime = self::filterNigeriaAirtime($data, 'NG', 'AIRTIME');
                return $airtime;
            } else {
                LoggerService::error('Non User', 1, 300, $data['message'] ?? 'unable to get network category', __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            LoggerService::error(request()->user()->id, 1, $e->getCode(), json_encode($e->getMessage()), __METHOD__);
            return false;
        }
    }

    public static function electricityCategory()
    {
        try {
            $baseUrl = config('koko.FLW_BASE_URL');
            $response = Http::withHeaders(FWResource::fwHeader())->get("$baseUrl/bill-categories");
            $data = json_decode($response->body(), true);

            if ($response->successful()) {
                $data = $data['data'];
                $airtime = self::filterNigeriaElecticity($data, 'NG');
                return $airtime;
            } else {
                LoggerService::error('Non User', 1, 300, $data['message'] ?? 'unable to get network category', __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            LoggerService::error(request()->user()->id, 1, $e->getCode(), json_encode($e->getMessage()), __METHOD__);
            return false;
        }
    }


    public static function cableCategory()
    {
        try {
            $baseUrl = config('koko.FLW_BASE_URL');
            $response = Http::withHeaders(FWResource::fwHeader())->get("$baseUrl/bill-categories");
            $data = json_decode($response->body(), true);

            if ($response->successful()) {
                $data = $data['data'];
                $dataPlan = self::filterNCablePlans($data, 'NG');
                return $dataPlan;
            } else {
                LoggerService::error('Non User', 1, 300, $data['message'] ?? 'unable to get network category', __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            LoggerService::error(request()->user()->id, 1, $e->getCode(), json_encode($e->getMessage()), __METHOD__);
            return false;
        }
    }

    public static function dataPlans($dataId)
    {
        try {
            $baseUrl = config('koko.FLW_BASE_URL');
            $response = Http::withHeaders(FWResource::fwHeader())->get("$baseUrl/bill-categories");
            $data = json_decode($response->body(), true);

            if ($response->successful()) {
                $data = $data['data'];
                $dataPlan = self::filterNigeriaDataPlans($data, 'NG', $dataId);
                return $dataPlan;
            } else {
                LoggerService::error('Non User', 1, 300, $data['message'] ?? 'unable to get network category', __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            LoggerService::error(request()->user()->id, 1, $e->getCode(), json_encode($e->getMessage()), __METHOD__);
            return false;
        }
    }

    public static function dataPlanCategory()
    {
        return [
            'BIL108' => 'MTN Data Bundles',
            'BIL109' => 'GLO Data Bundles',
            'BIL110' => 'Airtel Data Bundles',
            'BIL111' => '9Mobile Data Bundles',
        ];
    }


    public static function filterNigeriaAirtime($data, $country = 'NG', $bill = 'AIRTIME'): array
    {
        $airtime = [];
        foreach ($data as $_data) {
            if ($_data['is_airtime'] == true && $_data['country'] == $country && $_data['biller_name'] == $bill) {
                $airtime[] = $_data;
            }
        }
        return $airtime;
    }

    public static function filterNigeriaDataPlans($data, $country = 'NG', $bill_code): array
    {
        $airtime = [];
        foreach ($data as $_data) {
            if ($_data['is_airtime'] == false && $_data['country'] == $country && $_data['biller_code'] == $bill_code) {
                $airtime[] = $_data;
            }
        }
        return $airtime;
    }

    public static function filterNCablePlans($data, $country = 'NG'): array
    {
        $airtime = [];
         foreach ($data as $_data) {
             if ($_data['is_airtime'] == false && $_data['country'] == $country && $_data['label_name'] == 'SmartCard Number') {
                 $airtime[] = $_data;
             }
         }
        return $airtime;
    }

    public static function filterNigeriaElecticity($data, $country = 'NG'): array
    {
        $airtime = [];
        foreach ($data as $_data) {
            if ($_data['is_airtime'] == false && $_data['country'] == $country && $_data['label_name'] == 'Meter Number') {
                $airtime[] = $_data;
            }
        }
        return $airtime;
    }



    public static function purchase(array $payload)
    {
        try {
            $baseUrl = config('koko.FLW_BASE_URL');

            $response = Http::withHeaders(FWResource::fwHeader())->post("$baseUrl/bills", $payload);
            $data = json_decode($response->body(), true);

            if ($response->successful()) {
                Transaction::whereReference($payload['reference'])->update([
                    'status' => true
                ]);

                (new self)->debitWallet($payload, $data);

                $data['success'] = 'success';

                return $data;
            } else {
                LoggerService::error('User', optional(request()->user())->id ?? '', 300, $data['message'] ?? 'unable to get network category', __METHOD__);
                $data['error'] = $data['message'];
                Transaction::whereReference($payload['reference'])->update([
                    'errors' => $data['message']
                ]);
                return $data;
            }
        } catch (\Exception $e) {
            LoggerService::error(request()->user()->id, request()->user()->id, 400, json_encode($e->getMessage()), __METHOD__);
            return false;
        }
    }

    private function debitWallet($payload, $data): void
    {
        $wallet = Wallet::whereUserId(request()->user()->id)->first();
        $wallet->decrement('amount', $payload['amount']);
        $wallet->save();
        $wallet->refresh();
        //save log
        WalletTransaction::create([
            'user_id' => request()->user()->id,
            'wallet_id' => $wallet->id,
            'amount' => $payload['amount'],
            'transaction_type' => 'debit',
            'flw_currency' => (AppHelper::currentCountry())->currency,
            'flw_tx_ref' => optional($data['data'])['reference'],
            'flw_ref' => optional($data['data'])['flw_ref'],
            'flw_response' => optional($data)['message']
        ]);
    }
}
