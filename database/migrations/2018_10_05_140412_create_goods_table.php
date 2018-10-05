<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->string('article')->primary();
//            $table->increments('id');
            $table->unsignedInteger('api_id');
            $table->string('name');
            $table->boolean('active')->default(1);
            $table->unsignedInteger('category_id');
            $table->string('img_src');
            $table->unsignedInteger('brand');
            $table->unsignedInteger('base_color');
            $table->unsignedInteger('filler');
            $table->unsignedInteger('textile');
//            $table->foreign('article')->references('article')->on('sku');
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
        Schema::dropIfExists('goods');
    }
}
