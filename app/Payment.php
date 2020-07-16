<?php
namespace App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model
{
    protected $table='payment';
    public $timestamps = false;
    public static function insertTransactionDetails($data){
     $payment=new Payment();
     $payment->user_id= Auth::user()->id;
     $payment->transaction_id = $data['transaction_id'];
     $payment->price = $data['price'];
     $payment->payment_date= date('Y-m-d H:i:s');
     $payment->save();
    }
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
