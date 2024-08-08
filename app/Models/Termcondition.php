<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termcondition extends Model
{
    use HasFactory;
    protected $table = 'termconditions';
    // protected $fillable = ['question', 'answer'];
    protected $fillable = [
        'id', 
        'title', 
        'description',
        'agreement',
        'description2'
    ];
}