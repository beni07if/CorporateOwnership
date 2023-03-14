<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consolidation extends Model
{
    use HasFactory;
    protected $table = 'consolidations';
    // protected $fillable = ['question', 'answer'];
    protected $fillable = ['user_id', 'id_subsidiary', 'id_group', 'id_mill', 'group_type', 'group_name', 'official_group_name', 'owner', 'group_status', 'stock_exchange', 'country_registration', 'rspo_member', 'ndpe_policy', 'ownership_status', 'shareholder_subsidiary', 'subsidiary', 'principal_activities', 'facilities', 'estate', 'status_operation', 'capacity', 'latitude', 'longitude', 'country_operation', 'province', 'regency', 'map_availability', 'land_title', 'sizebyeq', 'rspo_certified', 'mspo_certified', 'ispo_certified', 'data_source', 'data_update', 'complete_percen', 'akta', 'note'];
}
