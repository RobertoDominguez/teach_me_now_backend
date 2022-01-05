<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class University extends Model
{
    // use HasFactory,SoftDeletes;
    use HasFactory;

    protected $fillable=[
        'acronym',
        'name',
        'image',
        'description',
        
    ];
}