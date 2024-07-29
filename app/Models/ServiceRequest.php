<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;
    protected $table = 'tbl_service_request';

    protected $primaryKey = 'srno';

    public $timestamps = false; // ถ้ามี timestamps

    protected $fillable = [
        'srno',
        'custid',
        'channelid',
        'channelcode',
        'channelname',
        'ctiphone',
        'contactname',
        'contactphone',
        'contactemail',
        'receivedsms',
        'projectid',
        'projectname',
        'createduserid',
        'createdname',
        'createddate',
        'modifieduserid',
        'modifiedname',
        'modifieddate',
        'clearflag',
    ];
}
