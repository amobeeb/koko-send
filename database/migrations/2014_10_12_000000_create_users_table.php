<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->index();
            $table->string('phone_number');
            $table->string('bvn')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('pin')->nullable();
            $table->string('photo')->nullable();
            $table->string('tx_ref')->nullable();
            $table->string('narration')->nullable();
            $table->string('otp')->nullable();
            $table->boolean('is_active')->default(true);

            $table->index('is_active');
            $table->index('phone_number');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
