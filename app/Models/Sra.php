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

        'nr_transparency_upstream',
        'note_transparency_upstream',
        'nr_transparency_sustainability',
        'note_transparency_sustainability',
        'nr_transparency_refiners',
        'note_transparency_refiners',
        'nr_transparency_publish_maps',
        'note_transparency_publish_maps',
        'nr_transparency_concessions',
        'note_transparency_concessions',
        'nr_transparency_website',
        'note_transparency_website',
        'nr_rspo_registration',
        'note_rspo_registration',
        'nr_rspo_certification_progress',
        'note_rspo_certification_progress',
        'nr_rspo_percent_plantations',
        'note_rspo_percent_plantations',
        'nr_rspo_complaints',
        'note_rspo_complaints',
        'nr_ndpe_policy_adopted',
        'note_ndpe_policy_adopted',
        'nr_ndpe_social_issues',
        'note_ndpe_social_issues',
        'nr_ndpe_deforestation',
        'note_ndpe_deforestation',
        'nr_ndpe_peatland_development',
        'note_ndpe_peatland_development',
        'nr_ndpe_burn_areas',
        'note_ndpe_burn_areas',
        'nr_ndpe_land_protection',
        'note_ndpe_land_protection',
        'nr_ndpe_restoration_in_peatland',
        'note_ndpe_restoration_in_peatland',
        'nr_hcvhsc_assessment',
        'note_hcvhsc_assessment',
        'total_scoring'
    ];
}