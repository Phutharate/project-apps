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
        Schema::table('personal_car_requests', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('name'); // ✅ เพิ่มหลัง name
        });
    }

    public function down(): void
    {
        Schema::table('personal_car_requests', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
};
