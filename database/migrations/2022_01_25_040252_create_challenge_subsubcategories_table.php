<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengeSubsubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_subsubcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('information_id')->references('id')->on('information')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('challenge_category_id')->references('id')->on('challenge_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('challenge_subcategory_id')->references('id')->on('challeng_subcategories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sub_subcategory_id');
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
        Schema::dropIfExists('challenge_subsubcategories');
    }
}
