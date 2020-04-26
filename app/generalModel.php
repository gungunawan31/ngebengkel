<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Static_;

class generalModel extends Model
{
    public static function InsMechanic($data)
    {
        return DB::table('table_mecanic')->insert($data);
    }

    public static function getMechanic()
    {
        return DB::table('table_mecanic')->get();
    }

    public static function UpdateStatusMechanic($id,$status)
    {
        return DB::table('table_mecanic')
                    ->where('id_mecanic',$id)
                    ->update(['status_mecanic'=>$status]);
    }

    public static function DeleteMecanic($id)
    {
        return DB::table('table_mecanic')
                    ->where('id_mecanic',$id)
                    ->delete();
    }

    public static function getDataMechanicById($id)
    {
        return DB::table('table_mecanic')
                    ->where('id_mecanic',$id)
                    ->first();
    }

    public static function updateMecanic($data)
    {
        return DB::table('table_mecanic')
                    ->where('id_mecanic',$data['id_mecanic'])
                    ->update($data);
    }

    public static function getLabel()
    {
        return DB::select("SELECT MONTH(created_at) as bulan FROM `users` where role = 'user' group by MONTH(created_at) ORDER BY created_at asc");
    }

    public static function getvalue()
    {
        return DB::select("SELECT count(*) as pendaftar FROM `users` where role = 'user' group by MONTH(created_at) ORDER BY created_at asc");
    }
}
