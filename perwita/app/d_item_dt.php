<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_item_dt extends Model
{
    protected $table = 'd_item_dt';
    protected $primaryKey = ['id_item', 'id_detailid'];
    public $incrementing = false;
    public $remember_token = false;
    const CREATED_AT = 'id_inserted';
    const UPDATED_AT = 'id_updated';

    protected $fillable = ['id_item', 'id_detailid', 'id_size', 'id_price', 'id_inserted', 'id_updated'];

    public function d_size() {
    	$res = $this->belongsTo('App\d_size', 'id_size', 's_id');
    	

    	return $res;
    }
}
