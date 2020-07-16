<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\CartDuplicateItemException;
use CustomException;

class CartProducts extends Model
{
  //
  protected $table = 'user_product_reference';

  public static function getCartItems()
  {
    // DB::enableQueryLog();
    // echo "finally";
    // $output= Cart::content();
    // print_r($output);
    // exit();
    $cart = CartProducts::query()
      ->leftjoin('products as P', 'P.id', '=', 'user_product_reference.product_id')
      ->leftjoin('users as U', 'U.id', '=', 'user_product_reference.user_id')
      ->leftjoin('category as C', 'C.id', '=', 'P.category_id')
      ->where('user_product_reference.user_id',Auth::user()->id)
      ->get(['user_product_reference.id as ref_id', 'P.name as p_name', 'C.name as c_name', 'P.product_description', 'P.product_image', 'user_product_reference.product_qty as p_qty', 'P.price as p_price', 'U.name as u_name']);
    return $cart;
    //$query = DB::getQueryLog();
  }
  public static function addCartItem($request)
  {
    // session(['key' => 1999]);
    // $cartData=session('key');
    // session()->save();
    $user_id = Auth::user()->id;
    $product_id = $request->input('product_id');
    $get_cart_item = CartProducts::where('user_id', $user_id)
      ->where('product_id', $product_id)
      ->get();
    $get_cart_item = $get_cart_item->toArray();
    if (isset($get_cart_item) && !empty($get_cart_item)) {
      try {
       //  throw new \App\Exceptions\CartDuplicateItemException('This Product Already Added in Cart!',800);
       throw new \ErrorException('This Product Already Added in Cart!',700);
      
    } catch (CartDuplicateItemException $exception) {
       
    }
    } else {
      $product = Product::findOrFail($request->input('product_id'));
      $add_to_cart = array(
        "id" => $request->input('product_id'),
        "name" => $product->name,
        "qty" => $request->input('product_quantity'),
        "price" => $product->price

      );
      //logic
      $return = Cart::add($add_to_cart);
      if (!empty($return)) {
        CartProducts::updateSessionCart();
        $result = CartProducts::addDatabaseCart($return);
        return $result;
      }
    }

    exit();

    //CartProducts::getSessionCarts();
    //save the data to database
    //$this->save_cart_items($product_id, $user_id, $quantity);
    //end

  }
  public static function editCartItem($request)
  {
    $cartProducts= CartProducts::where('id',$request->input('cart_id'))->first();
    $cart=$cartProducts->toArray();
    $cartItem= Cart::content()->toArray();
    $inCart=0;
    foreach($cartItem as $value){
     if($value['id'] != '' && ($value['id'] == $cart['product_id'])){
      //delete the product in cart
       $inCart=1;
       $status=Cart::update($value['rowId'],$request->product_quantity);
     //  print_r($status);
     }
    }
   // echo $inCart;
   CartProducts::updateSessionCart();
    $result=CartProducts::updateDatabaseCart($request);
    return $result;
    exit(); 

  }
  public static function deleteCartItem($id)
  {
    $cartProducts= CartProducts::where('id',$id)->first();
    $cart=$cartProducts->toArray();
    $cartItem= Cart::content()->toArray();
    $inCart=0;
    foreach($cartItem as $value){
     if($value['id'] != '' && ($value['id'] == $cart['product_id'])){
      //delete the product in cart
       $inCart=1;
       $status=Cart::remove($value['rowId']);
       echo $status;
     }
    }
   // echo $inCart;
   CartProducts::updateSessionCart();
    $result=CartProducts::deleteDatabaseCart($id);
    return $result;
    exit();
  }
  public static function getSessionCarts()
  {
    $cart_items_output = Cart::content()->toArray();
   // echo "inside ";
    print_r($cart_items_output);
    exit();
  }
  public static function addDatabaseCart($cart)
  {
    // print_r($cart->toArray());
    //exit();
    $value = $cart->toArray();
    $cart = new CartProducts();
    $cart->product_id = $value['id'];
    $cart->product_qty = $value['qty'];
    $cart->user_id = Auth::user()->id;
    $result = $cart->save();
    return $result;
  }
  public static function deleteDatabaseCart($cart){
  $delete= CartProducts::where('id',$cart)->delete();
  return $delete;
  }
  public static function updateDatabaseCart($request){
  $cartItem= CartProducts::findOrFail($request->input('cart_id'));
  $cartItem->product_qty= $request->input('product_quantity');
  $result=$cartItem->save();
  return $result;
  }
  public static function updateSessionCart(){
    $carts=CartProducts::all();
   // print_r($carts);
   // exit();
    if($carts->isNotEmpty()){
      $length=$carts->count();
      session(['cartlength' => $length]);
      session()->save();
    }else{
      session(['cartlength' => 0]);
      session()->save();
    }
   
  }
}
