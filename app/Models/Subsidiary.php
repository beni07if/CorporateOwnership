<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
    use HasFactory;
    protected $table = 'subsidiaries';
    // protected $fillable = ['id_subsidiary', 'group_id', 'mill_id', 'group_name', 'official_group_name', 'ownerOrcontrollerOrkeypeople', 'group_state', 'stock_exchange', 'country_registration', 'rspo_member', 'ndpe_policy', 'ownership_status', 'shareholder_of_companyOrsubsidiary', 'companyOrsubsidiary_name', 'principal_activities', 'millOrrefineryOrfacility_name', 'estateOrplantation_name', 'status_operation', 'capacity_tphOrtpdOrtpa', 'latitude', 'longitude', 'country_operation', 'provinceOrstate', 'regencyOrcity', 'map_availibility', 'land_title_ha', 'size_by_eq_ha', 'rspo_certified', 'mspo_certified', 'ispo_certified', 'data_source', 'data_update', 'complete_percen', 'noteOrcomment'];
}
