<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorPmMemberHasPlu extends Model
{
    use HasFactory;
    protected $table = 'bor_pm_member_has_plu';

    protected $fillable = [
        'pm_member_id',
        'plu_id',
    ];
}
