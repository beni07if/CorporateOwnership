<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Group extends Model
{
    use HasFactory;
    use Searchable;
    protected $table = 'groups';
    // protected $fillable = ['question', 'answer'];
    protected $fillable = [
        'idGroup', 
        'group_name', 
        'official_group_name', 
        'group_status', 
        'stock_exchange_name', 
        'controller', 
        'company_overview', 
        'business_sector', 
        'main_product', 
        'incorporation_date', 
        'country_registration', 
        'business_address', 
        'country_operation', 
        'shareholder_name1', 
        'percent_of_share1', 
        'shareholder_name2', 
        'percent_of_share2', 
        'shareholder_name3', 
        'percent_of_share3', 
        'shareholder_name4', 
        'percent_of_share4', 
        'shareholder_name5', 
        'percent_of_share5', 
        'group_structure', 
        'management_name_and_position', 
        'subsidiary_affiliation', 
        'land_area_controlled', 
        'total_planted', 
        'total_smallholders', 
        'total_land_designated_hcv', 
        'annual_ffb_productivity', 
        'annual_productivity_by_rspo_certified', 
        'annual_cpo_productivity', 
        'annual_cpk_productivity', 
        'rspo_member', 
        'cgf_member', 
        'asd_member', 
        'gpnsr_member', 
        'others_mention', 
        'certification', 
        'link_certification', 
        'ndpe_policy', 
        'ndpe_time_bound_plan_implementation', 
        'sustainability_progress_report', 
        'supply_chain_traceability', 
        'grievance_mechanism', 
        'recovery_plan', 
        'data_sources', 
        'last_update' 
    ];
}