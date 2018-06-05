<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_jurnal extends Model {

    protected $table = 'd_jurnal';
    protected $primaryKey = 'jr_id';
    public $incrementing = false;
    public $remember_token = false;

    //public $timestamps = false;
    const UPDATED_AT = 'jr_update';
    const CREATED_AT = 'jr_insert';
    
    
    protected $fillable = ['jr_id','jr_comp', 'jr_year', 'jr_trans', 'jr_transsub', 'jr_cashtype', 'jr_tgl', 'jr_value','jr_note','jr_memcode'];

}
