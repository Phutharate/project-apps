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
        Schema::create('personal_car_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // ชื่อผู้ขอ
            $table->string('position')->nullable(); // ตำแหน่ง
            $table->string('department')->nullable(); // แผนก
            $table->string('car_brand')->nullable(); // ยี่ห้อรถ
            $table->string('car_registration')->nullable(); // ทะเบียนรถ
            $table->integer('seats')->nullable();   // จำนวนที่นั่ง
            $table->text('destination');            // สถานที่ไป
            $table->string('province')->nullable(); // จังหวัด
            $table->text('purpose');                // วัตถุประสงค์
            $table->dateTime('start_time');         // เริ่มเดินทาง
            $table->dateTime('end_time');           // สิ้นสุด
            $table->text('reason')->nullable();     // เหตุผลเพิ่มเติม
            $table->string('attachment')->nullable(); // ไฟล์แนบ
            $table->timestamps();                   // created_at / updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_car_requests');
    }
};
