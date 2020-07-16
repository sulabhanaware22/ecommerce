<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    //
    protected $table = 'orders';
    public $timestamps = false;
    public  static function addOrders($data)
    {
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->product_id = $data['product_id'];
        $order->price = $data['price'];
        $order->save();
    }
    public static function getOrders($id = '')
    {
        $orders = Order::query()
            ->leftjoin('users as U', 'U.id', '=', 'orders.user_id')
            ->where('orders.user_id', $id)
            ->get(['orders.id as order_id', 'U.name as user_name', 'orders.price as product_price', 'orders.product_id']);
      //  print_r($orders->toArray());
       // exit();
        $return = array();
        $i = 0;
        foreach ($orders->toArray() as $value) {
            $return[$i] = $value;
            $string = $value['product_id'];
            $product_id = explode(",", $string);
          //  print_r($product_id);
          //  exit();
            $j = 0;
            foreach ($product_id as $value) {
                $product=Product::getProduct($value);
                $return[$i]["products"][$j] = $product->toArray();
                $j++;
            }
            $i++;
        }
        print_r($return);
        exit();
    }
}
