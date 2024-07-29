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
        Schema::create('tbl_order_detail', function (Blueprint $table) {
            $table->increments('orderdetailid');
            $table->integer('ordno');
            $table->string('productid', 50);
            $table->string('productname', 500);
            $table->string('productcode', 200);
            $table->string('ordermenuremark', 300);
            $table->integer('productgroupid');
            $table->string('productgroupname', 300);
            $table->integer('qty');
            $table->integer('unitprice');
            $table->string('tierid', 5);
            $table->text('ordremark');
            $table->integer('indexset');
            $table->integer('sortsetid');
            $table->string('posid', 100);
            $table->string('prodmainid', 200);
            $table->integer('layerid');
            $table->string('modgroup', 50);
            $table->string('submodgroup', 50);
            $table->string('productrun', 50);
            $table->string('setflag', 5);
            $table->integer('createduserid');
            $table->string('createdname', 500);
            $table->dateTime('createddate');
            $table->integer('modifieduserid');
            $table->string('modifiedname', 500);
            $table->dateTime('modifieddate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_order_detail');
    }
};
