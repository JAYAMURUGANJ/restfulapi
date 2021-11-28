<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('mobile_number')->after('remember_token')->nullable();
            $table->text('device_name')->after('mobile_number')->nullable();
            $table->text('avatar')->after('device_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('mobile_number');
            $table->dropColumn('device_name');
            $table->dropColumn('avatar');
    
        });
    }
}
