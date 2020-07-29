<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_test', function (Blueprint $table) {
            
            
                $table->id();
                $table->string('name');
                $table->string('address');
                $table->float('lat', 10, 6);
                $table->float('lng', 10, 6);
                $table->string('type');
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
        Schema::dropIfExists('map_test');
    }
}
