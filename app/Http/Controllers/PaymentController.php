<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Charge;
use App\CartProducts;
use App\Payment;
use App\Order;
class PaymentController extends Controller
{
    //
    public function index()
    {
        $carts= CartProducts::getCartItems();
        if($carts->isNotEmpty()){
            return view('user.payment',['carts' => $carts]);
          }else{
            Session::flash('paymentview', 'No items in cart..Please add some..continue with shopping!');
            return back();
          }
        
    }
    public function userCheckout(Request $request)
    {
       //
      // print_r($request->input());exit();
      // Stripe::setApiKey(env('STRIPE_SECRET'));
      Stripe::setApiKey(env('STRIPE_SECRET'));


        $charge=Charge::create([
            // 'name' => 'test',
            "amount" => ($request->price) * 100,
            "currency" => "inr",
            "source" => $request->stripeToken,
            "description" => "Test payment",
            // "address" => ["city" => "nagpur", "country" =>"india", "line1" => "33,cghs layout,gajanan dham", "line2" => "", "postal_code" => "440025", "state" => "maharashtra"]
        ]);
      // print_r($charge->balance_transaction);
        //exit();
        //add items to order table
        $carts= CartProducts::all();
        $id=array();
        foreach($carts as $value){
          $id[]= $value->product_id;
        }
        $product_id= implode(",",$id);
        $order=array();
        if(isset($product_id)){
          $order['product_id']= $product_id;
        }
        $order['price']= $request->price;
        Order::addOrders($order);
      //  print_r($product_id);
        //exit();
        //end
        //empty the carts table
        CartProducts::query()->truncate();
        //generate a transcation id and insert into payment table
        if(isset($charge->balance_transaction) && $charge->balance_transaction){
          $payment = array(
           "price"=> $request->price,
           "transaction_id" => $charge->balance_transaction
          );
          Payment::insertTransactionDetails($payment);
        }
        //end
        session()->flash('paymentmessage', 'Payment successful!Please continue shopping with more goods!');
        return redirect()->route('user-dashboard');
    }
}
