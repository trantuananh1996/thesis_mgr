<?php

namespace App\Manager;

use App\Manager\Field;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{

    use Sluggable, SluggableScopeHelpers;

    protected $fillable = ['code', 'name', 'description', 'created_user_id', 'modified_user_id'];

    public function fields()
    {
        return $this->hasMany(Field::class, 'unit_id');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function teachers()
    {
        return $this->belongsToMany(\App\User::class, 'teacher_unit', 'unit_id', 'user_id');
    }
}
