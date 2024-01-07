<?php

namespace App\Http\Controllers\User;

use App\Actions\AirtimeCategoryAction;
use App\Actions\BillPurchaseAction;
use App\Actions\CablesPlanAction;
use App\Actions\DataPlansAction;
use App\Actions\ElectricityPlanAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CablePurchaseRequest;
use App\Http\Requests\DataPurchaseRequest;
use App\Http\Requests\ElectricityPurchaseRequest;
use App\Services\Flutterwave\BillPayment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BillPaymentController extends Controller
{
    use ApiResponse;
    public function airtimeCategory(AirtimeCategoryAction $airtime)
    {
        $airtime = $airtime->execute();
        if ($airtime) {
            return $this->success(Response::HTTP_OK, 'success', $airtime, 'retrieved airtime category');
        } else {
            return $this->error(Response::HTTP_OK, 'failed', 'unable to retrieved airtime category');
        }
    }

    public function cables(CablesPlanAction $cable)
    {
        $cable = $cable->execute();
        if ($cable) {
            return $this->success(Response::HTTP_OK, 'success', $cable, 'retrieved cable category');
        } else {
            return $this->error(Response::HTTP_OK, 'failed', 'unable to retrieved cable category');
        }
    }

    public function electricity(ElectricityPlanAction $electricity)
    {
        $electricity = $electricity->execute();
        if ($electricity) {
            return $this->success(Response::HTTP_OK, 'success', $electricity, 'retrieved electricity category');
        } else {
            return $this->error(Response::HTTP_OK, 'failed', 'unable to retrieved electricity category');
        }
    }

    public function dataPlans(Request $request, DataPlansAction $dataPlan)
    {
        $request = request()->search;

        $dataPlan = $dataPlan->execute($request);
        if ($dataPlan) {
            return $this->success(Response::HTTP_OK, 'success', $dataPlan, 'retrieved data plan');
        } else {
            return $this->error(Response::HTTP_OK, 'failed', 'unable to retrieved data plan');
        }
    }

    public function dataPlansCategory()
    {
        return $this->success(Response::HTTP_OK, 'success', BillPayment::dataPlanCategory(), 'retrieved data plan category');
    }

    public function purchase(DataPurchaseRequest $request, BillPurchaseAction $billPurchase)
    {
        $response = $billPurchase->execute($request->all());

        if(isset($response['error'])){
            return $this->error(Response::HTTP_OK, 'failed', $response['error']);
        }

        if(isset($response['success'])){
            return $this->success(Response::HTTP_OK, 'success', $response['data'], $response['message']);
        }

    }

    public function purchaseCable(CablePurchaseRequest $request, BillPurchaseAction $billPurchase)
    {
        $response = $billPurchase->cablePurchase($request->all());

        if(isset($response['error'])){
            return $this->error(Response::HTTP_OK, 'failed', $response['error']);
        }

        if(isset($response['success'])){
            return $this->success(Response::HTTP_OK, 'success', $response['data'], $response['message']);
        }
    }

    public function purchaseElectricity(ElectricityPurchaseRequest $request, BillPurchaseAction $billPurchase)
    {
        $response = $billPurchase->electricityPurchase($request->all());

        if(isset($response['error'])){
            return $this->error(Response::HTTP_OK, 'failed', $response['error']);
        }

        if(isset($response['success'])){
            return $this->success(Response::HTTP_OK, 'success', $response['data'], $response['message']);
        }
    }







}
