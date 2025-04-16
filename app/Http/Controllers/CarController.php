<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Response;
use Exception;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $carsModel;
    private $responseData;
    public function __construct()
    {
        $this->carsModel = new Car();
    }

    public function index()
    {
        $carsList = $this->carsModel->ShowAll();
        $res = $carsList->getResponse();
        return response()->json($res, $res['status']);
    }

    public function showbyid($id)
    {
        $carsList = $this->carsModel->ShowById($id);
        $res = $carsList->getResponse();
        return response()->json($res, $res['status']);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function insert_validate(Request $request){
        try {
            $messages  = [
                'car_name.required'             => 'Car Name Is Required',
                'day_rate.required'             => 'Day Rate Is Required',
                'month_rate.required'           => 'Month Rate Is Required',
                'day_rate.numeric'             => 'Day Rate Is Filled With Number',
                'month_rate.numeric'           => 'Month Rate Is Filled With Number',
                'image_char.required'           => 'Image Char Is Required',
            ];
    
            $validator = Validator::make($request->all(), [
                'car_name'         => 'required',   
                'day_rate'         => 'required|numeric|',
                'month_rate'       => 'required|numeric|',
                'image_char'       => 'required',
            ], $messages);
    
            if($validator->fails()) {
                $allErrors = $validator->errors();
                $this->responseData = new Response(400, "Bad Request", null, $allErrors);
            } else {
                $this->responseData = new Response(200, "Ok", null, null);
            }
        } catch (Exception $e) {
            $this->responseData = new Response(500, "Fail Validation Request", null, $e->getMessage());
        }
        return $this->responseData;
    }

    public function create(Request $request)
    {  
        $cekRequest = $this->insert_validate($request);
        $validate   = $cekRequest->getResponse();
        if($validate['status'] == 200) {
            $car_name           =   $request->input('car_name');
            $day_rate           =   $request->input('day_rate');
            $month_rate         =   $request->input('month_rate');
            $image_char         =   $request->input('image_char');
    
            $createCars         = $this->carsModel->Create($car_name, $day_rate, $month_rate, $image_char);
            $this->responseData = $createCars->getResponse();
            
            return response()->json($this->responseData, $this->responseData['status']);
        } else {
            return response()->json($validate, $validate['status']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $carById = $this->carsModel->showbyid($id);
        $carCek  = $carById->getResponse();
        if($carCek['status'] == 200) {
            $cekRequest = $this->insert_validate($request);
            $validate   = $cekRequest->getResponse();
            if($validate['status'] == 200) {
                $car_name           =   $request->input('car_name');
                $day_rate           =   $request->input('day_rate');
                $month_rate         =   $request->input('month_rate');
                $image_char         =   $request->input('image_char');
        
                $updateCars         = $this->carsModel->Edit($id, $car_name, $day_rate, $month_rate, $image_char);
                $this->responseData = $updateCars->getResponse();
                
                return response()->json($this->responseData, $this->responseData['status']);
            } else {
                return response()->json($validate, $validate['status']);
            }
        } else {
            return response()->json($carCek, $carCek['status']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $carById = $this->carsModel->showbyid($id);
        $carCek  = $carById->getResponse();
        if($carCek['status'] == 200) {
            $hapusCars          = $this->carsModel->Hapus($id);
            $this->responseData = $hapusCars->getResponse();
            return response()->json($this->responseData, $this->responseData['status']);
        } else {
            return response()->json($carCek, $carCek['status']);
        }
    }
}
