<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(\App\Models\Wallet::class);
            $table->double('amount', 8, 2)->default(0.00);
            $table->string('transaction_type');
            $table->string('flw_tx_ref')->nullable();
            $table->string('flw_ref')->nullable();
            $table->string('flw_response')->nullable();
            $table->string('flw_status')->nullable();
            $table->string('flw_currency')->nullable();
            $table->string('flw_app_fee')->nullable();
            $table->string('flw_payment_type')->nullable();
            $table->string('flw_account_id')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'transaction_type']);
            $table->index('flw_tx_ref');
        });
    }
//
//
//"event": "charge.completed",
//"data": {
//"id": 1142109797,
//"tx_ref": "6552e0fd6f686",
//"flw_ref": "000004231118164118198640657609",
//"device_fingerprint": "N/A",
//"amount": 10,
//"currency": "NGN",
//"charged_amount": 10,
//"app_fee": 0.14,
//"merchant_fee": 0,
//"processor_response": "received successfully",
//"auth_model": "AUTH",
//"ip": "::ffff:172.16.9.135",
//"narration": "account creation forWale Adewale",
//"status": "successful",
//"payment_type": "bank_transfer",
//"created_at": "2023-11-18T15:40:41.000Z",
//"account_id": 1882620,
//"customer": {
//"id": 718442743,
//"name": "Wale Adewale",
//"phone_number": "081292910",
//"email": "amobeeb1net@gmail.com",
//"created_at": "2023-11-14T02:02:02.000Z"
//}
//  },
//  "event.type": "BANK_TRANSFER_TRANSACTION"
//}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
