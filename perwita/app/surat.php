<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class surat extends Model
{
   protected $table = 'd_surat';
    
    protected $primaryKey = 'id_surat';
   protected $dates = ['tgl'];
    public $incrementing = false;
    
    

   
    
   protected $fillable = ['id_surat','no_surat','tgl','tgl_lahir','kop_surat','tempat_lahir','p_kpk','p_kpj','p_bu','divisi','gaji','no_rek','nama','jabatan','alamat','instansi','mitra','tgl_m','tgl_b','updated_at','created_at'];
}

	