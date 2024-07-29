<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customer';

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'title',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'default_locale',
        'is_member',
        'accepts_terms_and_conditions',
        'accepts_marketing_notifications',
    ];

    public function address(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }
}
