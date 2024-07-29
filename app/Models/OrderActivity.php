<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderActivity extends Model
{
    use HasFactory;

    protected $table = 'tbl_order_activity';

    protected $primaryKey = 'activityid';

    // ระบุว่า primary key เป็น auto-increment หรือไม่
    public $incrementing = true;

    // ระบุว่า timestamps (created_at และ updated_at) จะถูกจัดการโดย Laravel หรือไม่
   // public $timestamps = true;
   
    public $timestamps = false;
    // กำหนดชนิดของคีย์หลัก
    protected $keyType = 'int';
    
    protected $fillable = [
        'activityid',
        'ordno',
        'activitydate',
        'activitytype',
        'activitymessage',
        'activityslip',
        'activitylink',
        'activitystatus',
        'createduserid',
        'createdname',
        'createddate',
        'modifieduserid',
        'modifiedname',
        'modifieddate',
        'wslogid',
    ];
}
