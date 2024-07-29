<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'tbl_orders';
    protected $primaryKey = 'ordno';
    public $incrementing = true;
    public $timestamps = false;
    protected $guarded = [];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'ordno', 'ordno');
    }
    protected $fillable = [
        'ordno','orddate', 'custid', 'addressid', 'branchid', 'subzone', 'riderid',
        'contacttel', 'contactname', 'custfname', 'custlname', 'ordremark',
        'orderstatus', 'orderconfirmdate', 'orderstartdate', 'orderestimatedate',
        'orderacknowdate', 'ordercookingdate', 'orderdeliverydate',
        'orderreceivedate', 'ordercompletedate', 'promisetime', 'preamount',
        'amount', 'cashtend', 'discountamount', 'cancelstatus', 'cancelreason',
        'printstatus', 'printdate', 'lateid', 'latename', 'referorderno',
        'channelcode', 'channelname', 'bigorderstatus', 'taxid', 'gisid',
        'paymentchannelcode', 'paymentchannel', 'discountrate',
        'orderstatusapi', 'orderwssuccess', 'orderwssuccessdate', 'ordnoapi',
        'firstcreateduserid', 'firstcreatedname', 'firstcreateddatetime',
        'jsonstring', 'wsresult', 'wsrequest1', 'wsrequest2', 'wsrequest3',
        'wsrequest4', 'wsrequest5', 'createduserid', 'createdname',
        'createddate', 'modifieduserid', 'modifiedname', 'modifieddate',
        'orderbrno', 'paymentlinkid', 'paymentstatus', 'paymentdate',
        'paymentrefcode', 'paymentslip', 'paymentbankinfo', 'orderchannelcode',
        'orderchanelname', 'totalcustdiscount', 'totalpromodiscount',
        'totaldiscountkeyin', 'ordermode', 'posstatus', 'posattemp',
        'delistatus', 'completestatus', 'cancelreasonother', 'cancelcodename',
        'referorderid', 'orderidpos', 'map_lattitude', 'map_longtitude',
        'cardno', 'chargeno', 'paymentremark', 'cancelcreateuserid',
        'cancelcreatename', 'canceldate', 'cancelrealstatus', 'ordertypestatus',
        'ordermailstatus', 'ordermailattemp', 'ordercompletemanual',
        'cartordermode', 'indexcartid', 'orderfirstview','orderapprove','mudjaimemberid'
    ];
    
}
