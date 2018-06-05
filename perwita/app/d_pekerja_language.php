<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pekerja_language extends Model
{
    protected $table = 'd_pekerja_language';
    protected $primaryKey = 'pl_pekerja';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
    protected $fillable = ["pl_pekerja","pl_detailid","pl_language"];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
