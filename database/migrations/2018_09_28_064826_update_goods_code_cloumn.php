<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGoodsCodeCloumn extends Migration
{
    public function up()
    {
        Schema::table('goods', function(Blueprint $table) {
            $table->renameColumn('code', 'slug');
        });
    }


    public function down()
    {
        Schema::table('categories', function(Blueprint $table) {
            $table->renameColumn('slug', 'code');
        });
    }
}
