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
Schema::create('car_usages', function (Blueprint $table) {
    $table->id();
    $table->integer('sequence')->nullable();
    $table->date('date');
    $table->time('time');
    $table->string('user_name');
    $table->string('destination');
    $table->decimal('start_mileage', 10, 2);
    $table->decimal('end_mileage', 10, 2);
    $table->decimal('total_distance', 10, 2);
    $table->string('driver_name');
    $table->date('return_date');
    $table->time('return_time');
    $table->text('notes')->nullable();
    $table->timestamps();


});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_usages');
    }
};
