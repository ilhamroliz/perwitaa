<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pekerja_referensi extends Model
{
    protected $table = 'd_pekerja_referensi';
    protected $primaryKey = 'pr_pekerja';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
    protected $fillable = ["pr_pekerja","pr_detailid","pr_referensi"];

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
