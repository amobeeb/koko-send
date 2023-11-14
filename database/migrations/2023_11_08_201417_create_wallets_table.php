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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignIdFor(User::class);
            $table->string('bank_name'); 
            $table->string('account_number')->unique();
            $table->double('amount', 8, 2)->default(0.00);
            $table->string('flw_ref')->nullable();
            $table->string('flw_order_ref')->nullable();
            $table->string('flw_account_status')->nullable();
            $table->timestamps();
        });
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
