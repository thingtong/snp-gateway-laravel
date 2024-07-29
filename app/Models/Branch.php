<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'branch';

    protected $fillable = [
        'name',
        'short_name',
        'description',
        'short_description',
        'address_1',
        'address_2',
        'subdistrict',
        'district',
        'province',
        'name_en',
        'short_name_en',
        'description_en',
        'short_description_en',
        'address_1_en',
        'address_2_en',
        'subdistrict_en',
        'district_en',
        'province_en',
        'postcode',
        'phone_number',
        'email',
        'map_latitude',
        'map_longitude',
        'min_eta',
        'max_eta',
        'opening_hour_slots',
        'is_active',
        'min_order_price',
        'shipping_cost',
        'accept_cash',
        'min_accept_cash',
        'accept_credit',
        'min_accept_credit',
        'accept_bank_transfer',
        'branchcode',
        'branchcontact',
        'branchphone2',
        'branchphone3',
        'branchopendate',
        'branchopen24',
        'branchopen_mon',
        'branchclose_mon',
        'branchopen_tue',
        'branchclose_tue',
        'branchopen_wed',
        'branchclose_wed',
        'branchopen_thu',
        'branchclose_thu',
        'branchopen_fri',
        'branchclose_fri',
        'branchopen_sat',
        'branchclose_sat',
        'branchopen_sun',
        'branchclose_sun',
        'branchmailcc',
        'branchmailbcc',
        'lastactivedate',
        'sortid',
        'createduserid',
        'createdname',
        'createddate',
        'modifieduserid',
        'modifiedname',
        'modifieddate',
        'branchidyum',
        'branchlat',
        'branchlong',
        'branchtierid',
        'branchfranid',
        'orderid',
        'sap_site_code',
        'posserver',
        'branchdomain',
        'posstatus',
        'setupuserid',
        'setupname',
        'setupdate'
    ];
    protected $dates = ['deleted_at'];
}
