<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_purchase extends Model
{
    protected $table = 'd_purchase';
    protected $primaryKey = 'p_id';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = ['p_id','p_comp','p_date','p_supplier','p_nota','p_total_gross','p_disc_percent', 'p_disc_value', 'p_pajak', 'p_total_net', 'p_jurnal', 'p_isapproved'];

    
}
