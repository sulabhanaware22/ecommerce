<?php

namespace App\Http\Controllers;
use App\Category;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Payment;
class AdminController extends Controller
{
    //
    public function index(){
        return view('admin.index');
    }
    public function getProducts(){
    $products= Product::getProducts();
    return view('admin.products',['products' => $products]);
    }
    public function getCategories(){
    $categories= Category::getCategories();
    return view('admin.category',['categories' => $categories]);
    }
    public function saveProduct(Request $request){
    $id= $request->input('id');
    if(isset($id) && $id != ''){
    $result= Product::editProduct($request,$id);
    $message = array('message' => 'You have successfully updated product!');
    }else{
    $result= Product::addProduct($request);
    $message = array('message' => 'You have successfully added product!');
    }
    if ($result == 1) {
        return json_encode($message);
      }
    }
    public function saveCategory(Request $request){
    $id= $request->input('id');
    if(isset($id) && $id != ''){
    $result = Category::editCategory($request,$id);
    $message = array('message' => 'You have successfully edited category!');
    }else{
    $result=Category::addCategory($request);
    $message = array('message' => 'You have successfully added category!');
    }
    if ($result == 1) {
      return json_encode($message);
    }
    return $result;
    }
    public function productManage($id=''){
    $products=array();
    $categories= Category::getCategories();
    if(isset($id) && $id != ''){
    $products= Product::findOrFail($id);

    }
    return view('admin.saveproduct',["product" => $products,"category" => $categories]);
    }
    public function categoryManage($id=''){
        $categories=array();
        if(isset($id) && $id != ''){
        $categories= Category::findOrFail($id);
        }
        return view('admin.savecategory',['category' => $categories]);
    }
    public function deleteProduct($id=''){
     $result= Product::deleteProduct($id);
     $message = array('message' => 'You have successfully deleted product!');
     if ($result == 1) {
        return json_encode($message);
      }
    }
    public function deleteCategory($id=''){
    $result= Category::deleteCategory($id);
    $message = array('message' => 'You have successfully deleted product!');
    if ($result == 1) {
       return json_encode($message);
     }
    }
    public function approveCategory($id){
     $result= Category::approveCategory($id);
     $message = array('message' => 'You have successfully approved Category!');
     if ($result == 1) {
        return json_encode($message);
      }
    }
    public function disapproveCategory($id){
      $result= Category::disapproveCategory($id);
      $message = array('message' => 'You have successfully disapproved Category!');
      if ($result == 1) {
         return json_encode($message);
       }
    }
    public function getAdminProfile($id)
    {
      $admin = User::findOrFail($id);
      return view('admin.profile', ["user" => $admin]);
    }
    public function editAdminProfile(Request $request)
    {
      $admin_profile = User::findOrFail($request->input('id'));
      $admin_profile->name = $request->name;
      $url = $request->file('userImage');
      if (isset($url) && $url != '') {
        $files = $request->file('userImage');
        $folder = 'images/admin/' . Auth::user()->id . '/';
        $filename = time() . $files->getClientOriginalName();
        $path = $request->file('userImage')->storeAs(
          $folder,
          $filename
        );
  
        $admin_profile->url =  $path;
      }
      $result = $admin_profile->save();
      if ($result == 1) {
        $message = array('message' => 'You have successfully updated Admin-Profile!');
        return json_encode($message);
      }
    }
    public function changeAdminPassword($id){
      $user = User::findOrFail($id);
      return view('admin.editpassword',["user" => $user]);
    }
    public function saveAdminPassword(Request $request){
       //print_r($request->input());
    //exit();
    $user = User::findOrFail($request->input('id'));
    $user->password = Hash::make($request->input('password'));
    $result = $user->save();
    if ($result == 1) {
      $message = array('message' => 'You have successfully updated Admin-Password!');
      return json_encode($message);
    }
    }
    //payments
    public function getAdminPayments(){
      $payments= Payment::all();
      //print_r($payments->toArray());
      //exit();
      return view('admin.payments',['payments' => $payments]);
    }

}
