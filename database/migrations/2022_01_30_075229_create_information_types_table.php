<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('information_id')->references('id')->on('information')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_id')->references('id')->on('types')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('information_types');
    }
}
