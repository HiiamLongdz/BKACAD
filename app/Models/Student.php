<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'fullname', 'dob', 'gender', 'phone', 'email', 'password', 'status', 'classes_id'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $keyType = 'string';


    public function classes()
    {
        return $this->belongsTo(\App\Models\Classes::class);
    }

}
