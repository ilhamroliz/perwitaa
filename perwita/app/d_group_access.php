<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_group_access extends Model
{
    protected $table = 'd_group_access';
    protected $primaryKey = ['ga_group','ga_access'];
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
    
    protected $fillable = ['ga_group','ga_access', 'ga_level'];
}