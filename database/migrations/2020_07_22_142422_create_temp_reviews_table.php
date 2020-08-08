<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_reviews', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_new_uni');
            $table->string('uni_name',100)->nullable();
            $table->string('dorm_name',100)->nullable();

            $table->integer('dorm_id')->nullable()->unsigned();
            $table->foreign('dorm_id')->references('dorm_id')->on('dorms')->onDelete('cascade');

         //5 star ratings
            $table->tinyInteger('room_rating');
            $table->tinyInteger('building_rating');
            $table->tinyInteger('location_rating');
            $table->tinyInteger('bathroom_rating');
            $table->tinyInteger('staff_rating');

            $table->boolean('is_recommended');
            $table->enum('year_of_study', ['first', 'second', 'third','fourth','postgraduate']);	
            $table->enum('year_of_residence', ['2015','2016','2017','2018','2019','2020','2021','2022','2023','2024','2025','2026','2027','2028','2029','2030']);	
            $table->enum('room_type', ['single', 'double', 'shared','studio','other']);	
         
            $table->boolean('is_catered');
            $table->tinyInteger('catered_or_selfcatered_rating');

            $table->set('amenities',config('constants.options.amenities'))->nullable();
         
            $table->string('quirk', 50)->nullable();

            $table->string('review_text', 400)->nullable();
            /**if the user inputs a new uni there will also be a new dorm hence two locations */
            $table->string('uni_address',100)->nullable();
            $table->float('uni_lat', 10, 6)->nullable();
            $table->float('uni_lng', 10, 6)->nullable();

            $table->string('dorm_address',100)->nullable();
            $table->float('dorm_lat', 10, 6)->nullable();
            $table->float('dorm_lng', 10, 6)->nullable();

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
        Schema::dropIfExists('temp_reviews');
    }
}
