<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('driver_assignment_tracker', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('last_driver_id')->nullable();
            $table->timestamps();
        });

        // Insert default row
        DB::table('driver_assignment_tracker')->insert([
            'last_driver_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('driver_assignment_tracker');
    }
};
