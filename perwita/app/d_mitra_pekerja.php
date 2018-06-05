<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_mitra_pekerja extends Model
{
    protected $table = 'd_mitra_pekerja';
    protected $primaryKey = 'mp_id';
    public $incrementing = false;
    public $remember_token = false;
    
    const CREATED_AT = 'mp_insert';
    const UPDATED_AT = 'mp_update';
    
	
	
	
    
    protected $fillable = ["mp_id","mp_comp","mp_pekerja","mp_mitra","mp_contract","mp_divisi","mp_mitra_nik","mp_selection_date","mp_workin_date","mp_status","mp_insert","mp_update"];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
