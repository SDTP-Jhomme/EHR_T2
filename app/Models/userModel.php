<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userModel extends Model
{
    use HasFactory;
    protected $table = 'client_info';
    protected $fillable = [
        'identification',
        'firstname',
        'midname',
        'lastname',
        'password',
        'birthdate',
        'gender',
        'avatar',
        'year',
        'course',
        'civil',
        'citizen',
        'street',
        'brgy',
        'city',
        'section',
        'phone_number'
    ];
    public function cbc()
    {
        return $this->hasMany(cbcModel::class, 'student_id');
    }
    public function urinalysis()
    {
        return $this->hasMany(urinalysisModel::class, 'student_id');
    }
    public function xray()
    {
        return $this->hasMany(xrayModel::class, 'student_id');
    }
    public function antigen()
    {
        return $this->hasMany(antigenModel::class, 'student_id');
    }
}
