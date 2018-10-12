<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableColumnsSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sku', function (Blueprint $table) {
            $table->string('duvet')->nullable()->change();
            $table->string('pillowcase')->nullable()->change();
            $table->string('sheet')->nullable()->change();
//            $table->string('size');
//            $table->integer('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
