<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class deliv extends Model
{
   protected $table = 'delivery_order';
   protected $primaryKey = 'nomor';
   protected $fillable = 'status';
}

	