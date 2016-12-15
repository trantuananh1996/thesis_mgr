<?php

namespace App\Manager;

use App\Manager\Unit;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{

    use Sluggable, SluggableScopeHelpers;

    protected $fillable = ['code', 'name', 'unit_id', 'description', 'created_user_id', 'modified_user_id'];

    protected $table = 'fields';

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
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
        return $this->belongsToMany(\App\User::class, 'teacher_field', 'field_id', 'user_id');
    }

    public function topics()
    {
        return $this->hasMany(\App\Topic::class, 'field_id');
    }
}
