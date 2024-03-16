<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sra extends Model
{
    use HasFactory;

    protected $table = 'sras';
    // protected $fillable = ['question', 'answer'];
    protected $fillable = [
        'idGroup', 
        'group_name', 
        'transparency', 
        'percent_transparency', 
        'rspo_compliance', 
        'percent_rspo_compliance', 
        'ndpe_compliance', 
        'percent_ndpe_compliance', 
        'total', 
        'percent_total' 
    ];
}
