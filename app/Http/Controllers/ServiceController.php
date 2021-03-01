<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;




class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * //@return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.service');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return ["data"=>Service::getAll()];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = $this->validator($request);
		if($validator->fails()){
			return response()->json(["error"=>json_decode($validator->messages())], 422);
		}else{
            $data = [
                "id_service" => $request->id_service,
                "id_time" => $request->time,
                "flag_Status"=>'1'
            ];

            $query = Service::UpdateService($data);
            if($query){
                return ["status"=>"success","message"=>"Time Has Been Set"];
            }else{
                return ["status"=>"failed","message"=>"update failed"];
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Service::DeleteService($id);
		if($delete){
			return ["status"=>"success","message"=>"Service Deleted"];
		}else{
			return ["status"=>"failed","message"=>"Failed To Delete"];
		}
    }

    public function validator($params)
    {
		$message = [
			'time.required' => 'Wajib di isi',
			];
			
		return Validator::make($params->all(), [
			'time' => 'required',
		], $message);
    }

    public function updateCar($id,$status)
    {
        $query = Service::UpdateCar($id,$status);
        if($query){
            if($status=='2'){
                $keterangan = 'Car Arrived';
            }else{
                $keterangan = 'The car is finished in service';
            }
            return ["status"=>"success","message"=>$keterangan];
        }else{
            return ["status"=>"failed","message"=>"update failed"];
        }
    }

    public function detail ($id)
    {
        return ["data"=>Service::detailService($id)];
    }
}
