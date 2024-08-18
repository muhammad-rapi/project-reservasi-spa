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
        Schema::table('baby_spas', function (Blueprint $table) {
            $table->string('jenis')->after('spa_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baby_spas', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });
    }
};
