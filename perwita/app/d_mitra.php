<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_mitra extends Model
{
    protected $table = 'd_mitra';
    protected $primaryKey = 'm_id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'm_update';
    const CREATED_AT = 'm_insert';
    protected $fillable = ['m_id','m_name','m_address','m_cp','m_cp_phone','m_fax','m_note','m_phone','m_status'];
}
