<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_user', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('user_name', 255);
            $table->string('user_mail', 255);
            $table->string('user_phone', 255);
            $table->string('user_foto', 255);
            $table->string('user_password', 255);
            $table->boolean('user_is_admin');
            $table->boolean('user_is_active');
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
        Schema::dropIfExists('m_user');
    }
}
