<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\TimeModel;
use Carbon\Carbon;
use Facade\FlareClient\Time\Time;
use Illuminate\Support\Facades\Auth;

class TimeController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('content.time');
    }

    public function validator($params)
    {
		$message = [
			'time.required' => 'Wajib di isi',
			'time.min' => 'Tidak Sesuai Format 09:00-10:00',
			'time.max' => 'Tidak Sesuai Format 09:00-10:00',
			'time.unique'=> 'Time Sudah Tersedia'
			];
			
		return Validator::make($params->all(), [
			'time' => 'required|min:11|max:11|unique:table_time,time',
		], $message);
    }
    
    public function addTime(Request $params)
    {
		// dd($params->time);
        $validator = $this->validator($params);
		if($validator->fails()){
			return response()->json(["error"=>json_decode($validator->messages())], 422);
		}else{
			$data=[
				"id_time" => 'TS'.rand(),
				"time" => $params->time,
				"status_time_service" => '0',
				"created_at" => Carbon::now(),
				"created_by" => Auth::user()->id,
			];
	
			$insert = TimeModel::InsTime($data);
			if($insert){
				return response()->json(["status"=>"success","message"=>"Time Added"]);
			}else{
				return response()->json(["status"=>"failed","message"=>"try again"], 422);
			}
		}
	}
	
	public function getAllTime()
	{
		return ["data"=>TimeModel::getTime()];
	}

	public function StatusTime($id,$status)
	{
		if($status=='Active'){
			$nstatus = '1';
		}else{
			$nstatus = '0';
		}

		$query = TimeModel::UpdateStatusTime($id,$nstatus);
		if($query){
			return ["status"=>"success","message"=>"Time Is ".$status];
		}else{
			return ["status"=>"failed","message"=>"Failed To Update Time"];
		}
	}

	public function UpdateTime(Request $params)
	{
		$validate = $this->validator($params);
		if($validate->fails()){
			return response()->json(["error"=>json_decode($validate->messages())], 422);
		}else{
			$data=[
				"id_time" => $params->id_time,
				"time" => $params->time,
				"updated_at" => Carbon::now(),
				"updated_by" => Auth::user()->id,
			];

			$update = TimeModel::updateTime($data);
			if($update){
				return ["status"=>"success","message"=>"Mechanic Is Update"];
			}else{
				return ["status"=>"failed","message"=>"Failed To Update"];
			}
		}
	}

	public function getTime($id)
	{
		$data = TimeModel::getDataTimeById($id);
		if($data){
			return ["status"=>"success","data"=>$data];
		}
	}

	public function DeleteTime($id)
	{
		$delete = TimeModel::DeleteTime($id);
		if($delete){
			return ["status"=>"success","message"=>"Time Deleted"];
		}else{
			return ["status"=>"failed","message"=>"Failed To Delete"];
		}
	}
}
