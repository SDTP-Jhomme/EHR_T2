<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vaxxModel extends Model
{
    use HasFactory;
    
    protected $table = 'vaccine_table';

    protected $fillable = [
        'age',
        'vaccinationDate',
        'vaccineBatch',
        'healthcareProvider',
        'section',
        'student_id'
    ];
    public function user()
{
    return $this->belongsTo(UserModel::class, 'student_id');
}
}