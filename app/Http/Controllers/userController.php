<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\userModel;

class userController extends Controller
{
    public function login(Request $request)
    {
        $data = [
            "username" => $request->Username,
            "password" => $request->Password
        ];

        $query = userModel::Login($data);
        if(count($query)!=1)
        {
            return response(['status' => 'error', 'message' => 'These credentials do not match our records username.']);
        }else{
            $user = [
                'id' =>  $query[0]->id, 
                'Username' => $query[0]->username,
                'Email' => $query[0]->email
            ];
            $token =  "test";
            return response([['status' => 'success','data'=>$user, 'token' => $token]]);
        }
    }

    public function register(Request $request)
    {
        $data = [
            "id"=>"USR".rand(),
            "username"=>$request->Username,
            "password"=>$request->Password,
            "nama_lenkap"=>$request->NamaLengkap,
            "email"=>$request->Email,
            "no_hp"=>$request->NoHp,
            "role"=>'user',
            "created_at"=>date('Y-m-d h:i:s')
        ];

        $query = userModel::Register($data);
        if($query){
            $dataUser=[
                "id"=>$data['id'],
                "Username"=>$data['username']
            ];
            $token="token";
            return response(['status' => 'success','data'=>$dataUser, 'token'=>$token]);
        }else{
            return response(['status' => 'error','data'=>'error insert user.']);
        }

    }

    public function validateUser($id)
    {
        $data = userModel::cekById($id);
        if(count($data)==1){
            return response(["status" => "success", "data" => $data], 200);
        }else{
            return response(['status' => 'error', 'message' => 'no result data.']);
        }
    }

    public function booking(Request $params)
    {   
        $data = [
            "id_service"=>"SRV".rand(),
            "id"=>$params->id_user,
            "date_book"=>$params->date_book,
            "id_mecanic"=>$params->id_mecanic,
            "complaint"=>$params->complaint,
            "created_at"=>date("Y-m-d H:i:s")
        ];
        $InsertBook = userModel::InsertBook($data);
        if($InsertBook){
            return response(['status' => "success","message"=>"your booking has been added"]);
        }else{
            return response(['status' => "failed","message"=> 'please try again']);
        }
    }

    public function history($id)
    {
        $history = userModel::historyById($id);
        return response(['status'=>'success','data_history'=>$history]);
    }

    public function getMecanic()
    {
        $driver = userModel::getMecanic();
        return response(['status'=>'success','data_mecanic'=>$driver]);
    }

    public function cekDone($id)
    {
        $check = userModel::CheckDone($id);
        return response(["status"=>"success","data"=>$check]);
    }

    public function addRating($id,$rate)
    {
        $instRate = userModel::instRate($id,$rate);
        return response(["status"=>"success","message"=>"Thanks For Your Feed Back"]);
    }

    public function detailHistory($id)
    {
        $detail = userModel::detailHistory($id);
        return response(["status"=>"success","data"=>$detail]);
    }
}
