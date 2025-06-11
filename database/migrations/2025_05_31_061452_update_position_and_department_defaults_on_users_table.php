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
        Schema::table('users', function (Blueprint $table) {
            $table->string('position', 500)->nullable()->default(null)->change();
            $table->string('department', 500)->nullable()->default(null)->change();
        });
    }


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('position', 255)->nullable()->default(null)->change();
            $table->string('department', 255)->nullable()->default(null)->change();
        });
    }
};
