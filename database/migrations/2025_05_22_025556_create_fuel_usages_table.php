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
        
    Schema::create('fuel_usages', function (Blueprint $table) {
    $table->id();
    $table->date('date');
    $table->string('license_plate');
    $table->string('fuel_order_number')->nullable();
    $table->integer('amount_spent');
    $table->string('receipt_number')->nullable();
    $table->integer('start_km');
    $table->integer('end_km');
    $table->integer('distance');
    $table->decimal('fuel_liters', 8, 2);
    $table->decimal('amount_baht', 8, 2);
    $table->string('issued_by')->nullable();
    $table->string('receiver')->nullable();
    $table->text('remark')->nullable();
    $table->timestamps();

    
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_usages');
    }
};
