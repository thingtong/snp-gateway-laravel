<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $table = 'customer_address';

    protected $fillable = [
        'customer_id','type',
        'address_label','building_name','room_number', 'floor_number','address1','address2','province',
        'district','subdistrict','city','postcode','is_verified','latitude','longitude', 'directions',
        'area_id','geolocation_source','formatted','distance','note','name', 'phone_number','is_main',
        'branchmain1', 'branchmain1name', 'branchsub1','branchsub1name','createduserid',
        'createdname','createddate','modifieduserid','modifiedname','modifieddate',
    ];
}
