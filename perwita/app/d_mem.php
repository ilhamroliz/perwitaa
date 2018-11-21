<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Auth;

class d_mem extends Model implements AuthenticatableContract, CanResetPasswordContract 
{
    use Authenticatable,
        CanResetPassword;

    protected $table = 'd_mem';
    protected $primaryKey = 'm_id';
    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;

    const UPDATED_AT = 'm_update';
    const CREATED_AT = 'm_insert';

    protected $fillable = ['m_id','m_username', 'm_passwd', 'm_paket', 'm_name', 'm_intro'];

    public function company($id){

        $data = DB::table('d_comp')
                ->join('d_mem_comp','d_mem_comp.mc_comp','=','d_comp.c_id')
                ->join('d_comp_year','d_comp_year.y_comp','=','d_comp.c_id')
                ->where('d_mem_comp.mc_mem', '=', $id)->first();

        return $data;
    }

    public function getCompany($id){
        $data = DB::table('d_comp')->where('c_id', '=', $id)->first();

        return $data;
    }

    public function getActiveComp($idMember){
        $data = DB::table('d_mem_comp')->where('mc_mem', '=', $idMember)->where('mc_active', '=', 1)->first();

        return $data;
    }

    public function email(){
        return $this->hasMany('App\d_mem_email', 'me_member', 'm_id');
    }

    public function getActiveEmail($idMember){
        $data = DB::table('d_mem_email')->where('me_member', '=', $idMember)->where('me_isprimary', '=', 1)->first();

        return $data;
    }
    public function getActiveYear($idcomp){
        $data = DB::table('d_comp_year')->where('y_comp', '=', $idcomp)->where('y_active', '=', 1)->first();

        return $data;
    }

    
}
