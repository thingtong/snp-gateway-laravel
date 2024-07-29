<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblCustCardTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_cust_card', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('custid');
            $table->string('cardid', 200);
            $table->string('cardno', 50);
            $table->string('brand', 20);
            $table->string('name', 100);
            $table->dateTime('expired');
            $table->timestamps();

            // Define foreign key constraint if needed
            // $table->foreign('custid')->references('id')->on('customers');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_cust_card');
    }
}

