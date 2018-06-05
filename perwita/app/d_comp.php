<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_comp extends Model
{
    protected $table = 'd_comp';
    protected $primaryKey = 'c_id';
    const CREATED_AT = 'cm_insert';
    const UPDATED_AT = 'cm_update';
    public $incrementing = false;

    public function member(){
    	return $this->belongsToMany('App\mMember', 'd_mem_comp', 'mc_comp', 'mc_mem');
    }
}
