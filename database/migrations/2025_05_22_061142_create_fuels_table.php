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
            Schema::create('fuels', function (Blueprint $table) {
                $table->id();
                $table->date('date');
                $table->string('fuel_order_number')->nullable();
                $table->string('receipt_number')->nullable();
                $table->string('license_plate')->nullable();
                $table->integer('start_km')->nullable();
                $table->integer('distance')->nullable();
                $table->decimal('fuel_liters', 8, 2)->nullable();
                $table->decimal('amount_spent', 10, 2)->nullable();
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
        Schema::dropIfExists('fuels');
    }
};
