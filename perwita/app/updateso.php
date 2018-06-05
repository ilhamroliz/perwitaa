<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class updateso extends Model
{
   protected $table = 'u_s_order';
   protected $primaryKey = 'u_o_nomor';
   protected $fillable = ['u_o_nomor','Status','catatan','updated_at','created_at'];
}

	