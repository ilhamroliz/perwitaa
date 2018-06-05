<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_jurnal_dt extends Model
{

    protected $table = 'd_jurnal_dt';
    protected $primaryKey = ['jrdt_id','jrdt_dt'];
    public $incrementing = false;
    public $remember_token = false;

   public $timestamps = false;
   
    
    
    protected $fillable = ['jrdt_id','jrdt_dt', 'jrdt_acc', 'jrdt_value'];
}
