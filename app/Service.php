<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Service extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'table_service';

    public static function getAll()
    {
        return DB::table('table_service')
                    ->join('users','users.id','=','table_service.id')
                    ->join('table_mecanic','table_mecanic.id_mecanic','=','table_service.id_mecanic')
                    ->leftJoin('table_time','table_time.id_time','=','table_service.id_time')
                    ->orderBy('table_service.created_at')
                    ->get();
    }

    public static function UpdateService($data)
    {
        return DB::table('table_service')
                    ->where('id_service',$data['id_service'])
                    ->update($data);
    }

    public static function DeleteService($id)
    {
        return DB::table('table_service')
                    ->where('id_service',$id)
                    ->delete();
    }

    public static function UpdateCar($id,$status)
    {
        return DB::table('table_service')
                    ->where('id_service',$id)
                    ->update(["flag_status"=>$status]);
    }

}
