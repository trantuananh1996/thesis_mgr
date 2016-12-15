<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreaeteStudentTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_topic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->index();
            $table->integer('current_topic_id')->index()->default(0);
            $table->integer('register_topic_id')->index()->default(0);
            $table->tinyInteger('status')->default(0)->comment('0: chưa đăng ký; 1: đăng ký, đợi phản hồi; 2: được bảo vệ; 3: Bảo vệ thành công');
            $table->tinyInteger('can_register')->default(1)->comment('1: được đăng ký; 0: không được đăng ký');
            $table->double('point')->default(0);
            $table->integer('teacher_id')->index()->default(0);
            $table->tinyInteger('teacher_accepted')->default(0)->comment('0: giảng viên chưa xác nhận,1: Giảng viên cho phép');
            $table->integer('reviewer_id')->inde()->default(0);
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
        Schema::dropIfExists('student_topic');
    }
}
