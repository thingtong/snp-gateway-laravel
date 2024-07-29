<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;
    // กำหนดชื่อตารางที่ Model นี้จะเชื่อมต่อ
    protected $table = 'customer';
    public $timestamps = false;
    protected $fillable = [
        'name','email','password','phone_number','title','first_name','last_name','date_of_birth',
        'gender','default_locale','is_member','accepts_terms_and_conditions','accepts_marketing_notifications',
        'memberid','custremark','custphone2','custphone3','custtypeid','custtypename','custtitleid',
        'custtitlename','createduserid','createdname','createddate','modifieduserid','modifiedname','modifieddate',
        'lastcontactdate','lastorderdate','bankcustid','savecard','ordercount','mudjaimemberid','mudjaimemberphone',
        'mudjaimemberbirth','mudjaimemberpoint','mudjaimemberactive','mudjaimemberexpire','mudjailastcheckdate',
    ];
    protected $casts = [
        'is_member' => 'boolean',
        'accepts_terms_and_conditions' => 'boolean',
        'accepts_marketing_notifications' => 'boolean',
        'date_of_birth' => 'datetime',
        'createddate' => 'datetime',
        'modifieddate' => 'datetime',
        'lastcontactdate' => 'datetime',
        'lastorderdate' => 'datetime',
        'mudjaimemberbirth' => 'date',
        'mudjaimemberexpire' => 'datetime',
        'mudjailastcheckdate' => 'datetime',
    ];
}
