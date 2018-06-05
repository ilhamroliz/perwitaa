<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_group extends Model
{
    protected $table = 'd_group';
    protected $primaryKey = 'g_id';
    protected $fillable = ['g_id','g_name'];

    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
}
