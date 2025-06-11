<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('car_requests', function (Blueprint $table) {
            $table->string('purpose')->nullable(); // เพื่อไปทำอะไร
            $table->unsignedBigInteger('car_id')->nullable(); // รถ (อ้างอิงตาราง cars ถ้ามี)
            $table->dateTime('meeting_datetime')->nullable(); // วันเวลาที่ประชุม
            $table->string('car_request_time')->nullable(); // เวลาที่ขอรถ (เก็บเป็น string หรือปรับให้เหมาะสม)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_requests', function (Blueprint $table) {
            $table->dropColumn(['purpose', 'car_id', 'meeting_datetime', 'car_request_time']);
        });
    }
};
