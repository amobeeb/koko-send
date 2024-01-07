<?php

namespace App\Actions;

use App\Services\Flutterwave\BillPayment;

class ElectricityPlanAction
{
    public function execute(): ?array
    {
        return BillPayment::electricityCategory();
    }
}
