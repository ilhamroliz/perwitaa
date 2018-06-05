<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales extends Model
{
    protected $table = 'd_sales';
    protected $primaryKey ='s_id' ;
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['s_id','s_comp','s_date','s_member','s_nota','s_total_gross','s_disc_percent', 's_disc_value', 's_pajak', 's_total_net', 's_jurnal'];
}
