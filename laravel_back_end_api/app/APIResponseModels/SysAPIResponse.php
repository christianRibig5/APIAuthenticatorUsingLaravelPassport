<?php
namespace App\APIResponseModels;

use Illuminate\Database\Eloquent\Model;

class SysAPIResponse
{
    public static $SUCCESS = 200;
    public static $ERROR = 400;
    public static $ALREADY_EXISTS = 300;
    public static $NO_PENDING_WALLET_DEBIT_PAYMENT = 201;
    public $status;
    public $message;
    public $data;
    


    public function __construct($status,$message,$data=null){
       $this->status=$status;
       $this->message=$message;
       $this->data=$data;
     
    }

    public function getStatus(){
       return $this->status;
    }

    public function getMessage(){
       return $this->message;
    }

    public function getData(){
       return $this->data;
    }
}