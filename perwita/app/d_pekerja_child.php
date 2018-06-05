<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pekerja_child extends Model
{
    protected $table = 'd_pekerja_child';
    protected $primaryKey = 'pc_pekerja';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
    protected $fillable = ["pc_pekerja","pc_detailid","pc_child_name","pc_birth_date","pc_birth_date"];
}
