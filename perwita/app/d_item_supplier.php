<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_item_supplier extends Model
{
    protected $table = 'd_item_supplier';
    protected $primaryKey = 'is_id';
    public $incrementing = false;
    public $remember_token = false;

    //public $timestamps = false;
    const UPDATED_AT = 'is_update';
    const CREATED_AT = 'is_insert';
    
    
    protected $fillable = ['is_id','is_item','is_supplier','is_price'];

}
