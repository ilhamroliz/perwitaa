<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_mem_access extends Model
{




    protected $table = 'd_mem_access';
    protected $primaryKey = 'ma_id';
    protected $fillable = ['ma_id',
    					   'ma_mem',
    					   'ma_access',
    					   'ma_group',
    					   'ma_type',
    					   'ma_read',
    					   'ma_insert',
    					   'ma_update',
    					   'ma_delete'];

    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
}
