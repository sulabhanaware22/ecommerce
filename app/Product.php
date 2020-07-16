<?php
namespace App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\AddProductAdmin;
use App\Mail\EditProductAdmin;
use App\Mail\DeleteProductAdmin;
class Product extends Model
{
    protected $table="products";
    public static function getProducts(){
    $result= Product::query()
             ->leftjoin('category as C', 'C.id', '=', 'products.category_id')
             ->where('products.deleted_flag',0)
             ->where('c.status',1)
             ->get(['products.id as pid','products.name as pname','c.name as cname','products.product_description','products.product_image']);
  // print_r($result->toArray()); exit();
             return $result;
  
    }
    public static function getUserProducts($page=''){  
      $result= Product::query()
               ->leftjoin('category as C', 'C.id', '=', 'products.category_id')
               ->where('products.deleted_flag',0)
               ->where('c.status',1)
              //  ->skip($page* config('constants.PAGINATION_COUNT'))
              //  ->take(config('constants.PAGINATION_COUNT'))
               ->select(['products.id as pid','products.name as pname','products.price as price',
               'c.name as cname','products.product_description','products.product_image'])->paginate(10);
    // print_r($result->toArray()); exit();
               return $result;
      }
    public static function getProduct($id){
    $result= Product::findOrFail($id);
    return $result;
    }
    public static function addProduct($request){
       // print_r($request->input());
       // exit();
    $product= new Product();
    $product->category_id= $request->input('productCategory');
    $product->name=$request->input('productTitle');
    $product->price=$request->input('productPrice');
    $product->total_quantity=$request->input('productQuantity');
  //  $product->remain_quantity=$request->input('remain_quantity');
    $product->product_description =$request->input('productDescription');
    $url = $request->file('productImage');
    if (isset($url) && $url != '') {
      $files = $request->file('productImage');
      $folder = 'images/products/' . $request->input('productCategory'). '/';
  
      $filename = time() . $files->getClientOriginalName();
      $path = $request->file('productImage')->storeAs(
        $folder,
        $filename
      );

      $product->product_image =  $path;
    }
    $result=$product->save();
    if($result == 1){
      //send mail
      $emailTo=Auth::user()->email;
      Mail::to($emailTo)->send(new AddProductAdmin($product));
      //end
    }
    return $result;
    }
    public static function editProduct($request,$id){
        $product= Product::findOrFail($id);
        $product->category_id= $request->input('productCategory');
        $product->name=$request->input('productTitle');
        $product->price=$request->input('productPrice');
        $product->total_quantity=$request->input('productQuantity');
        $product->product_description =$request->input('productDescription');
        $url = $request->file('productImage');
        if (isset($url) && $url != '') {
          $files = $request->file('productImage');
          $folder = 'images/products/' . $request->input('productCategory'). '/';
          $filename = time() . $files->getClientOriginalName();
          $path = $request->file('productImage')->storeAs(
            $folder,
            $filename
          );
    
          $product->product_image =  $path;
        }
        $result=$product->save();
        if($result == 1){
          //send mail
          $emailTo=Auth::user()->email;
          Mail::to($emailTo)->send(new EditProductAdmin($product));
          //end
        }
        return $result;
    }
    public static function deleteProduct($id=''){
        $product= Product::findOrFail($id);
        $product->deleted_flag=1;
        $result=$product->save();
        if($result == 1){
          //send mail
          $emailTo=Auth::user()->email;
          Mail::to($emailTo)->send(new DeleteProductAdmin($product));
          //end
        }
        return $result;
    }
    public function getProductImageAttribute($value)
    {
      //  return 'http://127.0.0.1:8000/storage/'.$value;
      if(isset($value) && $value != ''){
        return config('constants.IMAGE_PATH').$value;
      }
    }
    public function Category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
