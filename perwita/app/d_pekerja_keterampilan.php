<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pekerja_keterampilan extends Model
{
    protected $table = 'd_pekerja_keterampilan';
    protected $primaryKey = 'pk_pekerja';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
    protected $fillable = ["pk_pekerja","pk_detailid","pk_keterampilan"];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
