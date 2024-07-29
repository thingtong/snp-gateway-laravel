<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblConstantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_constant', function (Blueprint $table) {
            $table->increments('constantid');
            $table->string('webtitle', 1000);
            $table->string('webtitle2', 1000);
            $table->string('webversion', 1000);
            $table->string('webfooter', 1000);
            $table->string('webcontact', 500);
            $table->string('webcontactphone', 50);
            $table->integer('webconcurrent');
            $table->integer('webtimeout');
            $table->string('ctipopup', 1);
            $table->string('ctipopupname', 100);
            $table->integer('userpwdexpired');
            $table->integer('userexpiredalert');
            $table->string('smtpstatus', 1);
            $table->string('smtpserver', 1000);
            $table->string('smtpusername', 1000);
            $table->string('smtpuserpwd', 1000);
            $table->string('smtpport', 10);
            $table->string('smtpssl', 10);
            $table->string('mailfrom', 1000);
            $table->string('mailfromname', 1000);
            $table->string('mailto', 1000);
            $table->string('mailcc', 1000);
            $table->string('mailbcc', 1000);
            $table->string('mailsubject', 2000);
            $table->text('mailbody');
            $table->string('returnreceipt', 1000);
            $table->dateTime('clearlogdate');
            $table->string('orderprinturl', 200);
            $table->string('ticketurlexternal', 200);
            $table->string('ticketurlinternal', 200);
            $table->string('ticketprefix', 50);
            $table->integer('ticketmax');
            $table->integer('ticketmaxattemp');
            $table->integer('ticketmaxfileupload');
            $table->integer('ticketmaxfilesize');
            $table->integer('ticketmaxsearchrow');
            $table->string('ticketfilename', 500);
            $table->string('ticketfilekey', 1);
            $table->string('ticketfilekeyname', 500);
            $table->integer('kmmaxfileupload');
            $table->integer('kmmaxfilesize');
            $table->integer('kmmaxsearchrow');
            $table->integer('kmnewalertday');
            $table->integer('kmupdatealertday');
            $table->string('kmcontentfilename', 500);
            $table->string('kmfilekey', 1);
            $table->string('kmfilekeyname', 500);
            $table->integer('reportlimitdate');
            $table->integer('reportlimitdateextra');
            $table->integer('createduserid');
            $table->string('createdname', 1000);
            $table->dateTime('createddate');
            $table->integer('modifieduserid');
            $table->string('modifiedname', 1000);
            $table->dateTime('modifieddate');
            $table->string('encryptkey', 100);
            $table->integer('userloginfaillimit');
            $table->integer('userloginfailwait');
            $table->string('currencytype', 100);
            $table->integer('autofeedneworder');
            $table->integer('messagetimeout');
            $table->integer('orderlimitday');
            $table->integer('dashboardrefresh');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_constant');
    }
}