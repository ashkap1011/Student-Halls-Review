<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dorms', function (Blueprint $table) {
            $table->increments('dorm_id');
            $table->integer('uni_id')->unsigned();
            $table->foreign('uni_id')->references('uni_id')->on('universities')->onDelete('cascade');           
            $table->string('dorm_name', 127)->unique();
            $table->float('overall_rating', 3, 2);
            
            $table->json('overall_star_ratings');
            
            $table->smallInteger('reviews_count');
            $table->json('has_amenities');
            
            $table->json('amenities_count');    //counts the number of each amenitiy based on reviews
            $table->string('address',127);
            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);  
            $table->tinyInteger('walking_mins_to_uni');      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dorms');
    }
}
