<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_mitra_mou extends Model
{
  protected $table = 'd_mitra_mou';
  protected $primaryKey = ['mm_mitra', 'mm_detailid'];
  public $incrementing = false;
  public $remember_token = false;
  public $timestamps = false;
  protected $fillable = ['mm_mitra','mm_detailid','mm_mou','mm_mou_start','mm_mou_end','mm_aktif','mm_status'];
}
