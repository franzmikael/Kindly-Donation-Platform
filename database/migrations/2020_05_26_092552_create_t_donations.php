<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTDonations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_donations', function (Blueprint $table) {
            $table->increments('donation_id');
            $table->unsignedInteger('submisi_id');
            $table->unsignedInteger('user_id');
            $table->foreign('submisi_id')->references('submisi_id')->on('t_submissions')->onDelete('cascade');
            $table->string('donation_name', 255);
            $table->string('donation_mail', 255);
            $table->string('donation_phone', 255);
            $table->integer('donation_nominal');
            $table->boolean('donation_is_anonymous');
            $table->string('payment_type', 255);
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
        Schema::dropIfExists('t_donations');
    }
}
