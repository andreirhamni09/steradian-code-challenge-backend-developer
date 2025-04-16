<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Response;
use Exception;

class Car extends Model
{
    private $response;

    public function ShowAll(){
        try {
            $cars = DB::select('SELECT * FROM cars');
            $this->response         = new Response(200, 'List Cars', $cars, []);
            return $this->response;
        } catch (Exception $e) {
            $error['messages']     = $e->getMessage();
            $this->response        = new Response($e->getCode(), 'Fail Access Data', null, $error);
            return $this->response;
        }
    }

    public function ShowById($id){
        try {
            $cars = DB::select('SELECT * FROM cars WHERE car_id = ?', [$id]);
            if(empty($cars) || is_null($cars)) {
                $this->response         = new Response(404, 'Data Not Found', [], []);
                return $this->response;
            } else {
                $this->response         = new Response(200, 'Car Data', $cars, []);
                return $this->response;
            }
        } catch (Exception $e) {
            $error['messages']     = $e->getMessage();
            $this->response        = new Response(500, 'Internal Server Error', null, $error);
            return $this->response;
        }
    }

    public function Create($car_name, $day_rate, $month_rate, $image_char){
        try {
            $createCars = DB::statement('INSERT INTO cars(car_name, day_rate, month_rate, image_char) VALUES(?,?,?,?)', [$car_name, $day_rate, $month_rate, $image_char]);
            if($createCars > 0) {
                $this->response         = new Response(200, 'Berhasil Input Data Mobil', null, null);
                return $this->response;
            } else {
                $this->response         = new Response(500, 'Internal Server Error', null, null);
                return $this->response;
            }
        } catch (Exception $e) {
            $error['messages']     = $e->getMessage();
            $this->response        = new Response(500, 'Internal Server Error', null, $error);
            return $this->response;
        }
    }
    
    public function Edit($id, $car_name, $day_rate, $month_rate, $image_char){
        try {
            $updateCars = DB::statement('UPDATE cars SET car_name = ?, day_rate = ?, month_rate = ?, image_char = ? WHERE car_id = ?', [$car_name, $day_rate, $month_rate, $image_char, $id]);
            if($updateCars > 0) {
                $this->response         = new Response(200, 'Berhasil Mengubah Data Mobil', null, null);
                return $this->response;
            } else {
                $this->response         = new Response(500, 'Internal Server Error', null, null);
                return $this->response;
            }
        } catch (Exception $e) {
            $error['messages']     = $e->getMessage();
            $this->response        = new Response(500, 'Internal Server Error', null, $error);
            return $this->response;
        }
    }
    public function Hapus($id){
        try {
            $deleteCars = DB::statement('DELETE FROM cars WHERE car_id = ?', [$id]);
            if($deleteCars > 0) {
                $this->response         = new Response(200, 'Data Berhasil DiHapus', null, null);
                return $this->response;
            } else {
                $this->response         = new Response(500, 'Internal Server Error', null, null);
                return $this->response;
            }
        } catch (Exception $e) {
            $error['messages']     = $e->getMessage();
            $this->response        = new Response(500, 'Internal Server Error', null, $error);
            return $this->response;
        }
    }
}
