<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bpjs extends Model
{
   protected $table = 'd_bpjs';
    protected $primaryKey = 'p_nik';
    public $incrementing = false;
    
   protected $fillable = ['no_kartu','p_nik','npp','p_name','p_birthdate','h_keluarga','TMT','nf_1','p_state','kelas','ns_instansi','md_id'];
}

	