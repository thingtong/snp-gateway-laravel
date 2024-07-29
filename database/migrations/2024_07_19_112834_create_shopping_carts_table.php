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
       
        Schema::create('z_shopping_cart_cms', function (Blueprint $table) {

            $table->increments('shoppingcartid');
            $table->integer('refmainid');
            $table->integer('item_no');
            $table->string('item_id', 100);
            $table->string('item_code', 100);
            $table->string('item_name', 500);
            $table->string('item_remark', 500)->nullable();
            $table->integer('item_qty');
            $table->integer('item_unitprice');
            $table->string('item_indexset', 50)->nullable();
            $table->string('item_indexset', 50)->nullable();
            $table->integer('item_mainid');
            $table->string('item_maincode', 50)->nullable();
            $table->dateTime('createddate');
            $table->integer('item_setid');
            $table->dateTime('modifieddate')->nullable();
            $table->integer('item_productgroupid');
            $table->string('item_productgroupname', 250)->nullable();
           // $table->timestamps();
            
        });
     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('z_shopping_cart_cms');
    }
};
