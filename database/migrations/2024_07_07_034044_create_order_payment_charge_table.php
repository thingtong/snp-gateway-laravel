<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOrderPaymentChargeTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_order_payment_charge', function (Blueprint $table) {
            $table->bigIncrements('paymentchargeid');
            $table->string('paymentchargestatus', 1);
            $table->integer('ordno');
            $table->integer('custid');
            $table->string('chargeno', 1000);
            $table->string('tokenno', 1000);
            $table->string('chargestatus', 100);
            $table->integer('createduserid');
            $table->string('createdname', 500);
            $table->dateTime('createddate');
            $table->string('transaction_state', 100);
            $table->string('transaction_status', 100);
            $table->string('failure_code', 100);
            $table->string('failure_message', 1000);
            $table->string('approval_code', 1000);
            $table->string('reference_order', 1000);
            $table->string('ref_1', 1000);
            $table->string('ref_2', 1000);
            $table->integer('modifieduserid');
            $table->string('modifiedname', 500);
            $table->dateTime('modifieddate');
            $table->string('cardno', 30)->nullable(); // Nullable field for card number
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_order_payment_charge');
    }
}

