<?php
namespace App\Services\Flutterwave;

use App\Services\LoggerService;
use Illuminate\Support\Facades\Http;

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
        foreach($data as $_data){
            if($_data['is_airtime'] == true && $_data['country'] == $country && $_data['biller_name'] == $bill ){
                $airtime[] = $_data;
            }
        }
        return $airtime;
    }

    public static function filterNigeriaDataPlans($data, $country = 'NG', $bill_code): array
    {
        $airtime = [];
        foreach($data as $_data){
            if($_data['is_airtime'] == false && $_data['country'] == $country && $_data['biller_code'] == $bill_code ){
                $airtime[] = $_data;
            }
        }
        return $airtime;
    }
}
