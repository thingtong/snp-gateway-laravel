<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTaxAddress extends Model
{
    use HasFactory;

    protected $table = 'customer_tax_address';

    protected $fillable = [
        'customer_id',
        'tax_id',
        'is_headoffice',
        'company_name',
        'branch_no',
        'company_address',
        'company_area',
        'company_subdistrict',
        'company_district',
        'company_province',
        'company_postcode',
        'company_phone',
        'is_main',
    ];
}
