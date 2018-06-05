<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'd_mem';
    protected $primaryKey = 'm_id';
    public $incrementing = false;
    public $remember_token = false;
    
    protected $fillable = ['m_id','m_username', 'm_password', 'm_paket', 
                           'm_paket_start','m_paket_end','m_name','m_birth_tgl',
                           'm_addr','m_lastlogin','m_lastlogout'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getAuthPassword() {
        return $this->m_password;
    }
     public function getUpdatedAtAttribute() {
        return $this->attributes['m_update'];
    }

    public function setUpdatedAtAttribute($value) {
        //$this->attributes['a_updated'] = $value;
        // this may not work, depends if it's a Carbon instance, and may also break the above - you may have to clone the instance
        $this->attributes['m_update'] = $value->setTimezone('UTC');
    }

}
