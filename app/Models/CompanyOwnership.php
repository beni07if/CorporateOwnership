<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyOwnership extends Model
{
    use HasFactory;
    protected $table = 'company_ownerships';
    // protected $fillable = ['question', 'answer'];
    protected $fillable = [
        'idCompany', 
        'company_name', 
        'company_type', 
        'incorporation_date', 
        'company_number', 
        'date_company_number', 
        'change_company_number', 
        'date_change_company_number', 
        'taxpayer_identification_number', 
        'registered_address', 
        'country_of_registered_address', 
        'business_address', 
        'country_of_business_address', 
        'nature_of_business', 
        'shareholder_name', 
        'date_of_birth', 
        'ic_passport_comp_number', 
        'address', 
        'position', 
        'number_of_shares', 
        'total_of_shares', 
        'percentage_of_shares', 
        'currency', 
        'data_source', 
        'data_update', 
        'pic' 
    ];
}
