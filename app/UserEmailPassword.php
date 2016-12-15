<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEmailPassword extends Model
{

    protected $table = 'user_email_password';

    protected $fillable = ['user_id', 'password', 'status'];
}
