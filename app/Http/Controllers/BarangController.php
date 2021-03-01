<?php


namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Barang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('content.barang');
    }

    public function dashboard()
    {
       return view('content.dashboard');
    }

    public function barang()
    {
        return view('centent.barang');
	}

	public function validate($params){
		$message = [
			'nama.required' => 'Wajib di isi',
			'nama.min' => 'Kurang Dari 5 Huruf',
			'date.required' => 'Wajib di isi',
			'deskripsi.required' => 'Wajib di isi',
			'harga.required' => 'Wajib di isi',
			'stok.required' => 'Wajib di isi',
			];
			return validator::make($params->all(), [
				'nama' => 'required|min:3',
				'date' => 'required',
				'deskripsi' => 'required',
				'harga' => 'required',
				'stok' => 'required',
			
			], $message);
		}
		public function addBarang(Request $params)
		{
			$validator = $this->validate($params);
			if($validator->fails()){
				return response()->json(["error"=>json_decode($validator->messages())], 422);
			}else{
				$data=[
					"id_Barang" => 'MHC'.rand(),
					"nama_barang" => $params->nama,
					"deskripsi_barang" => $params->deskripsi,
					"harga_barang" => $params->harga,
					"stok_barang" => $params->date,
					"tanggal_barang" => $params->date,
					"status_barang" =>'0',
					"created_at" => Carbon::now(),
					"created_by" => Auth::user()->id,
				];

				
			$insert = Barang::InsBarang($data);
			if($insert){
				return response()->json(["status"=>"success","message"=>"Barang Added"]);
			}else{
				return response()->json(["status"=>"failed","message"=>"try again"], 422);
			}
		}
	}
	public function getAllBarang()
	{
		return ["data"=>Barang::getBarang()];
	}

	public function StatusBarang($id,$status)
	{
		if($status=='Active'){
			$nstatus = '1';
		}else{
			$nstatus = '0';
		}
		$query = Barang::UpdateStatusBarang($id,$nstatus);
		if($query){
			return ["status"=>"success","message"=>"Barang Is ".$status];
		}else{
			return ["status"=>"failed","message"=>"Failed To Update Status"];
		}
	}

	public function deleteBarang($id){
		$delete = Barang::DeleteBarang($id);
		if($delete){
			return ["status"=>"success","message"=>"Barang Deleted"];
		}else{
			return ["status"=>"success","message"=>"Failed To Delete"];
		}
	}
	public function getBarang($id){
		$data = Barang::getDataBarangById($id);
		if($data){
			return ["status"=>"success","data"=>$data];
		}
	}
	public function updateBarang(Request $params, $id){
		$validator = $this->validate($params);
		if($validator->fails()){
			return response()->json(["error"=>json_decode($validator->messages())], 422);
		}else{
			$data=[
				"id_Barang" => 'MHC'.rand(),
				"nama_barang" => $params->nama,
				"deskripsi_barang" => $params->deskripsi,
				"harga_barang" => $params->harga,
				"stok_barang" => $params->date,
				"tanggal_barang" => $params->date,
			
				"status_barang" =>'0',
				"created_at" => Carbon::now(),
				"created_by" => Auth::user()->id,
			];
			$update = Barang::updateBarang($data);
			if($update){
				return ["status"=>"success","message"=>"Barang Is Update"];
			}else{
				return ["status"=>"failed","message"=>"Failed To Update"];
			}
		}
	}

	public function label()
	{
		return ["data"=>["label"=>Barang::getLabel(),"value"=>Barang::getvalue()]];
	}
}
