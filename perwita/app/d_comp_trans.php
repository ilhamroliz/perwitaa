<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_comp_trans extends Model {

    protected $table = 'd_comp_trans';
    protected $primaryKey = 'tr_code';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'tr_update';
    const CREATED_AT = 'tr_insert';
    
    protected $fillable = ['tr_comp','tr_year', 'tr_code', 'tr_codesub', 'tr_name','tr_namesub','tr_cashtype','tr_cashflow','tr_acc01','tr_acc01dk',
        'tr_acc02','tr_acc02dk','tr_acc03','tr_acc03dk','tr_acc04','tr_acc04dk','tr_insert','tr_update'
        ];
    

}
