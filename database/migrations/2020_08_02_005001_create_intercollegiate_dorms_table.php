<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntercollegiateDormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intercollegiate_dorms', function (Blueprint $table) {
            $table->integer('dorm_id')->unsigned();
            $table->foreign('dorm_id')->references('dorm_id')->on('dorms')->onDelete('cascade');
            $table->json('uni_id_set');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intercollegiate_dorms');
    }
}
