<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('review_id');
            $table->integer('dorm_id')->unsigned();
            $table->foreign('dorm_id')->references('dorm_id')->on('dorms');

            //5 star ratings
            $table->tinyInteger('room');
            $table->tinyInteger('building');
            $table->tinyInteger('location');
            $table->tinyInteger('bathroom');
            $table->tinyInteger('staff');

            $table->boolean('is_recommended');
            $table->enum('year_of_study', ['first', 'second', 'third','fourth','postgraduate']);	
            $table->enum('year_of_residence', ['2015','2016','2017','2018','2019','2020','2021','2022','2023','2024','2025','2026','2027','2028','2029','2030']);	
            $table->enum('room_type', ['single', 'double', 'shared','studio','other']);	
            
            $table->set('amenities',['common_area', 'games','outdoor_area','elevator','communal_kitchen','catering','private_bathroom','prayer_room', 'resident_events','mature_students_only']);
            
            $table->string('quirk', 50);

            $table->string('review_text', 400);

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
        Schema::dropIfExists('reviews');
    }
}
