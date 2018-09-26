<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCategoriesNameColumn extends Migration
{
    public function up()
    {
        Schema::table('categories', function(Blueprint $table) {
            $table->renameColumn('category_name', 'name');
        });
    }


    public function down()
    {
        Schema::table('categories', function(Blueprint $table) {
            $table->renameColumn('name', 'category_name');
        });
    }
}
