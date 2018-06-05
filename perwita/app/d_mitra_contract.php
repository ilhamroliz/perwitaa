<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_mitra_contract extends Model
{
    protected $table = 'd_mitra_contract';
    protected $primaryKey = ['mc_mitra', 'mc_contractid'];
    public $incrementing = false;
    public $remember_token = false;    
    const CREATED_AT = 'mc_insert';
    const UPDATED_AT = 'mc_update';
    protected $fillable = ['mc_mitra','mc_contractid','mc_comp', 'mc_jabatan', 'mc_no',
        'mc_date','mc_expired','mc_need','mc_divisi','mc_fulfilled','mc_status_mp'];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
