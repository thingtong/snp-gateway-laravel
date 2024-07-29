<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $table = 'z_shopping_cart_cms';

    protected $primaryKey = 'shoppingcartid';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        "shoppingcartid",
        //'custid',
        //'is_member',
        //'order_mode',
        'refmainid',
        'item_no',
        'item_id',
        'item_code',
        'item_name',
        'item_remark',
        'item_qty',
        'item_unitprice',
        'item_indexset',
        'item_mainid',
        'item_maincode',
        'createddate',
        'modifieddate',
        'item_setid',
        'item_productgroupid',
        'item_productgroupname'
    ];

    protected $casts = [
        'createddate' => 'datetime',
        'modifieddate' => 'datetime',
    ];
}
