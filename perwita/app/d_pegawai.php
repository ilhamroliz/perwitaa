<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pegawai extends Model
{    
    protected $table = 'd_pegawai';
    protected $primaryKey = 'p_id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'p_insert';
    const CREATED_AT = 'p_update';
    
    protected $fillable = ['p_id','p_nik','p_jenis_kelamin','p_nama_lengkap','p_tgl_masuk_kerja','p_tempat_lahir','p_tgl_lahir'
                            ,'p_pendidikan','p_alamat','p_notelp','p_no_ktp','p_no_rekening','p_no_kpk','p_no_jp','p_no_kpj','p_nama_ibu'];
}
