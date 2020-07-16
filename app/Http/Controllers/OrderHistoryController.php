<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CartProducts;
use App\Order;

class OrderHistoryController extends Controller
{
    //
    public function index(){
     $carts= CartProducts::getCartItems();
     return view('user.order',["carts" => $carts]);
    }
    public  function orderHistory($id){
    $orders= Order::getOrders($id);
    return view('user.orderhistory',["orders" => $orders]);
    }
  
}
