<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TimeModel extends Model
{
    public static function InsTime($data)
    {
        return DB::table('table_time')->insert($data);
    }

    public static function getTime()
    {
        return DB::table('table_time')->get();
    }

    public static function UpdateStatusTime($id,$status)
    {
        return DB::table('table_time')
                    ->where('id_time',$id)
                    ->update(['status_time_service'=>$status]);
    }

    public static function getDataTimeById($id)
    {
        return DB::table('table_time')
                    ->where('id_time',$id)
                    ->first();
    }

    public static function updateTime($data)
    {
        return DB::table('table_time')
                    ->where('id_time',$data['id_time'])
                    ->update($data);
    }

    public static function DeleteTime($id)
    {
        return DB::table('table_time')
                    ->where('id_time',$id)
                    ->delete();
    }
}
