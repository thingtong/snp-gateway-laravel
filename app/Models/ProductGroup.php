<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    use HasFactory;
    protected $table = 'tbl_product_group';
    protected $primaryKey = 'productgroupid';
    public $incrementing = true;
    public $timestamps = false; // If you don't want Laravel to manage created_at and updated_at

    protected $fillable = [
        'productgroupid',
        'productgroupname',
        'productgroupstatus',
        'sortid',
        'createduserid',
        'createddate',
        'modifieduserid',
        'modifieddate',
        'productgroupflag',
        'deptcode',
        'flagshow'
    ];
}
