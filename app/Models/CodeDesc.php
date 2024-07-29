<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeDesc extends Model
{
    use HasFactory;

    protected $table = 'tbl_code_desc';

    protected $fillable = [
        'groupname',
        'codename',
        'subcode',
        'codedescription',
        'codevalue',
        'codevalue2',
        'codevalue3',
        'codevalue4',
        'codevalue5',
        'codevalue6',
        'codevalue7',
        'codevalue8',
        'codepermission',
        'codestatus',
        'sortid',
        'createduserid',
        'createdname',
        'createddate',
        'modifieduserid',
        'modifiedname',
        'modifieddate',
    ];
}
