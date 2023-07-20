<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceStylistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_stylist', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
         //   $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
            $table->unsignedBigInteger('stylist_id');
         //   $table->foreign('stylist_id')->references('id')->on('stylists')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_stylist');
    }
}

