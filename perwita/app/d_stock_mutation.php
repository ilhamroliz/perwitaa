<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_stock_mutation extends Model
{
    protected $table = 'd_stock_mutation';
    protected $primaryKey ='sm_stock' ;
    protected $fillable = ['sm_stock', 'sm_detailid', 'sm_comp', 'sm_date', 'sm_item', 'sm_item_dt', 'sm_detail', 'sm_qty','sm_use','sm_hpp','sm_sell', 'sm_nota','sm_delivery_order','sm_petugas'];
    public $incrementing = false;
    public $timestamps = false;

    public function d_mem() {
    	$res = $this->belongsTo('App\d_mem', 'sm_petugas', 'm_id');
    	

    	return $res;
    }
}
