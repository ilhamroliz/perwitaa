<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pekerja_pengalaman extends Model
{
    protected $table = 'd_pekerja_pengalaman';
    protected $primaryKey = 'pp_pekerja';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
    protected $fillable = ["pp_pekerja","pp_detailid","pp_perusahaan","pp_start","pp_end","pp_jabatan"];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
