<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pekerja_sim extends Model
{
    protected $table = 'd_pekerja_sim';
    protected $primaryKey = 'ps_pekerja';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
    protected $fillable = ["ps_pekerja","ps_detailid","ps_sim","ps_note"];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
