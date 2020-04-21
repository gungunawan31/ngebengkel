<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class userModel extends Model
{
    public static function Login($data)
    {
        return DB::table('users')
                ->where('username',$data['username'])
                ->where('password',$data['password'])
                ->get();
    }

    public static function Register($data)
    {
        return DB::table('users')->insert($data);
    }

    public static function cekById($id)
    {
        return DB::table('users')
                    ->select('id','username','nama_lenkap','email','no_hp')
                    ->where('id',$id)
                    ->get();
    }

    public static function InsertBook($data)
    {
        return DB::table('table_service')->insert($data);
    }

    public static function historyById($id)
    {
        return DB::table('table_service')
                        ->join('table_mecanic','table_mecanic.id_mecanic','=','table_service.id_mecanic')
                        ->leftJoin('table_time','table_time.id_time','=','table_service.id_time')
                        ->where('table_service.id',$id)
                        ->orderBy('table_service.created_at')
                        ->get();
    }

    public static function getMecanic()
    {
        return DB::table('table_mecanic')
                        ->whereNull('status_job')
                        ->where('status_mecanic','1')
                        ->get();
    }

    public static function CheckDone($id)
    {
        return DB::table('table_service')
                        ->join('table_mecanic','table_mecanic.id_mecanic','=','table_service.id_mecanic')
                        ->where('table_service.id',$id)
                        ->where('table_service.flag_status','3')
                        ->whereNull('rating')
                        ->get();
    }

    public static function instRate($id,$rate)
    {
        return DB::table('table_service')
                        ->where('id_service',$id)
                        ->update(["rating"=>$rate]);

    }

    public static function detailHistory($id)
    {
        return DB::table('table_service')
                        ->join('table_mecanic','table_mecanic.id_mecanic','=','table_service.id_mecanic')
                        ->join('table_time','table_time.id_time','=','table_service.id_time')
                        ->where('table_service.id_service',$id)
                        ->orderBy('table_service.created_at')
                        ->first();
    }
}
