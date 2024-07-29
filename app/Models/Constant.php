<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Constant extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'tbl_constant';

    // Specify the primary key if it doesn't follow Laravel's convention
    protected $primaryKey = 'constantid';

    // Specify the fields that can be mass assigned
    protected $fillable = [
        'webtitle', 'webtitle2', 'webversion', 'webfooter', 'webcontact', 'webcontactphone',
        'webconcurrent', 'webtimeout', 'ctipopup', 'ctipopupname', 'userpwdexpired', 'userexpiredalert',
        'smtpstatus', 'smtpserver', 'smtpusername', 'smtpuserpwd', 'smtpport', 'smtpssl', 'mailfrom',
        'mailfromname', 'mailto', 'mailcc', 'mailbcc', 'mailsubject', 'mailbody', 'returnreceipt',
        'clearlogdate', 'orderprinturl', 'ticketurlexternal', 'ticketurlinternal', 'ticketprefix',
        'ticketmax', 'ticketmaxattemp', 'ticketmaxfileupload', 'ticketmaxfilesize', 'ticketmaxsearchrow',
        'ticketfilename', 'ticketfilekey', 'ticketfilekeyname', 'kmmaxfileupload', 'kmmaxfilesize',
        'kmmaxsearchrow', 'kmnewalertday', 'kmupdatealertday', 'kmcontentfilename', 'kmfilekey',
        'kmfilekeyname', 'reportlimitdate', 'reportlimitdateextra', 'createduserid', 'createdname',
        'createddate', 'modifieduserid', 'modifiedname', 'modifieddate', 'encryptkey', 'userloginfaillimit',
        'userloginfailwait', 'currencytype', 'autofeedneworder', 'messagetimeout', 'orderlimitday',
        'dashboardrefresh'
    ];

    // If your primary key is not an integer, specify its type
    public $incrementing = false;
    protected $keyType = 'string';

    // If your model should not use timestamps
    public $timestamps = false;
}
