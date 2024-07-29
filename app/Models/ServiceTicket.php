<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTicket extends Model
{
    use HasFactory;
    protected $table = 'tbl_service_ticket';

    protected $primaryKey = 'ticketid';

    public $timestamps = false; // ถ้ามี timestamps

    protected $fillable = [
        'ticketid',
        'srno',
        'custid',
        'ticketlogno',
        'catid',
        'catcode',
        'catname',
        'subcatid',
        'subcatcode',
        'subcatname',
        'subcatsms',
        'subcatemail',
        'subcatws',
        'ticketdetail',
        'ticketsolution',
        'priorityid',
        'priorityname',
        'slaid',
        'slacode',
        'slaname',
        'docrefid',
        'docrefname',
        'ticketstatusid',
        'ticketstatuscode',
        'ticketstatusname',
        'ticketstatustype',
        'ticketstatussms',
        'ticketstatusemail',
        'ticketstatusws',
        'ticketstatusspecial',
        'ticketprojectid',
        'ticketprojectname',
        'firstcallresolution',
        'ticketattachfile',
        'ticketsladate',
        'secretlevelid',
        'secretlevelname',
        'responseuserid',
        'responseusername',
        'assigndepartmentid',
        'assigndepartmentname',
        'assigndivisionid',
        'assigndivisionname',
        'assignpersonid',
        'assignpersonname',
        'responsedepartmentid',
        'responsedepartmentname',
        'responsedivisionid',
        'responsedivisionname',
        'closeduserid',
        'closedname',
        'closeddate',
        'ticketfilepath',
        'ticketfilekey',
        'ticketfilename',
        'ticketfiletype',
        'ticketfilesize',
        'channeldate',
        'createduserid',
        'createdname',
        'createddate',
        'modifieduserid',
        'modifiedname',
        'modifieddate',
        'clearflag',
        'cattypeid',
        'cattypename',
        'branchid',
        'branchcode',
        'branchname',
        'refno',
    ];
}
