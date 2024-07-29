<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZShoppingCartMain extends Model
{
    use HasFactory;
    protected $table = 'z_shopping_cart_main';
    protected $primaryKey = 'refmainid';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'refmainid',
        'custid',
        'is_member',
        'order_mode',
        'deli_fee',
        'pre_amount',
        'discount_member',
        'discount_promotion',
        'discount_special',
        'discount_message',
        'earnest',
        'total_amount',
        'is_active',
        'createddate',
        'modifieddate',
    ];
}
