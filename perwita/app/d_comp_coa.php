<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_comp_coa extends Model {

    protected $table = 'd_comp_coa';
    protected $primaryKey = 'coa_code';
    public $incrementing = false;
    public $remember_token = false;

    public $timestamps = false;

    const UPDATED_AT = 'coa_update';
    const CREATED_AT = 'coa_insert';


    protected $fillable = ['coa_comp','coa_year','coa_code','coa_name','coa_level','coa_parent','coa_isparent','coa_isactive','coa_opening_tgl',
                            'coa_opening','coa_current','coa_ending_tgl','coa_ending','coa_insert','coa_update','coa_default'];
}
