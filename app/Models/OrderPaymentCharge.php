<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPaymentCharge extends Model
{
    use HasFactory;

    protected $table = 'tbl_order_payment_charge';
    
    protected $primaryKey = 'paymentchargeid';

    // ระบุว่า primary key เป็น auto-increment หรือไม่
    public $incrementing = true;

    // ระบุว่า timestamps (created_at และ updated_at) จะถูกจัดการโดย Laravel หรือไม่
    public $timestamps = false;

    // กำหนดชนิดของคีย์หลัก
    protected $keyType = 'int';

    protected $fillable = [
        'paymentchargeid',
        'paymentchargestatus',
        'ordno',
        'custid',
        'chargeno',
        'tokenno',
        'chargestatus',
        'createduserid',
        'createdname',
        'createddate',
        'transaction_state',
        'transaction_status',
        'failure_code',
        'failure_message',
        'approval_code',
        'reference_order',
        'ref_1',
        'ref_2',
        'modifieduserid',
        'modifiedname',
        'modifieddate',
        'cardno',
    ];
}
