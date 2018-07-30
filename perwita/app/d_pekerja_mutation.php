<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pekerja_mutation extends Model
{
    protected $table = 'd_pekerja_mutation';
    protected $primaryKey = 'pm_pekerja';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = ['pm_pekerja', 'pm_detailid', 'pm_date', 'pm_mitra', 'pm_divisi', 'pm_detail', 'pm_from', 'pm_status', 'pm_note', 'pm_reff', 'pm_insert_by', 'pm_reff'];
}
