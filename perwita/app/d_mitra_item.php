<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_mitra_item extends Model
{
    protected $table = 'd_mitra_item';
    protected $primaryKey = 'mi_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['mi_id', 'mi_mitra', 'mi_item'];
}
