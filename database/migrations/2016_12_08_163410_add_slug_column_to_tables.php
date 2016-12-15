<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugColumnToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fields',function (Blueprint $table){
            $table->text('slug')->nullable();
        });

        Schema::table('units',function (Blueprint $table){
            $table->text('slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fields',function (Blueprint $table){
            $table->dropColumn('slug');
        });

        Schema::table('units',function (Blueprint $table){
            $table->dropColumn('slug');
        });
    }
}
