<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table = 'messages';
    // protected $fillable = ['question', 'answer'];
    protected $fillable = [
        'id', 
        'name', 
        'phone', 
        'email', 
        'institution', 
        'message', 
        'date_message', 
        'response', 
        'date_response',
        'status'
    ];
}
