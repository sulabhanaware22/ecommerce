<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CartProducts;

class CartController extends Controller
{
    //
    public function index(){
    CartProducts::updateSessionCart();
    $carts= CartProducts::getCartItems();
    return view('user.savedcart',["carts" => $carts]);
    exit();
    }
    public function addCartItem(Request $request){
       // print_r($request->input());
        //exit();
        $result = CartProducts::addCartItem($request);
        $message = array('message' => 'You have successfully added product to cart!');
        if ($result == 1) {
            return json_encode($message);
        }
        exit();
    
    }
    public function editCartItem(Request $request){
       // print_r($request->input());
       // exit();
        $result = CartProducts::editCartItem($request);
        $message = array('message' => 'You have successfully edited product in cart!');
        if ($result == 1) {
            return json_encode($message);
        }
        exit();  
    }
    public function deleteCartItem($id){
    $result= CartProducts::deleteCartItem($id);
    $message = array('message' => 'You have successfully deleted product from the cart!');
    if ($result == 1) {
        return json_encode($message);
    }
    exit();
    }
    public function addCartDatabase(){

    }
    public function deleteCartDatabase(){
        
    }
}
