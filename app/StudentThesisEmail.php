<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentThesisEmail extends Model
{
    protected  $table = 'student_thesis_email';

    protected $fillable = ['student_id','type','status','term_id'];
}
