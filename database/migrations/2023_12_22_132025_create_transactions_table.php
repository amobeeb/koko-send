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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->index();
            $table->foreignIdFor(User::class);
            $table->text('type');
            $table->text('biller_name');
            $table->decimal('amount', 8, 2)->default(0.0);
            $table->string('package_data'); 
            $table->string('recurrence')->default('ONCE');  
            $table->string('country')->default('NG');
            $table->string('customer');
            $table->string('customer_type')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('is_reversal')->default(false);
            $table->text('errors')->nullable(); 
            $table->timestamps();
            $table->softDeletes(); 
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
