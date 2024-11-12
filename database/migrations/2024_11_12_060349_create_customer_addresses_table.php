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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('type', 45);
            $table->string('address', 45);
            $table->string('city', 255);
            $table->string('province', 255);
            $table->string('zipcode', 45);
            $table->string('country_code', 3);
            $table->foreignId('customer_id')->references('id')->on('customers');
            $table->foreignId('country_code')->references('code')->on('countries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
