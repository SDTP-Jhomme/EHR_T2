<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cbcModel extends Model
{
    use HasFactory;
    protected $table = 'cbc_table';

    protected $fillable = [
        'result',
        'section',
        'student_id',
    ];
    public function user()
{
    return $this->belongsTo(UserModel::class, 'student_id');
}
}
