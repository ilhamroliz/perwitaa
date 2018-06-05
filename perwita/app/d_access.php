<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_access extends Model
{
    protected $table = 'd_access';
    protected $primaryKey = 'a_id';
    protected $fillable = ['a_name', 'a_parrent'];

    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
    
}
