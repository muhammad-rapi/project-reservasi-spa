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
            $table->id('id');
            $table->string('role');
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('phone_number', 13);
            $table->string('password');
            $table->string('address')->nullable();
            $table->boolean('is_active')->default(true);
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
