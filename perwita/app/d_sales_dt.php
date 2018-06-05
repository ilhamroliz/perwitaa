<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales_dt extends Model
{
    protected $table = 'd_sales_dt';
    protected $primaryKey = 'sd_sales';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['sd_sales','sd_detailid','sd_comp','sd_item','sd_item_dt','sd_qty','sd_value', 'sd_total_gross', 'sd_disc_percent', 'sd_disc_value', 'sd_total_net', 'sd_hpp', 'sd_sell'];
}
