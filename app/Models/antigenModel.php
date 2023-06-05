<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class antigenModel extends Model
{
    use HasFactory;
    protected $table = 'antigen_table';

    protected $fillable = [
        'age',
        'sampleDate',
        'result',
        'section',
        'student_id',
    ];
    public function user()
{
    return $this->belongsTo(UserModel::class, 'student_id');
}
}
