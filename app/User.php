<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Notifications\MyResetPassword;
use Hash;
use Auth;
use File;
use DB;
use Mail;
use Config;

class User extends Authenticatable
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'avatar',
        'email',
        'password',
        'first_name',
        'middle_name',
        'last_name',
        'dob',
        'gender',
        'phone',
        'address',
        'description',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullName()
    {
        return $this->last_name . ' ' . $this->middle_name . ' ' . $this->first_name;
    }

    public function store($data)
    {
        if (isset($data['avatar']) && $data['avatar'] != '')
            $data['avatar_file'] = $data['avatar'];

        $data['avatar'] = "avatar/NOIMAGE.jpg";
        $password = $data['password'];
        $data['password'] = bcrypt($data['password']);
        $user = $this->create($data);

        if (isset($data['avatar_file'])) {
            $file = array('avatar' => Input::file('avatar_file'));
            $destinationPath = public_path('avatar'); // upload path
            $extension = Input::file('avatar')->getClientOriginalExtension(); // getting image extension
            $filename = $user->username . '-' . Carbon::now()->timestamp . '.' . $extension;
            Input::file('avatar')->move($destinationPath, $filename);
            $user->avatar = "avatar/" . $filename;
            $user->save();
        }


        $user->sendPasswordOnEmail($password);

        return $user;
    }

    public function store_ajax($data)
    {

        $data['avatar'] = "avatar/NOIMAGE.jpg";
        $password = $data['password'];
        $data['password'] = bcrypt($data['password']);
        $user = $this->create($data);

        if (isset($data['avatar_base_64']) && $data['avatar_base_64'] != '') {
            $is_base_64 = strpos($data['avatar_base_64'], 'base64,');
            if (is_numeric($is_base_64)) {
                $data['avatar_base_64'] = substr($data['avatar_base_64'], strpos($data['avatar_base_64'], 'base64,') + 7);
                $image = base64_decode($data['avatar_base_64']);
                $type = getImageMimeType($image);

                $filename = $user->username . '-' . Carbon::now()->timestamp . '.' . $type;

                $user->avatar = "avatar/" . $filename;
                file_put_contents($user->avatar, $image);
                $user->save();

            }
        }

        if (isset($data['role']))
            $user->assignRole($data['role']);

        $user->sendPasswordOnEmail($password);

        return $user;
    }

    public function updateProfile($data)
    {
        if (isset($data['fullName']) && $data['fullName'] != '' && $data['fullName'] != $this->getFullName()) {
            $fullName = analys_name($data['fullName']);
            $data['first_name'] = $fullName['first_name'];
            $data['middle_name'] = $fullName['middle_name'];
            $data['last_name'] = $fullName['last_name'];
        }

        if (isset($data['dob']))
            $data['dob'] = Carbon::parse($data['dob']);

        if (isset($data['avatar']) && $data['avatar'] != '')
            $data['avatar_file'] = $data['avatar'];

        if (isset($data['password']) && $data['password'] != '')
            $data['password'] = bcrypt($data['password']);

        else if ($data['password'] == '')
            unset($data['password']);

        $this->update($data);

        if (isset($data['avatar_file'])) {
            //make avatar
            $file = array('avatar' => Input::file('avatar_file'));
            $destinationPath = public_path('avatar'); // upload path
            $extension = Input::file('avatar')->getClientOriginalExtension(); // getting image extension
            $filename = $this->username . '-' . Carbon::now()->timestamp . '.' . $extension;
            Input::file('avatar')->move($destinationPath, $filename);

            // unlink and delete old avatar
            if (!is_numeric(strpos($this->avatar, "NOIMAGE.jpg")))
                if (file_exists($this->avatar))
                    unlink($this->avatar);

            $this->avatar = "avatar/" . $filename;
            $this->save();
        }

        return $this;
    }

    public function updateProfileAjax($data)
    {

        if (isset($data['fullName']) && $data['fullName'] != '' && $data['fullName'] != $this->getFullName()) {
            $fullName = analys_name($data['fullName']);
            $data['first_name'] = $fullName['first_name'];
            $data['middle_name'] = $fullName['middle_name'];
            $data['last_name'] = $fullName['last_name'];
        }

        if (isset($data['dob']))
            $data['dob'] = Carbon::parse($data['dob']);

        if (isset($data['avatar']) && $data['avatar'] != '')
            $data['avatar_file'] = $data['avatar'];

        if (isset($data['password']) && $data['password'] != '')
            $data['password'] = bcrypt($data['password']);

        else if ($data['password'] == '')
            unset($data['password']);

        $this->update($data);

        if (isset($data['avatar_base_64']) && $data['avatar_base_64'] != '') {
            $is_base_64 = strpos($data['avatar_base_64'], 'base64,');
            if (is_numeric($is_base_64)) {
                $data['avatar_base_64'] = substr($data['avatar_base_64'], strpos($data['avatar_base_64'], 'base64,') + 7);
                $image = base64_decode($data['avatar_base_64']);
                $type = getImageMimeType($image);

                $filename = $this->username . '-' . Carbon::now()->timestamp . '.' . $type;

                // unlink and delete old avatar
                if (!is_numeric(strpos($this->avatar, "NOIMAGE.jpg")))
                    if (file_exists($this->avatar))
                        unlink($this->avatar);

                $this->avatar = "avatar/" . $filename;
                file_put_contents($this->avatar, $image);
                $this->save();

            }
        }


        return $this;
    }

    public function deleteUser()
    {

        // DELETE AVATAR
        if (!is_numeric(strpos($this->avatar, "NOIMAGE.jpg")))
            if (file_exists($this->avatar))
                unlink($this->avatar);

        return $this->delete();
    }

    /*FUNCTIONS SEND EMAIL*/
    public function sendPasswordOnEmail($password = null)
    {
        if (is_null($password)) {
            $password = str_random(6);
            $this->password = bcrypt($password);
        }
        $this->remember_token = str_random(60);
        if ($this->save()) {
            $data = array(
                'fullname' => $this->getFullName(),
                'username' => $this->username,
                'password' => $password,
                'role' => ($this->hasRole('HS') ? 1 : 0),
                'remember_token' => $this->remember_token
            );
            $this->sendEmail($data, $this);

            return true;
        }

        return false;
    }

    public function sendEmail($data, User $user)
    {
        $email = $user->email;

        Mail::send('auth.emails.register', $data, function ($message) use ($email) {
            $message->from(Config::get('mail.username'));
            $message->to($email)->subject('[Thesis]- Đăng ký tài khoản thành công!');
        });
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }


    /* FUNCTION FOR RELATIONSHIP */
    public function roles()
    {
        return $this->belongsToMany(\App\Role::class, 'role_user', 'user_id', 'role_id')->withTimestamps();
    }


    public function fields()
    {
        return $this->belongsToMany(\App\Manager\Field::class, 'teacher_field', 'user_id', 'field_id');
    }

    public function unit()
    {
        return $this->belongsToMany(\App\Manager\Unit::class, 'teacher_unit', 'user_id', 'unit_id');
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('code', $role);
        }

        return !!$role->intersect($this->roles)->count();
    }

    public function assignRole($role)
    {
        return $this->roles()->save(
            Role::whereCode($role)->firstOrFail()
        );
    }

    public function student_cohort()
    {
        return $this->hasOne(\App\StudentCohort::class, 'user_id', 'id');
    }


    /* FUNCTION FOR RELATIONSHIP TEACHERS*/
    public function teacher_topics()
    {
        return $this->belongsToMany(\App\Topic::class, 'teacher_topic', 'user_id', 'topic_id')->withTimestamps();
    }

    public function teacher_fields()
    {
        return $this->belongsToMany(\App\Manager\Field::class, 'teacher_field', 'user_id', 'field_id')->withTimestamps();
    }

    /* FUNCTION FOR RELATIONSHIP STUDENTS*/
    public function topic()
    {
        return $this->hasOne(\App\StudentTopic::class, 'student_id', 'id');
    }
}

