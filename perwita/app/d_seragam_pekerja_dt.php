<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_seragam_pekerja_dt extends Model
{
    protected $table = 'd_seragam_pekerja_dt';
    protected $primaryKey = 'spd_sales';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['spd_sales', 'sp_detailid', 'spd_pekerja', 'spd_installments', 'spd_date'];
}
