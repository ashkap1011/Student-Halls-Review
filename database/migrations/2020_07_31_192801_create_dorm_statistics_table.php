<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDormStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dorm_statistics', function (Blueprint $table) {
            $table->integer('dorm_id')->unsigned();
            $table->foreign('dorm_id')->references('dorm_id')->on('dorms')->onDelete('cascade')->unique();
            $table->tinyInteger('average_rating');
            $table->smallInteger('reviews_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dorm_statistics');
    }
}
