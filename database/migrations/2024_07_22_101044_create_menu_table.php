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
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 255);
            $table->string('name', 255);
            $table->string('description', 255);
            $table->string('name_en', 255)->nullable();
            $table->string('description_en', 255)->nullable();
            $table->string('sku', 255);
            $table->text('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('before_sale_price', 10, 2)->nullable();
            $table->boolean('is_schedule_pricing')->default(0);
            $table->decimal('schedule_price', 10, 2)->nullable();
            $table->decimal('schedule_before_sale_price', 10, 2)->nullable();
            $table->dateTime('schedule_start_at')->nullable();
            $table->dateTime('schedule_end_at')->nullable();
            $table->boolean('is_pickup')->default(0);
            $table->boolean('is_delivery')->default(0);
            $table->string('open_channel', 255)->nullable();
            $table->boolean('is_for_combo_only')->default(0);
            $table->boolean('is_open_customer_note')->default(0);
            $table->boolean('is_preorder')->default(0);
            $table->integer('min_preorder_days')->default(0);
            $table->integer('cart_limit')->default(0);
            $table->boolean('is_active')->default(1);
            $table->dateTime('active_start_at')->nullable();
            $table->dateTime('active_end_at')->nullable();
            $table->integer('priority')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->string('productcode', 200)->nullable();
            $table->string('productpnucode', 200)->nullable();
            $table->string('productname', 500);
            $table->integer('productgroupid')->nullable();
            $table->string('productgroupname', 50)->nullable();
            $table->integer('productprice')->default(0);
            $table->integer('sortid')->default(0);
            $table->string('changeinsetflag', 1)->nullable();
            $table->string('flagshow', 1)->nullable();
            $table->string('productmainid', 200)->nullable();
            $table->string('productmainname', 200)->nullable();
            $table->string('discountautoflag', 1)->nullable();
            $table->integer('createduserid')->nullable();
            $table->date('createddate')->nullable();
            $table->integer('modifieduserid')->nullable();
            $table->date('modifieddate')->nullable();
            $table->string('createdname', 50)->nullable();
            $table->string('modifiedname', 50)->nullable();
            $table->integer('setqty')->default(0);
            $table->integer('productsideprice')->default(0);
            $table->string('flagcustdiscount', 1)->nullable();
            $table->string('flagsetcustdiscount', 1)->nullable();
            $table->integer('setqtyuse')->default(0);
            $table->string('itemtype', 5)->nullable();
            $table->string('possend', 1)->nullable();
            $table->integer('pricediscount')->default(0);
            $table->string('pricediscountflag', 1)->nullable();
            $table->integer('pricediscounttrue')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
