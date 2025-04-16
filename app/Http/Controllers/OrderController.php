<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Response;
use App\Models\Car;
use Exception;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $responseData;
    private $orderModel;
    private $carModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->carModel = new Car();
    }

    public function index()
    {
        $orderList = $this->orderModel->ShowAll();
        $res = $orderList->getResponse();
        return response()->json($res, $res['status']);
    }

    /**
     * Show the form for creating a new resource.
     */
     
    public function showbyid($id)
    {
        $carsList = $this->orderModel->ShowById($id);
        $res = $carsList->getResponse();
        return response()->json($res, $res['status']);
    }

    
    public function showbyidcar($car)
    {
        $carsList = $this->orderModel->ShowByIdAndCar($car);
        $res = $carsList->getResponse();
        return response()->json($res, $res['status']);
    }

    public function input_validation($request) {
        try {
            $car_id             = $request->input('car_id');
            $getListCar         = $this->carModel->ShowById($car_id);
            $response_car       = $getListCar->getResponse();
            $arrCar             = $response_car['success_data'];
            $car_list_id        = '';
            for ($i=0; $i < count($arrCar) ; $i++) { 
                $car_list_id .= $arrCar[$i]->car_id.",";
            }            
            $car_list_id = substr($car_list_id,0,-1);
            $messages  = [
                'car_id.required'               => 'Car Id Is Required',
                'car_id.in'                     => 'Car Id Tidak Ditemukan Disistem',
                'order_date.required'           => 'Order Date Is Required',
                'pickup_date.required'          => 'Pickup Date Is Required',
                'dropoff_date.required'         => 'Dropoff Date Is Required',
                'order_date.date'               => 'Order Date isi dengan Tanggal',
                'pickup_date.date'              => 'Pickup Date isi dengan Tanggal',
                'dropoff_date.date'             => 'Dropoff Date isi dengan Tanggal',
                'order_date.date_format'        => 'Order Date isi dengan Format Tanggal:YYYY-mm-dd ex:(2024-02-24-/2024-12-24)',
                'pickup_date.date_format'       => 'Pickup Date isi dengan Format Tanggal:YYYY-mm-dd ex:(2024-12-24/2024-12-24)',
                'dropoff_date.date_format'      => 'Dropoff Date isi dengan Format Tanggal:YYYY-mm-dd ex:(2024-12-24/2024-12-24)',
                'pickup_date.after'             => 'Pickup Date isi dengan Tanggal Setelah Tanggal Order',
                'dropoff_date.after'            => 'Dropoff Date isi dengan Tanggal Setelah Tanggal Pickup',
                'pickup_location.required'      => 'Pickup Location Is Required',
                'dropoff_location.required'     => 'Dropoff Location Required',
            ];
    
            $validator = Validator::make($request->all(), [
                "car_id"                => 'required|in:'.$car_list_id.'',
                "order_date"            => 'required|date|date_format:Y-m-d',
                "pickup_date"           => 'required|date|date_format:Y-m-d|after:order_date',
                "dropoff_date"          => 'required|date|date_format:Y-m-d|after:pickup_date',
                "pickup_location"       => 'required',
                "dropoff_location"      => 'required'
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
        $cekRequest = $this->input_validation($request);
        $validate   = $cekRequest->getResponse();
        if($validate['status'] == 200) {
            $car_id                 = $request->input('car_id');
            $order_date             = $request->input('order_date');    
            $pickup_date            = $request->input('pickup_date');    
            $dropoff_date           = $request->input('dropoff_date');    
            $pickup_location        = $request->input('pickup_location');        
            $dropoff_location       = $request->input('dropoff_location');        
    
            $createCars         = $this->orderModel->Create($car_id, $order_date, $pickup_date, $dropoff_date, $pickup_location, $dropoff_location);
            $this->responseData = $createCars->getResponse();
            
            return response()->json($this->responseData, $this->responseData['status']);
        } else {
            return response()->json($validate, $validate['status']);
        }
    }
    public function update($id, Request $request)
    { 
        $cekRequest = $this->input_validation($request);
        $validate   = $cekRequest->getResponse();
        if($validate['status'] == 200) {
            $cekOrderId         = $this->orderModel->ShowById($id);
            $dataOrderResponse  = $cekOrderId->getResponse();
            if($dataOrderResponse['status'] == 200) {
                $car_id                 = $request->input('car_id');
                $order_date             = $request->input('order_date');    
                $pickup_date            = $request->input('pickup_date');    
                $dropoff_date           = $request->input('dropoff_date');    
                $pickup_location        = $request->input('pickup_location');        
                $dropoff_location       = $request->input('dropoff_location');        
                
                $editCars         = $this->orderModel->Edit($id, $car_id, $order_date, $pickup_date, $dropoff_date, $pickup_location, $dropoff_location);
                $this->responseData = $editCars->getResponse();
                
                return response()->json($this->responseData, $this->responseData['status']);
            } else {
                return response()->json($dataOrderResponse, $this->responseData['status']);
            }
        } else {
            return response()->json($validate, $validate['status']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $cekOrderId         = $this->orderModel->ShowById($id);
        $dataOrderResponse  = $cekOrderId->getResponse();
        if($dataOrderResponse['status'] == 200) {       
            $hapusCars         = $this->orderModel->Hapus($id);
            $this->responseData = $hapusCars->getResponse();
            
            return response()->json($this->responseData, $this->responseData['status']);
        } else {
            return response()->json($dataOrderResponse, $this->responseData['status']);
        }
    }
}
