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
            $table->string('driver_phone')->nullable()->after('driver');
        });
    }

    public function down()
    {
        Schema::table('car_requests', function (Blueprint $table) {
            $table->dropColumn('driver_phone');
        });
    }
};
