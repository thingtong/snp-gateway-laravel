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
        Schema::create('tbl_service_request', function (Blueprint $table) {
           
                $table->increments('srno');
                $table->integer('custid');
                $table->integer('channelid');
                $table->string('channelcode', 50);
                $table->string('channelname', 200);
                $table->string('ctiphone', 100);
                $table->string('contactname', 2000);
                $table->string('contactphone', 2000);
                $table->string('contactemail', 2000);
                $table->string('receivedsms', 1);
                $table->integer('projectid');
                $table->string('projectname', 1000);
                $table->integer('createduserid');
                $table->string('createdname', 200);
                $table->dateTime('createddate');
                $table->integer('modifieduserid')->nullable();
                $table->string('modifiedname', 200)->nullable();
                $table->dateTime('modifieddate')->nullable();
                $table->string('clearflag', 1);
                $table->timestamps();  // ถ้าต้องการ timestamps
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_service_request');
    }
};
