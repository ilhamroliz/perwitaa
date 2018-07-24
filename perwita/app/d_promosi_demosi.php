<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_promosi_demosi extends Model
{
    protected $table = 'd_promosi_demosi';
    protected $primaryKey = 'pd_id';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = ['pd_id', 'pd_no', 'pd_pekerja', 'pd_jabatan_awal', 'pd_jabatan_sekarang', 'pd_note', 'pd_isapproved', 'pd_insert'];
}
