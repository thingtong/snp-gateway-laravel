<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
  
    protected $table = 'tbl_order_detail';
    protected $primaryKey = 'orderdetailid';
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = [];
    protected $fillable = [
        'orderdetailid',
        'ordno',
        'productid',
        'productname',
        'productcode',
        'ordermenuremark',
        'productgroupid',
        'productgroupname',
        'qty',
        'unitprice',
        'tierid',
        'ordremark',
        'indexset',
        'sortsetid',
        'posid',
        'prodmainid',
        'layerid',
        'modgroup',
        'submodgroup',
        'productrun',
        'setflag',
        'createduserid',
        'createdname',
        'createddate',
        'modifieduserid',
        'modifiedname',
        'modifieddate',
    ];

    
}
