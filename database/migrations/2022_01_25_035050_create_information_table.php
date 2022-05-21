<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->string('identifier', 199)->nullable();
            $table->string('action', 199)->nullable();
            $table->text('challenge')->nullable();
            $table->text('address')->nullable();
            $table->mediumText('phone')->nullable();
            $table->text('food_type')->nullable();
            $table->text('description')->nullable();
            $table->mediumText('website')->nullable();
            $table->string('star_rating', 199)->nullable();
            $table->string('google_ratings', 199)->nullable();

            $table->string('age_restricted', 199)->nullable();
            $table->mediumText('business_name')->nullable();
            $table->mediumText('city')->nullable();
            $table->string('state', 199)->nullable();
            $table->string('zip_code', 199)->nullable();
            $table->string('country', 199)->nullable();
            $table->string('start_date', 199)->nullable();
            $table->string('end_date', 199)->nullable();
            $table->mediumText('geo_tag')->nullable();
            $table->mediumText('geo_link', 199)->nullable();
            $table->text('other_address_note', 199)->nullable();
            $table->string('length', 199)->nullable();
            $table->string('elevation_gain', 199)->nullable();
            $table->mediumText('main_pic', 199)->nullable();
            $table->mediumText('social_media')->nullable();
            $table->mediumText('main_video', 199)->nullable();
            $table->string('badge_award_one', 199)->nullable();
            $table->string('badge_award_two', 199)->nullable();
            $table->string('badge_award_three', 199)->nullable();
            $table->string('badge_award_four', 199)->nullable();
            $table->string('badge_award_five', 199)->nullable();
            $table->string('state_ranking_elevation', 199)->nullable();
            $table->string('world_ranking_elevation', 199)->nullable();
            $table->string('state_ranking_prominence', 199)->nullable();
            $table->string('usa_ranking_elevation', 199)->nullable();
            $table->string('usa_ranking_prominence', 199)->nullable();
            $table->mediumText('facebook_link', 199)->nullable();
            $table->mediumText('secondary_video', 199)->nullable();
            $table->mediumText('instagram_link', 199)->nullable();
            $table->mediumText('difficult_level', 199)->nullable();
            $table->mediumText('picture_one', 199)->nullable();
            $table->mediumText('picture_two', 199)->nullable();
            $table->mediumText('picture_three', 199)->nullable();
            $table->string('tower_height', 199)->nullable();
            $table->string('focal_point', 199)->nullable();

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
        Schema::dropIfExists('information');
    }
}
