<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_seragam_pekerja extends Model
{
    protected $table = 'd_seragam_pekerja';
    protected $primaryKey = 'sp_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['sp_id', 'sp_sales', 'sp_pekerja', 'sp_item', 'sp_item_size', 'sp_qty', 'sp_value', 'sp_pay_value', 'sp_status'];
}
