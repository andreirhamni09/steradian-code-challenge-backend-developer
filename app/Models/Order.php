<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class Order extends Model
{
    private $response;

    public function ShowAll(){
        try {
            $sql = "SELECT cars.car_name, orders.* 
                    FROM orders
                    LEFT JOIN cars ON cars.car_id = orders.car_id";
            $order = DB::select($sql);
            $this->response         = new Response(200, 'Order List', $order, []);
            return $this->response;
        } catch (Exception $e) {
            $error['messages']     = $e->getMessage();
            $this->response        = new Response($e->getCode(), 'Fail Access Data', null, $error);
            return $this->response;
        }
    }

    public function ShowById($id){
        try {
            $sql = "SELECT cars.car_name, orders.* 
                    FROM orders
                    LEFT JOIN cars ON cars.car_id = orders.car_id
                    WHERE orders.order_id = ?";
            $cars = DB::select($sql, [$id]);
            if(empty($cars) || is_null($cars)) {
                $this->response         = new Response(404, 'Data Not Found', [], []);
                return $this->response;
            } else {
                $this->response         = new Response(200, 'Order Data', $cars, []);
                return $this->response;
            }
        } catch (Exception $e) {
            $error['messages']     = $e->getMessage();
            $this->response        = new Response(500, 'Internal Server Error', null, $error);
            return $this->response;
        }
    }

    public function ShowByIdAndCar($car){
        try {
            $sql = "SELECT cars.car_name, orders.* 
                    FROM orders
                    LEFT JOIN cars ON cars.car_id = orders.car_id
                    WHERE orders.car_id = ?";
            $order = DB::select($sql, [$car]);
            if(empty($order) || is_null($order)) {
                $this->response         = new Response(404, 'Data Not Found', [], []);
                return $this->response;
            } else {
                $this->response         = new Response(200, 'Order Data', $order, []);
                return $this->response;
            }
        } catch (Exception $e) {
            $error['messages']     = $e->getMessage();
            $this->response        = new Response(500, 'Internal Server Error', null, $error);
            return $this->response;
        }
    }

    public function Create($car_id, $order_date, $pickup_date, $dropoff_date, $pickup_location, $dropoff_location){
        try {
            $insertOrder = DB::statement('INSERT INTO orders(car_id, order_date, pickup_date, dropoff_date, pickup_location, dropoff_location) VALUES(?,?,?,?,?,?)', [$car_id, $order_date, $pickup_date, $dropoff_date, $pickup_location, $dropoff_location]);
            if($insertOrder > 0) {
                $this->response         = new Response(200, 'Berhasil Input Data Order', null, null);
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
    
    public function Edit($id, $car_id, $order_date, $pickup_date, $dropoff_date, $pickup_location, $dropoff_location){
        try {
            $sql = "UPDATE orders SET car_id = ?, order_date = ?, pickup_date = ?, dropoff_date = ?, pickup_location = ?, dropoff_location = ? WHERE order_id = ?";
            $updateOrder = DB::statement($sql, [$car_id, $order_date, $pickup_date, $dropoff_date, $pickup_location, $dropoff_location, $id]);
            if($updateOrder > 0) {
                $this->response         = new Response(200, 'Berhasil Mengubah Data Order', null, null);
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
            $deleteOrders = DB::statement('DELETE FROM orders WHERE order_id = ?', [$id]);
            if($deleteOrders > 0) {
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
