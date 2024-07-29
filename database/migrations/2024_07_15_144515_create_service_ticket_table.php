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
        Schema::create('tbl_service_ticket', function (Blueprint $table) {
            $table->increments('ticketid');
            $table->integer('srno');
            $table->integer('custid');
            $table->string('ticketlogno', 50);
            $table->integer('catid');
            $table->string('catcode', 50);
            $table->string('catname', 200);
            $table->integer('subcatid');
            $table->string('subcatcode', 50);
            $table->string('subcatname', 200);
            $table->string('subcatsms', 1);
            $table->string('subcatemail', 1);
            $table->string('subcatws', 1);
            $table->text('ticketdetail');
            $table->text('ticketsolution');
            $table->integer('priorityid');
            $table->string('priorityname', 200);
            $table->integer('slaid');
            $table->string('slacode', 20);
            $table->string('slaname', 200);
            $table->integer('docrefid');
            $table->string('docrefname', 200);
            $table->integer('ticketstatusid');
            $table->string('ticketstatuscode', 50);
            $table->string('ticketstatusname', 200);
            $table->string('ticketstatustype', 1);
            $table->string('ticketstatussms', 1);
            $table->string('ticketstatusemail', 1);
            $table->string('ticketstatusws', 1);
            $table->string('ticketstatusspecial', 1);
            $table->integer('ticketprojectid');
            $table->string('ticketprojectname', 2000);
            $table->string('firstcallresolution', 1);
            $table->integer('ticketattachfile');
            $table->dateTime('ticketsladate');
            $table->integer('secretlevelid');
            $table->string('secretlevelname', 200);
            $table->integer('responseuserid');
            $table->string('responseusername', 50);
            $table->integer('assigndepartmentid');
            $table->string('assigndepartmentname', 200);
            $table->integer('assigndivisionid');
            $table->string('assigndivisionname', 200);
            $table->integer('assignpersonid');
            $table->string('assignpersonname', 200);
            $table->integer('responsedepartmentid');
            $table->string('responsedepartmentname', 200);
            $table->integer('responsedivisionid');
            $table->string('responsedivisionname', 50);
            $table->integer('closeduserid');
            $table->string('closedname', 200);
            $table->dateTime('closeddate');
            $table->string('ticketfilepath', 1000);
            $table->string('ticketfilekey', 500);
            $table->string('ticketfilename', 1000);
            $table->string('ticketfiletype', 500);
            $table->integer('ticketfilesize');
            $table->dateTime('channeldate');
            $table->integer('createduserid');
            $table->string('createdname', 200);
            $table->dateTime('createddate');
            $table->integer('modifieduserid')->nullable();
            $table->string('modifiedname', 200)->nullable();
            $table->dateTime('modifieddate')->nullable();
            $table->string('clearflag', 1);
            $table->integer('cattypeid');
            $table->string('cattypename', 100);
            $table->integer('branchid');
            $table->string('branchcode', 100);
            $table->string('branchname', 200);
            $table->integer('refno');
            $table->timestamps();  // ถ้าต้องการ timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_service_ticket');
    }
};
