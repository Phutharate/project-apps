<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('prefix')->nullable();
            $table->string('first_name')->after('prefix');
            $table->string('last_name')->after('first_name');
            $table->string('gender')->after('last_name');
            $table->string('position')->after('gender');
            $table->string('user_group')->after('position');
            $table->timestamp('registered_at')->nullable()->after('user_group');
        });
    }
    
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'prefix', 'first_name', 'last_name',
                'gender', 'position', 'user_group', 'registered_at'
            ]);
        });
    }
    
};
