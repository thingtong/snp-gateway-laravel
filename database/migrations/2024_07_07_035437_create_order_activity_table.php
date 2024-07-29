<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblOrderActivityTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_order_activity', function (Blueprint $table) {
            $table->bigIncrements('activityid');
            $table->integer('ordno');
            $table->dateTime('activitydate');
            $table->string('activitytype', 1000);
            $table->text('activitymessage');
            $table->text('activityslip')->nullable();
            $table->text('activitylink')->nullable();
            $table->string('activitystatus', 1);
            $table->integer('createduserid');
            $table->string('createdname', 500);
            $table->dateTime('createddate');
            $table->integer('modifieduserid');
            $table->string('modifiedname', 500);
            $table->dateTime('modifieddate');
            $table->integer('wslogid')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_order_activity');
    }
}
