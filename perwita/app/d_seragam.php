<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_seragam extends Model
{
    protected $table = 'd_seragam';
    protected $primaryKey = 's_id';
    public $incrementing = false;
    public $remember_token = false;   
    public $timestamps = false;
    protected $fillable = ['s_id','s_seragam','s_nama','s_colour','s_jenis'
        . 's_xs','s_s','s_m'
        ,'s_l','s_xl','s_xxl'];
}
