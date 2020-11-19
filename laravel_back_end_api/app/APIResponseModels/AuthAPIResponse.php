<?php
namespace App\APIResponseModels;

use Illuminate\Database\Eloquent\Model;

class AuthAPIResponse
{
      //status: 200 =success , 400 = error
      public static $SUCCESS = 200;
      public static $ERROR = 400;
      public static $ALREADY_EXISTS = 300;
      public static $NO_PENDING_WALLET_DEBIT_PAYMENT = 201;
      public $status;
      public $message;
      public $data;
      public $accessToken;
  
  
      public function __construct($status,$message,$data=null,$accessToken=null){
         $this->status=$status;
         $this->message=$message;
         $this->data=$data;
         $this->accessToken=$accessToken;
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
      public function getAccessToken(){
         return $this->accessToken;
      }
 
}