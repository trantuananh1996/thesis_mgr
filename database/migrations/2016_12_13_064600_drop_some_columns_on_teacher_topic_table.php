<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropSomeColumnsOnTeacherTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teacher_topic', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('created_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teacher_topic', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('created_user_id');
        });
    }
}
