<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fecaModel extends Model
{
    use HasFactory;
    protected $table = 'fecalysis_table';

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
