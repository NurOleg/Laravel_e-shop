<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sku', function (Blueprint $table) {
//            $table->primary('unique_article');
            $table->increments('id');
            $table->unsignedInteger('api_id');
            $table->string('duvet')->nullable();
            $table->string('pillowcase')->nullable();
            $table->string('sheet')->nullable();
            $table->string('size')->nullable();
            $table->integer('price');
            $table->integer('count');
            $table->string('article')->references('article')->on('goods');
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
        Schema::dropIfExists('sku');
    }
}
