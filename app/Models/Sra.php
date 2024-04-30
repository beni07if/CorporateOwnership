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
        'percent_total',

        'transparency_upstream',
        'transparency_sustainability',
        'transparency_refiners',
        'transparency_publish',
        'transparency_website',
        'rspo_registration',
        'rspo_certification_progress',
        'rspo_percent',
        'rspo_complaints',
        'ndpe_adopted',
        'ndpe_deforestation',
        'ndpe_peatland',
        'ndpe_burn_area',
        'ndpe_land_protection',
        'ndpe_restoration'
    ];
}
