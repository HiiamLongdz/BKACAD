<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $table = 'assignments';
    protected $fillable = ['class_id', 'subject_id', 'lecturer_id'];
    protected $keyType = 'string';
}
