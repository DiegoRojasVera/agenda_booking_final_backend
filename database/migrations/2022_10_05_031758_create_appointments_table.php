<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dated_at');
            $table->dateTime('finish_at');
            $table->double('total', 12, 2);
            $table->integer('duration')->comment('Duración del servicio en minutos');
            $table->unsignedBigInteger('client_id');
            $table->string('email');
          //  $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->unsignedBigInteger('service_id');
         //   $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
            $table->unsignedBigInteger('stylist_id');
        //    $table->foreign('stylist_id')->references('id')->on('stylists')->onDelete('set null');
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
        Schema::dropIfExists('appointments');
    }
}
