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
        Schema::create('tbl_service_ticket_log', function (Blueprint $table) {
            $table->increments('ticketlogid');
            $table->integer('ticketid');
            $table->integer('srno');
            $table->integer('custid');
            $table->text('ticketworklog');
            $table->integer('ticketstatusid');
            $table->string('ticketstatuscode', 50);
            $table->string('ticketstatusname', 200);
            $table->string('ticketstatustype', 1);
            $table->string('ticketstatussms', 1);
            $table->string('ticketstatusemail', 1);
            $table->string('ticketstatusspecial', 1);
            $table->integer('assigndepartmentid');
            $table->string('assigndepartmentname', 200);
            $table->integer('assigndivisionid');
            $table->string('assigndivisionname', 200);
            $table->integer('assignpersonid');
            $table->string('assignpersonname', 200);
            $table->string('sendmailstatus', 1);
            $table->string('sendmailmessage', 2000);
            $table->integer('createduserid');
            $table->string('createdname', 200);
            $table->dateTime('createddate');
            $table->integer('modifieduserid')->nullable();
            $table->string('modifiedname', 200)->nullable();
            $table->dateTime('modifieddate')->nullable();
            $table->string('clearflag', 1);

            $table->timestamps(); // ถ้าต้องการ timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_service_ticket_log');
    }
};
