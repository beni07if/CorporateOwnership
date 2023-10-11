<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consolidation extends Model
{
    use HasFactory;
    protected $table = 'consolidations';
    // protected $fillable = ['question', 'answer'];
    protected $fillable = [
        'user_id', 
        'id_subsidiary', 
        'id_group', 
        'id_mill', 
        'group_type', 
        'group_name', 
        'official_group_name', 
        'owner', 
        'group_status', 
        'stock_exchange', 
        'country_registration', 
        'rspo_member', 
        'other_memberships', //new
        'ndpe_policy', 
        'ownership_status', 
        'subsidiary', 
        'shareholder_subsidiary', 
        'principal_activities', 
        'status_operation', 
        'facilities', 
        'estate', 
        'capacity', 
        'latitude', 
        'longitude', 
        'country_operation', 
        'province', 
        'regency', 
        'map_availability', 
        'land_title', 
        'sizebyeq', 
        'rspo_certified', 
        'other_certification', //new
        // 'mspo_certified', 
        // 'ispo_certified', 
        'data_source', 
        'data_update', 
        'note',
        'complete_percen', 
        'akta' 
    ];
}
