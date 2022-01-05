<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teach extends Model
{
    use HasFactory;

    protected $fillable=[
        'level',
        'teacher_id',
        'subject_id'
    ];

}
