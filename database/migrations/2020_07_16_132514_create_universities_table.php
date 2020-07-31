<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
            Schema::create('universities', function (Blueprint $table) {
            $table->increments('uni_id');
            $table->string('uni_name',127)->unique();
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
        Schema::dropIfExists('universities');
    }
}
