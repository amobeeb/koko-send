<?php

namespace App\Actions;

use App\Services\Flutterwave\BillPayment;

class AirtimeCategoryAction
{
    public function execute(): ?array
    {
        return BillPayment::airtimeCategory();
    }

}
