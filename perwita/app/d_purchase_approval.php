<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class d_purchase_approval extends Model
{
    protected $table = 'd_purchase_approval';
    protected $primaryKey = 'pa_purchase';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;

    public function d_purchase() {
    	$res = $this->belongsTo('App\d_purchase', 'pa_detailid', 'p_id');

    	return $res;
    }

    public function d_item() {
    	$res = $this->belongsTo('App\d_item', 'pa_item', 'i_id');

    	return $res;
    }

    public function d_item_dt() {
    	$res = $this->belongsTo('App\d_item_dt', 'pa_item_dt', 'id_detailid');
    	

    	return $res;
    }

    public function d_stock_mutation() {
    	$res = $this->belongsTo('App\d_stock_mutation', 'pa_do', 'sm_delivery_order');


    	return $res;
    }
}
