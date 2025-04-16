<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    private $status;
    private $messages;
    private $success_data;
    private $error_data;
    
    public function __construct($status = 200, $messages = '', $success_data = [], $error_data = [])
    {
        $this->status           = $status;
        $this->messages         = $messages;
        $this->success_data     = $success_data;
        $this->error_data       = $error_data;
    }

    public function getResponse(){
        $response['status']         = $this->status;
        $response['messages']       = $this->messages;
        $response['success_data']   = $this->success_data;
        $response['error_data']     = $this->error_data;
        return $response;
    }
}
