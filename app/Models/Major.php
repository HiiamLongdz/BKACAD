<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $table = 'majors';

    protected $keyType = 'string';

    protected $fillable = ['id', 'major_name'];

    public function courses(){
        return $this->belongsToMany(\App\Models\Course::class, 'course_major');
    }

    public function subjects(){
        return $this->belongsToMany(\App\Models\Subject::class, 'major_subject');
    }

    public function classes(){
        return $this->hasMany(\App\Models\Classes::class);
    }
}
