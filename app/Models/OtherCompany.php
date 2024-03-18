<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherCompany extends Model
{
    use HasFactory;
    protected $table = 'other_companies';
    // protected $fillable = ['question', 'answer'];
    protected $fillable = [
        'notaris', 
        'badan_hukum', 
        'kedudukan', 
        'no_bn', 
        'no_tbn', 
        'tahun_terbit', 
        'jenis_badan_hukum', 
        'jenis_transaksi', 
        'no_sk', 
        'tanggal_sk', 
        'no_akta', 
        'tanggal_akta'
    ];
}
