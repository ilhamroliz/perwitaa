<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_item extends Model
{
    protected $table = 'd_item';
    protected $primaryKey = 'i_id';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = ['i_id','i_nama','i_satuan','i_warna','i_kategori','i_price','i_img', 'i_isactive', 'i_hpp', 'i_note'];
}
