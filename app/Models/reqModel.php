<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reqModel extends Model
{
    use HasFactory;
    protected $table = 'request_table';
    protected $fillable = [
        'request_date',
        'med_status',
        'section',
        'student_id'
    ];
}
