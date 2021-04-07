<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTWithdraw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_withdraw', function (Blueprint $table) {
            $table->increments('withdraw_id');
            $table->unsignedInteger('submisi_id');
            $table->foreign('submisi_id')->references('submisi_id')->on('t_submissions')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('m_user')->onDelete('cascade');
            $table->integer('withdraw_nominal');
            $table->integer('withdraw_bank_number');
            $table->boolean('withdraw_is_approved');
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
        Schema::dropIfExists('t_withdraw');
    }
}
