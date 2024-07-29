<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_orders', function (Blueprint $table) {
           
            $table->increments('ordno'); // ใช้ increments สำหรับ auto-increment
            $table->dateTime('orddate');
            $table->integer('custid');
            $table->integer('addressid');
            $table->string('branchid', 200);
            $table->string('subzone', 20);
            $table->integer('riderid');
            $table->string('contacttel', 100);
            $table->string('contactname', 100);
            $table->string('custfname', 100);
            $table->string('custlname', 100);
            $table->text('ordremark');
            $table->string('orderstatus', 5);
            $table->dateTime('orderconfirmdate')->nullable();
            $table->dateTime('orderstartdate')->nullable();
            $table->dateTime('orderestimatedate')->nullable();
            $table->dateTime('orderacknowdate')->nullable();
            $table->dateTime('ordercookingdate')->nullable();
            $table->dateTime('orderdeliverydate')->nullable();
            $table->dateTime('orderreceivedate')->nullable();
            $table->dateTime('ordercompletedate')->nullable();
            $table->integer('promisetime')->nullable();
            $table->float('preamount')->nullable();
            $table->float('amount')->nullable();
            $table->integer('cashtend')->nullable();
            $table->integer('discountamount')->nullable();
            $table->string('cancelstatus', 1)->nullable();
            $table->string('cancelreason', 500)->nullable();
            $table->integer('printstatus')->nullable();
            $table->dateTime('printdate')->nullable();
            $table->integer('lateid')->nullable();
            $table->string('latename', 50)->nullable();
            $table->integer('referorderno')->nullable();
            $table->string('channelcode', 5)->nullable();
            $table->string('channelname', 200)->nullable();
            $table->string('bigorderstatus', 1)->nullable();
            $table->integer('taxid')->nullable();
            $table->integer('gisid')->nullable();
            $table->string('paymentchannelcode', 50)->nullable();
            $table->string('paymentchannel', 50)->nullable();
            $table->integer('discountrate')->nullable();
            $table->string('orderstatusapi', 5)->nullable();
            $table->string('orderwssuccess', 5)->nullable();
            $table->dateTime('orderwssuccessdate')->nullable();
            $table->string('ordnoapi', 50)->nullable();
            $table->integer('firstcreateduserid')->nullable();
            $table->string('firstcreatedname', 500)->nullable();
            $table->dateTime('firstcreateddatetime')->nullable();
            $table->text('jsonstring')->nullable();
            $table->string('wsresult', 500)->nullable();
            $table->text('wsrequest1')->nullable();
            $table->text('wsrequest2')->nullable();
            $table->text('wsrequest3')->nullable();
            $table->text('wsrequest4')->nullable();
            $table->text('wsrequest5')->nullable();
            $table->integer('createduserid')->nullable();
            $table->string('createdname', 500)->nullable();
            $table->dateTime('createddate')->nullable();
            $table->integer('modifieduserid')->nullable();
            $table->string('modifiedname', 500)->nullable();
            $table->dateTime('modifieddate')->nullable();
            $table->string('orderbrno', 100)->nullable();
            $table->integer('paymentlinkid')->nullable();
            $table->string('paymentstatus', 1)->nullable();
            $table->dateTime('paymentdate')->nullable();
            $table->string('paymentrefcode', 500)->nullable();
            $table->string('paymentslip', 1000)->nullable();
            $table->string('paymentbankinfo', 1000)->nullable();
            $table->string('orderchannelcode', 1)->nullable();
            $table->string('orderchanelname', 100)->nullable();
            $table->float('totalcustdiscount')->nullable();
            $table->float('totalpromodiscount')->nullable();
            $table->float('totaldiscountkeyin')->nullable();
            $table->string('ordermode', 1)->nullable();
            $table->string('posstatus', 1)->nullable();
            $table->integer('posattemp')->nullable();
            $table->string('delistatus', 1)->nullable();
            $table->string('completestatus', 1)->nullable();
            $table->string('cancelreasonother', 500)->nullable();
            $table->string('cancelcodename', 100)->nullable();
            $table->integer('referorderid')->nullable();
            $table->string('orderidpos', 100)->nullable();
            $table->string('map_lattitude', 100)->nullable();
            $table->string('map_longtitude', 100)->nullable();
            $table->string('cardno', 30)->nullable();
            $table->string('chargeno', 255)->nullable();
            $table->string('paymentremark', 200)->nullable();
            $table->integer('cancelcreateuserid')->nullable();
            $table->string('cancelcreatename', 200)->nullable();
            $table->dateTime('canceldate')->nullable();
            $table->string('cancelrealstatus', 1)->nullable();
            $table->string('ordertypestatus', 1)->nullable();
            $table->string('ordermailstatus', 1)->nullable();
            $table->integer('ordermailattemp')->nullable();
            $table->string('ordercompletemanual', 1)->nullable();
            $table->string('cartordermode', 1)->nullable();
            $table->string('indexcartid', 20)->nullable();
            $table->integer('orderfirstview')->nullable();
            $table->integer('orderfirstview')->nullable();
            $table->string('orderapprove', 1)->default('Y');
            $table->string('mudjaimemberid', 50)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
