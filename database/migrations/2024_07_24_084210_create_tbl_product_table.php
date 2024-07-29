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
        Schema::create('tbl_product', function (Blueprint $table) {
            $table->increments('productrun');
            $table->string('productid', 200);
            $table->string('productcode', 200);
            $table->string('productpnucode', 200);
            $table->string('productname', 500);
            $table->string('productnameeng', 500);
            $table->string('productdescription', 1000);
            $table->integer('productgroupid');
            $table->string('productgroupname', 50);
            $table->integer('productprice');
            $table->string('productstatus', 1);
            $table->string('productsettype', 5);
            $table->integer('sortid');
            $table->string('branchtier', 100);
            $table->date('startdate');
            $table->date('enddate')->nullable();
            $table->string('containerurl', 500)->nullable();
            $table->string('changeinsetflag', 1);
            $table->integer('prodsubgroupid')->nullable();
            $table->string('start_mon', 20)->nullable();
            $table->string('end_mon', 20)->nullable();
            $table->string('start_tue', 20)->nullable();
            $table->string('end_tue', 20)->nullable();
            $table->string('start_wed', 20)->nullable();
            $table->string('end_wed', 20)->nullable();
            $table->string('start_thu', 20)->nullable();
            $table->string('end_thu', 20)->nullable();
            $table->string('start_fri', 20)->nullable();
            $table->string('end_fri', 20)->nullable();
            $table->string('start_sat', 20)->nullable();
            $table->string('end_sat', 20)->nullable();
            $table->string('start_sun', 20)->nullable();
            $table->string('end_sun', 20)->nullable();
            $table->string('flagshow', 1)->nullable();
            $table->string('groupsetmode', 1)->nullable();
            $table->string('productmainid', 200)->nullable();
            $table->string('productmainname', 200)->nullable();
            $table->string('discountautoflag', 1)->nullable();
            $table->integer('createduserid')->nullable();
            $table->date('createddate')->nullable();
            $table->integer('modifieduserid')->nullable();
            $table->date('modifieddate')->nullable();
            $table->string('createdname', 50)->nullable();
            $table->string('modifiedname', 50)->nullable();
            $table->integer('setqty')->nullable();
            $table->integer('productsideprice')->nullable();
            $table->string('flagcustdiscount', 1)->nullable();
            $table->string('flagsetcustdiscount', 1)->nullable();
            $table->integer('setqtyuse')->nullable();
            $table->string('itemtype', 5)->nullable();
            $table->string('possend', 1)->nullable();
            $table->integer('pricediscount')->nullable();
            $table->string('pricediscountflag', 1)->nullable();
            $table->integer('pricediscounttrue')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_product');
    }
};
