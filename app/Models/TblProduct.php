<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblProduct extends Model
{
    use HasFactory;
    protected $table = 'tbl_product';

    protected $primaryKey = 'productrun';

    public $timestamps = false; // ถ้ามี timestamps
    
    protected $fillable = [
        'productid','productcode','productpnucode','productname',
        'productnameeng','productdescription','productgroupid','productgroupname',
        'productprice','productstatus','productsettype','sortid','branchtier',
        'startdate','enddate','containerurl','changeinsetflag','prodsubgroupid',
        'start_mon','end_mon','start_tue','end_tue','start_wed','end_wed',
        'start_thu','end_thu','start_fri','end_fri','start_sat','end_sat',
        'start_sun','end_sun','flagshow','groupsetmode','productmainid',
        'productmainname','discountautoflag','createduserid','createddate',
        'modifieduserid','modifieddate','createdname','modifiedname','setqty',
        'productsideprice','flagcustdiscount','flagsetcustdiscount','setqtyuse',
        'itemtype','possend','pricediscount', 'pricediscountflag','pricediscounttrue'
    ];
}
