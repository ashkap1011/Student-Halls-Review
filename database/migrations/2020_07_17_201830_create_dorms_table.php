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
            $table->float('overall_rating', 6, 5);
            $table->smallInteger('reviews_count');
            $table->boolean('has_common_area');
            $table->boolean('has_catering');
            $table->boolean('has_games');
            $table->boolean('has_outdoor_area');
            $table->boolean('has_elevator');
            $table->boolean('has_communal_kitchen');
            $table->boolean('has_private_bathroom');
            $table->boolean('has_social_events');
            $table->boolean('has_mature_students_only');
            $table->string('address',127);
            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);         
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
