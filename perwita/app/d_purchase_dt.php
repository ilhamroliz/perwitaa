<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_purchase_dt extends Model
{
    protected $table = 'd_purchase_dt';
    protected $primaryKey = ['pd_purchase', 'pd_detailid'];
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = ['pd_purchase', 'pd_detailid', 'pd_comp','pd_item','pd_item_dt','pd_value','pd_qty','pd_total_gross','pd_disc_percent', 'pd_disc_value', 'pd_total_net', 'pd_barang_masuk', 'pd_receivetime'];
}
