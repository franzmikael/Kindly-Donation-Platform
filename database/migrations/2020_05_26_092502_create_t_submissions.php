<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTSubmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_submissions', function (Blueprint $table) {
            $table->increments('submisi_id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('m_user')->onDelete('cascade');
            $table->string('submisi_judul', 255);
            $table->text('submisi_penerima');
            $table->text('submisi_cerita');
            $table->string('submisi_phone', 255);
            $table->string('submisi_tipe', 255);
            $table->integer('submisi_target');
            $table->integer('submisi_terkumpul');
            $table->string('submisi_foto', 255);
            $table->boolean('submisi_is_active');
            $table->date('submisi_expired_at');
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
        Schema::dropIfExists('t_submissions');
    }
}
