<?php


 


namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Static_;

class barang extends Model
{
    public static function InsBarang($data)
    {
        return DB::table('barang')->insert($data);
    }
    public static function getBarang()
    {
        return DB::table('barang')->get();
    }

    public static function UpdateStatusMechanic($id,$status)
    {
        return DB::table('barang')
                    ->where('id_barang',$id)
                    ->update(['status_barang'=>$status]);
    }
    public static function DeleteBarang($id)
    {
        return DB::table('barang')
                    ->where('id_barang',$id)
                    ->delete();
    }
    public static function getDataBarangById($id)
    {
        return DB::table('barang')
                    ->where('id_barang',$id)
                    ->first();
    }
    public static function updateBarang($data)
    {
        return DB::table('barang')
                    ->where('id_barang',$data['id_barang'])
                    ->update($data);
    }
}