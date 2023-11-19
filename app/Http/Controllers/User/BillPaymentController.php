<?php

namespace App\Http\Controllers\User;

use App\Actions\AirtimeCategoryAction;
use App\Actions\DataPlansAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;
use App\Models\User;
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


}
