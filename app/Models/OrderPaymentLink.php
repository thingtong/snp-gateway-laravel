<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPaymentLink extends Model
{
    use HasFactory;

    // กำหนดชื่อตารางที่ Model นี้จะเชื่อมต่อ
    protected $table = 'tbl_order_payment_link';

    // กำหนด primary key ของตาราง
    protected $primaryKey = 'paymentlinkid';

    // ระบุว่า primary key เป็น auto-increment หรือไม่
    public $incrementing = true;

    // ระบุว่า timestamps (created_at และ updated_at) จะถูกจัดการโดย Laravel หรือไม่
    public $timestamps = false;

    // กำหนดชนิดของคีย์หลัก
    protected $keyType = 'int';

    // กำหนดฟิลด์ที่สามารถทำการ fill ข้อมูลได้
    protected $fillable = [
        'ordno',
        'custid',
        'description',
        'amount',
        'currency',
        'source_type',
        'reference_order',
        'ref_1',
        'ref_2',
        'paymentlinkurl',
        'paymentlinkurlshort',
        'paymentlinkcreated',
        'paymentlinkexpired',
        'paymentinquirycheck',
        'paymentlinkstatus',
        'createduserid',
        'createdname',
        'createddate',
        'refcount',
        'modifieduserid',
        'modifiedname',
        'modifieddate',
        'bankcustid',
        'token'
    ];
}

