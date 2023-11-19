<?php

namespace App\Actions;

use App\Services\Flutterwave\BillPayment;

class DataPlansAction
{
    public function execute($id): ?array
    {
        return BillPayment::dataPlans($id);
    }

}
