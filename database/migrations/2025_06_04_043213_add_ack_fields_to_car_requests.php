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
        Schema::table('car_requests', function (Blueprint $table) {
            $table->enum('acknowledgement_status', ['none', 'accepted', 'rejected'])->default('none');
            $table->text('acknowledgement_reason')->nullable();
            $table->timestamp('acknowledged_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_requests', function (Blueprint $table) {
            //
        });
    }
};
