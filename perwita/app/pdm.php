<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pdm extends Model
{
   protected $table = 'd_mitra_pekerja';
    
    protected $primaryKey = 'mp_id';

    public $incrementing = false;
    
    

   const CREATED_AT = 'mp_insert';
    const UPDATED_AT = 'mp_update';
    
   protected $fillable = ['mp_id','mp_comp','mp_pekerja','mp_mitra','mp_contract','mp_divisi','mp_mitra_nik','mp_state','mp_selection_date','mp_workin_Date','mp_uniform_receive_date','mp_uniform_paid_date','mp_update','mp_insert'];
}

	