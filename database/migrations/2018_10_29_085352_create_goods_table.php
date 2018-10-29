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
            $table->unsignedInteger('api_id');
            $table->string('name');
            $table->boolean('active')->default(1);
            $table->boolean('sales')->default(0);
            $table->boolean('hits')->default(0);
            $table->boolean('featured')->default(0);
            $table->unsignedInteger('category_id');
            $table->string('brand')->nullable();
            $table->string('base_color')->nullable();
            $table->string('filler')->nullable();
            $table->string('textile')->nullable();
            $table->string('count_color')->nullable();
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
