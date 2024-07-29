<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblCodeDescTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_code_desc', function (Blueprint $table) {
            //$table->id();
            $table->string('groupname', 200);
            $table->string('codename', 200);
            $table->string('subcode', 200);
            $table->string('codedescription', 2000);
            $table->string('codevalue', 2000);
            $table->string('codevalue2', 2000);
            $table->string('codevalue3', 2000);
            $table->string('codevalue4', 2000);
            $table->string('codevalue5', 2000);
            $table->string('codevalue6', 2000);
            $table->string('codevalue7', 2000);
            $table->string('codevalue8', 2000);
            $table->string('codepermission', 1);
            $table->string('codestatus', 1);
            $table->integer('sortid');
            $table->integer('createduserid');
            $table->string('createdname', 500);
            $table->dateTime('createddate');
            $table->integer('modifieduserid');
            $table->string('modifiedname', 500);
            $table->dateTime('modifieddate');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_code_desc');
    }
}

