<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'menu';

    protected $fillable = [
        'type','name','description','name_en','description_en','sku',
        'image','price','before_sale_price','is_schedule_pricing',
        'schedule_price','schedule_before_sale_price','schedule_start_at','schedule_end_at',
        'is_pickup','is_delivery','open_channel','is_for_combo_only',
        'is_open_customer_note','is_preorder','min_preorder_days','cart_limit',
        'is_active','active_start_at','active_end_at','priority',
        'productcode','productpnucode','productname','productgroupid',
        'productgroupname','productprice','sortid','changeinsetflag',
        'flagshow','productmainid','productmainname','discountautoflag',
        'createduserid','createddate','modifieduserid','modifieddate',
        'createdname','modifiedname','setqty','productsideprice',
        'flagcustdiscount','flagsetcustdiscount','setqtyuse','itemtype',
        'possend','pricediscount', 'pricediscountflag','pricediscounttrue',
    ];
}
