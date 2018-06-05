<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_calon_pekerja extends Model
{
    protected $table = 'd_calon_pekerja';
    protected $primaryKey = 'cp_id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'cp_insert';
    const CREATED_AT = 'cp_update';
    
    protected $fillable = ['cp_id','cp_nik','cp_jenis_kelamin','cp_nama_lengkap','cp_tgl_masuk_kerja',
                           'cp_tempat_lahir','cp_tgl_lahir','cp_pendidikan','cp_alamat',
                           'cp_notelp','cp_no_ktp','cp_no_rekening','cp_no_kpk','cp_no_jp','cp_no_kpj',
                           'cp_nama_ibu'];
}
