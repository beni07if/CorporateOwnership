<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Landingpage extends Model
{
    use HasFactory;
    protected $table = 'landingpages';
    // protected $fillable = ['question', 'answer'];
    protected $fillable = [
        'id', 
        'tagline', 
        'title_short_definition', 
        'short_definition',
        'title_of_data1',
        'number_of_data1',
        'tag_of_data1',
        'title_of_data2',
        'number_of_data2',
        'tag_of_data2',
        'title_of_data3',
        'number_of_data3',
        'tag_of_data3',

        'title_corporate_profile',
        'definition_corporate_profile',
        'image_corporate_profile',

        'key_feature_title1',
        'key_feature_desc1',
        'key_feature_image1',
        'key_feature_title2',
        'key_feature_desc2',
        'key_feature_image2',
        'key_feature_title3',
        'key_feature_desc3',
        'key_feature_image3',
        'key_feature_title4',
        'key_feature_desc4',
        'key_feature_image4'
    ];
}