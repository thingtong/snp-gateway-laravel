<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorPmMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bor_pm_member';

    protected $fillable = [
        'pro_code',
        'pro_desc',
        'p_date1',
        'p_date2',
        'p_str_day',
        'p_time1s',
        'p_time1e',
        'p_disc1',
        'p_sp_disc1',
        'pts1',
        'p_type',
        'p_sale1',
        'p_free1',
        'p_sum1',
        'p_disc_free1',
        'p_sale41',
        'p_free41',
        'redule_discount',
        'fix_branch',
        'campaign_code',
        'psale51',
        'pdiscount51',
        'p_quan611',
        'p_disc_per611',
        'p_disc_baht611',
        'p_quan612',
        'p_disc_per612',
        'p_disc_baht612',
        'p_quan613',
        'p_disc_per613',
        'p_disc_baht613',
        'p_quan614',
        'p_disc_per614',
        'p_disc_baht614',
        'p_quan615',
        'p_disc_per615',
        'p_disc_baht615',
        'p_amt711',
        'p_disc_per711',
        'p_disc_baht711',
        'p_amt712',
        'p_disc_per712',
        'p_disc_baht712',
        'p_amt713',
        'p_disc_per713',
        'p_disc_baht713',
        'p_amt714',
        'p_disc_per714',
        'p_disc_baht714',
        'p_amt715',
        'p_disc_per715',
        'p_disc_baht715',
        'brithday',
        'default_discount',
        'mudjai_code',
        'p8type',
        'p8qty',
        'p8amount',
        'p9buymin',
        'p9chkminall',
        'p9type',
        'p9discountper',
        'p9discountbath',
        'p9multi',
        'p9other',
        'p9cnt',
        'protopic',
        'prodetail'
    ];
}
