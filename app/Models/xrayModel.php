<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class xrayModel extends Model
{
    use HasFactory;
    protected $table = 'xray_table';

    protected $fillable = [
        'age',
        'case_No',
        'referred_by',
        'room_bed',
        'clinical_impression',
        'type_examination',
        'section',
        'student_id'
    ];
    public function user()
{
    return $this->belongsTo(UserModel::class, 'student_id');
}
}
