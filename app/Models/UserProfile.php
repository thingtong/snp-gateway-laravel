<?php

namespace App\Models;

use App\Traits\UseHashIdModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UseHashIdModel;

    protected $table = 'user_profile';

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'id',
        'user_id',
    ];
}
