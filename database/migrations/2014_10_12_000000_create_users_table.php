<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('profile_img')->nullable();
            $table->string('f_name');
            $table->string('l_name');
            $table->string('client_id');
            $table->string('phone');
            $table->string('complete_hour');
            $table->string('active_status')->nullable();
            $table->string('time_listened')->nullable();
            $table->string('time_assigned')->nullable();
            $table->string('time_remain')->nullable();
            $table->string('last_day_active')->nullable();
            $table->string('daily_time')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
