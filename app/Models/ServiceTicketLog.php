<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTicketLog extends Model
{
    use HasFactory;
    protected $table = 'tbl_service_ticket_log';

    protected $primaryKey = 'ticketlogid';

    public $timestamps = false; // ถ้ามี timestamps

    protected $fillable = [
        'ticketid',
        'srno',
        'custid',
        'ticketworklog',
        'ticketstatusid',
        'ticketstatuscode',
        'ticketstatusname',
        'ticketstatustype',
        'ticketstatussms',
        'ticketstatusemail',
        'ticketstatusspecial',
        'assigndepartmentid',
        'assigndepartmentname',
        'assigndivisionid',
        'assigndivisionname',
        'assignpersonid',
        'assignpersonname',
        'sendmailstatus',
        'sendmailmessage',
        'createduserid',
        'createdname',
        'createddate',
        'modifieduserid',
        'modifiedname',
        'modifieddate',
        'clearflag',
    ];
}
