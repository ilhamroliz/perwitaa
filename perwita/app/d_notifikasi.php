<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_notifikasi extends Model
{
    protected $table = 'd_notifikasi';
    protected $primaryKey = 'n_id';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = ['n_id', 'n_fitur', 'n_detail', 'n_qty', 'n_insert'];
}
