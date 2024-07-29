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
        Schema::create('tbl_order_payment_link', function (Blueprint $table) {
            $table->increments('paymentlinkid'); // Auto-increment primary key
            $table->integer('ordno')->unsigned();
            $table->integer('custid')->unsigned();
            $table->string('description', 2000);
            $table->float('amount');
            $table->string('currency', 50);
            $table->string('source_type', 50);
            $table->string('reference_order', 100);
            $table->string('ref_1', 100);
            $table->string('ref_2', 100);
            $table->string('paymentlinkurl', 2000);
            $table->string('paymentlinkurlshort', 2000);
            $table->dateTime('paymentlinkcreated');
            $table->dateTime('paymentlinkexpired');
            $table->dateTime('paymentinquirycheck')->nullable();
            $table->string('paymentlinkstatus', 1);
            $table->integer('createduserid')->unsigned();
            $table->string('createdname', 500);
            $table->dateTime('createddate');
            $table->integer('refcount')->unsigned();
            $table->integer('modifieduserid')->unsigned()->nullable();
            $table->string('modifiedname', 500)->nullable();
            $table->dateTime('modifieddate')->nullable();
            $table->string('bankcustid', 500)->nullable();
            $table->string('token', 500)->nullable();
            $table->timestamps(); // This will add created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_order_payment_link');
    }
};
