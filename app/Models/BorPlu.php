<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorPlu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bor_plu';

    protected $fillable = [
        'code','barcode','description','referent_code', 'unit',
        'storage_location','product_type','discount', 'tax_calculation','product_category','product_set','pricing_method','stock_management',
        'kitchen_printing', 'service_charge', 'product_group_code','vendor_code', 'price_eat_in', 'price_take_away','price_delivery',
        'price_pinto','price_wholesale','promotion1','promotion2','promotion3', 'not_use1','not_use2','standard_cost', 'average_cost',
        'latest_cost','remark','not_use3','active','not_use4','last_update','department_charge','personal_charge','special_charge',
        'selectable_set_item','selectable_item_count','not_use5','preparation_time','not_use6', 'kitchen_print_description',
        'short_description','not_use7','not_use8','flag','sap_article','sap_article_name','sap_article_barcode',
        'sap_article_unit','ap_article_jde','sap_article_active','wtime','ltime','description_english',
        'daily_count_stock', 'weekly_count_stock', 'monthly_count_stock','show_for_stock_count',
    ];

    protected $dates = ['last_update', 'created_at', 'updated_at', 'deleted_at'];
}
