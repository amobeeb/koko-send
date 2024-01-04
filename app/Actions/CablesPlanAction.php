<?php

namespace App\Actions;

use App\Services\Flutterwave\BillPayment;

class CablesPlanAction
{
    public function execute(): ?array
    {
         
        return BillPayment::cableCategory();
    }

}
