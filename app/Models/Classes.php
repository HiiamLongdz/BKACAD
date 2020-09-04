<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';

    protected $fillable = ['class_name', 'course_id', 'major_id'];

    protected $keyType = 'string';

    public function students()
    {
        return $this->hasMany(\App\Models\Student::class, 'classes_id');
    }

    public function majors()
    {
        return $this->belongsTo(\App\Models\Major::class, 'classes_id');
    }

    public function courses()
    {
        return $this->belongsTo(\App\Models\Course::class, 'classes_id');
    }
}
