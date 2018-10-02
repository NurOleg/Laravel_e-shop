<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGoodsSrcImgCloumn extends Migration
{
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('big_img_src');
            $table->renameColumn('src', 'little_img_src');
        });
    }


    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropColumn('big_img_src');
            $table->renameColumn('little_img_src', 'src');
        });
    }
}
