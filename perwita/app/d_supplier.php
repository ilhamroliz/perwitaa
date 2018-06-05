<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_supplier extends Model
{
    protected $table = 'd_supplier';
    protected $primaryKey = 's_id';
    public $incrementing = false;
    public $remember_token = false;

    protected $fillable = ['s_id','s_company', 's_name', 's_address', 's_phone', 's_fax','s_note', 's_insert', 's_update'];
    
    const UPDATED_AT = 's_update';
    const CREATED_AT = 's_insert';
}
