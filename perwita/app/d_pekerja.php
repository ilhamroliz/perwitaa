<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class d_pekerja extends Model
{
    protected $table = 'd_pekerja';
    protected $primaryKey = 'p_id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'p_update';
    const CREATED_AT = 'p_insert';


    protected $fillable = ["p_id","p_jabatan","p_jabatan_lamaran","p_nip","p_nip_mitra","p_ktp","p_name","p_sex","p_birthplace","p_birthdate","p_hp","p_telp","p_status","p_many_kids","p_religion","p_address","p_rt_rw","p_kel","p_kecamatan","p_city","p_address_now","p_rt_rw_now","p_kel_now","p_kecamatan_now","p_city_now","p_name_family","p_address_family","p_telp_family","p_hp_family","p_hubungan_family","p_wife_name","p_wife_birth", "p_wife_birthplace","p_dad_name","p_dad_job","p_mom_name","p_mom_job","p_job_now","p_weight","p_height","p_seragam_size","p_celana_size","p_sepatu_size","p_kpk","p_bu","p_ktp_expired","p_ktp_seumurhidup","p_education","p_kpj_no","p_state","p_note","p_workdate","p_img","p_insert","p_update","p_date_approval", "p_status_approval", "p_insert_by"];

    protected $dates = ['p_tgl_lahir'];

    public function getPTglLahirAttribute($date)
    {
        return Carbon::parse($date);
    }

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

}
