<?php

namespace App\Http\Controllers;
use App\CartProducts;
use App\Product;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
  //
  public function index(Request $request)
  {
    $products = Product::getUserProducts();
    CartProducts::updateSessionCart();
   // return view('user.index');
   if ($request->ajax()) {
    return view('user.productitem',["products" => $products]);
   }
    return view ('user.index',["products" => $products]);
  }
  public function productDetail($id)
  {
    $product = Product::findOrFail($id);
    return view('user.productdetail', ['product' => $product]);
  }
  public function viewProductDetail($id){
    $qty1=array(
      "id"=> "1",
      "name"=> "1"
    );
    $qty2=array(
      "id"=> "2",
      "name"=> "2"
    );
    $qty3=array(
      "id"=> "3",
      "name"=> "3"
    );
    $quantity= [$qty1,$qty2,$qty3];
     $cart = CartProducts::query()
    ->leftjoin('products as P', 'P.id', '=', 'user_product_reference.product_id')
    ->leftjoin('users as U', 'U.id', '=', 'user_product_reference.user_id')
    ->leftjoin('category as C', 'C.id', '=', 'P.category_id')
    ->where('user_product_reference.user_id',Auth::user()->id)
    ->where('user_product_reference.id',$id)
    ->first(['user_product_reference.id as ref_id', 'P.name as p_name', 'C.name as c_name', 
    'P.product_description', 'P.product_image', 'user_product_reference.product_qty as p_qty',
     'P.price as p_price', 'U.name as u_name']);
  //exit();
    return view('user.cartedit', ['product' => $cart,'qty' => $quantity]);
  }
  public function getUserProfile($id)
  {
    $admin = User::findOrFail($id);
    return view('user.userprofile', ["user" => $admin]);
  }
  public function editUserProfile(Request $request)
  {
    $admin_profile = User::findOrFail($request->input('id'));
    $admin_profile->name = $request->name;
    $url = $request->file('userImage');
    if (isset($url) && $url != '') {
      $files = $request->file('userImage');
      $folder = 'images/user/' . Auth::user()->id . '/';
      $filename = time() . $files->getClientOriginalName();
      $path = $request->file('userImage')->storeAs(
        $folder,
        $filename
      );

      $admin_profile->url =  $path;
    }
    $result = $admin_profile->save();
    if ($result == 1) {
      $message = array('message' => 'You have successfully updated User-Profile!');
      return json_encode($message);
    }
  }
  public function changeUserPassword($id)
  {
    $user = User::findOrFail($id);
    return view('user.editpassword', ["user" => $user]);
  }
  public function saveUserPassword(Request $request)
  {
    //print_r($request->input());
    //exit();
    $user = User::findOrFail($request->input('id'));
    $user->password = Hash::make($request->input('password'));
    $result = $user->save();
    if ($result == 1) {
      $message = array('message' => 'You have successfully updated User-Password!');
      return json_encode($message);
    }
  }
}
