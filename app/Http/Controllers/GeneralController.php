<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\generalModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GeneralController extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('login');
    }

    public function dashboard()
    {
       return view('content.dashboard');
    }

    public function mechanic()
    {
        return view('content.mechanic');
	}
	
	public function validate($params){
		$message = [
			'nama.required' => 'Wajib di isi',
			'nama.min' => 'Kurang Dari 5 Huruf',
			'date.required' => 'Wajib di isi',
			'tmpt_lahir.required' => 'Wajib di isi',
			'alamat.required' => 'Wajib di isi',
			'no_tlpn.required' => 'Wajib di isi',
			'no_tlpn.numeric' => 'No Telephone Harus Angka.',
			'email.required' => 'Wajib di isi',
			'email.unique' => 'Email Sudah Terdaftar',
			];
			
		return Validator::make($params->all(), [
			'nama' => 'required|min:3',
			'date' => 'required',
			'tmpt_lahir' => 'required',
			'alamat' => 'required',
			'no_tlpn' => 'required|numeric',
			'email' => 'required|unique:table_mecanic,email_mecanic',
		], $message);
	}

    public function addMechanic(Request $params)
    {
        $validator = $this->validate($params);
		if($validator->fails()){
			return response()->json(["error"=>json_decode($validator->messages())], 422);
		}else{
			$data=[
				"id_mecanic" => 'MHC'.rand(),
				"nama_mecanic" => $params->nama,
				"alamat_mecanic" => $params->alamat,
				"tlglahir_mecanic" => $params->date,
				"tempatlahir_mecanic" => $params->tmpt_lahir,
				"no_tlpn" => $params->no_tlpn,
				"email_mecanic"=> $params->email,
				"status_mecanic" =>'0',
				"created_at" => Carbon::now(),
				"created_by" => Auth::user()->id,
			];
	
			$insert = generalModel::InsMechanic($data);
			if($insert){
				return response()->json(["status"=>"success","message"=>"Mechanic Added"]);
			}else{
				return response()->json(["status"=>"failed","message"=>"try again"], 422);
			}
		}
	}
	
	public function getAllMechanic()
	{
		return ["data"=>generalModel::getMechanic()];
	}

	public function StatusMechanic($id,$status)
	{
		if($status=='Active'){
			$nstatus = '1';
		}else{
			$nstatus = '0';
		}

		$query = generalModel::UpdateStatusMechanic($id,$nstatus);
		if($query){
			return ["status"=>"success","message"=>"Mechanic Is ".$status];
		}else{
			return ["status"=>"failed","message"=>"Failed To Update Status"];
		}
	}

	public function deleteMecanic($id){
		$delete = generalModel::DeleteMecanic($id);
		if($delete){
			return ["status"=>"success","message"=>"Mechanic Deleted"];
		}else{
			return ["status"=>"success","message"=>"Failed To Delete"];
		}
	}

	public function getMecanic($id){
		$data = generalModel::getDataMechanicById($id);
		if($data){
			return ["status"=>"success","data"=>$data];
		}
	}

	public function updateMechanic(Request $params){
		$validator = $this->validate($params);
		if($validator->fails()){
			return response()->json(["error"=>json_decode($validator->messages())], 422);
		}else{
			$data=[
				"id_mecanic" => $params->id_mecanic,
				"nama_mecanic" => $params->nama,
				"alamat_mecanic" => $params->alamat,
				"tlglahir_mecanic" => $params->date,
				"tempatlahir_mecanic" => $params->tmpt_lahir,
				"no_tlpn" => $params->no_tlpn,
				"email_mecanic"=> $params->email,
				"status_mecanic" =>'0',
				"updated_at" => Carbon::now(),
				"updated_by" => Auth::user()->id,
			];

			$update = generalModel::updateMecanic($data);
			if($update){
				return ["status"=>"success","message"=>"Mechanic Is Update"];
			}else{
				return ["status"=>"failed","message"=>"Failed To Update"];
			}
		}
	}
}
