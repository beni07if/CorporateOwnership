<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table = 'consolidations';
    // protected $fillable = ['question', 'answer'];
    protected $fillable = [
        'id', 
        'your_name', 
        'institution', 
        'email', 
        'message', 
        'response'
    ];
}
