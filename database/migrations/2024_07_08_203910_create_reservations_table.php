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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('reservasi_date');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('baby_spa_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('baby_spa_id')->references('id')->on('baby_spas');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('reservation_id')->after('customer_id');
            $table->foreign('reservation_id')->references('id')->on('reservations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
