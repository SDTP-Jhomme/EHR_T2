<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fecaModel extends Model
{
    use HasFactory;
    protected $table = 'fecalysis_table';

    protected $fillable = [
        'age',
        'requestBy',
        'requestDate',
        'color',
        'consistency',
        'occult',
        'otherOccult',
        'pus',
        'rbc',
        'fat',
        'ova',
        'larva',
        'adult',
        'cyst',
        'trophozoites',
        'otherTrophozoites',
        'remarks',
        'pathologist',
        'technologist',
        'section',
        'student_id',
    ];
    public function user()
{
    return $this->belongsTo(UserModel::class, 'student_id');
}
}
