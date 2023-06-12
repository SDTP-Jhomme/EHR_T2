<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nurseModel extends Model
{
    use HasFactory;
    protected $table = 'nurse_data';
    protected $fillable = [
        'identification',
        'firstname',
        'midname',
        'lastname',
        'gender',
        'phone_number',
        'birthdate',
        'street',
        'brgy',
        'city',
        'status',
        'password',
        'avatar',
        'last_login'
    ];
}
