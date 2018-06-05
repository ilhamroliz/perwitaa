<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_trans_cat extends Model
{
    protected $table = 'm_trans_cat';
    protected $primaryKey = 'tt_code';
    public $incrementing = false;
    public $remember_token = false;

    public $timestamps = false;

//    const UPDATED_AT = 'm_update';
//    const CREATED_AT = 'm_insert';

    protected $fillable = ['tt_code', 'tt_name', 'tt_income', 'tt_isactive'];
}
