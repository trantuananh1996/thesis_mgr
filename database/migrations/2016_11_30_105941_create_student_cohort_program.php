    <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentCohortProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_cohort_program', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->integer('cohort_id')->unsigned()->index();
            $table->integer('program_id')->unsigned()->index();
            $table->timestamps();
            $table->primary(['user_id', 'cohort_id','program_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_cohort_program');
    }
}
