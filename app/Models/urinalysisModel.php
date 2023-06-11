<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class urinalysisModel extends Model
{
    use HasFactory;
    protected $table = 'urinalysis_table';

    protected $fillable = [
        'age',
        'requestDate',
        'color',
        'transparency',
        'gravity',
        'ph',
        'sugar',
        'protein',
        'pregnancy',
        'pus',
        'rbc',
        'cast',
        'urates',
        'uric',
        'cal',
        'epith',
        'mucus',
        'otherOthers',
        'pathologist',
        'technologist',
        'student_id',
        'section',
    ];
    public function user()
{
    return $this->belongsTo(UserModel::class, 'student_id');
}
}
