<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacherModel extends Model
{
    use HasFactory;
    protected $table = 'teacher_data';
    protected $fillable = [
        'email',
        'firstname',
        'midname',
        'lastname',
        'gender',
        'phone_number',
        'birthdate',
        'status',
        'password',
        'avatar',
        'last_login'
    ];
}
