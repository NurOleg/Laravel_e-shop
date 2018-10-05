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
            $table->string('duvet');
            $table->string('pillowcase');
            $table->string('sheet');
            $table->string('size');
            $table->integer('price');
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
