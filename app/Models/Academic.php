<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

class Academic extends Model
{
    use HasFactory;

    protected $fillable=[
        'school_id',
        'subject_id',
    ];

}
