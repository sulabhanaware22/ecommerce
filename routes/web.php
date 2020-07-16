<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Pending Tasks:
1. Generate a pdf in the order history
2. Insert the entry in the payment table
3. In Admin panel show the payments done
4. Push the code to git
5. Host the project on live server
*/
// https://github.com/syscover/shopping-cart
// https://packagist.org/packages/hardevine/shoppingcart
//stripe-php support
//composer require stripe/stripe-php
//STRIPE_KEY=pk_test_51H3RuoLKFniVBIvy73zQsZtuAS6cjbHqmoodwFgSVZi1fpHWZx4b3RRkRhF3BoKEiG3R4TkvbLQmetHgaSkD1XTa00oOzeZRH7
//STRIPE_SECRET=sk_test_51H3RuoLKFniVBIvy9RQKZCfBeaahJBVC5DUcU4CnHuDqRaFg8m2hjAzAVKScSZBgVm2tdtfXpIKpWsld4dw1O7Ee00IzhA9mHz
Auth::routes();
Route::get('/', function () {
  // echo "inside";
  //exit();
  //  Auth::logout();
  return redirect('/login');
});
Route::get('/practise1','PractiseController@practise1');
Route::get('/load_ajax_table','PractiseController@loadAjaxTable');
//middleware logic
Route::prefix('admin')->middleware(['admin', 'auth'])->group(function () {
  Route::get('/dashboard', 'AdminController@index')->name('admin-dashboard');
  Route::get('/adminprofile/{id}', 'AdminController@getAdminProfile')->name('admin-profile');
  Route::post('/editadminprofile', 'AdminController@editAdminProfile')->name('edit-adminprofile');
  Route::post('/saveadminpassword', 'AdminController@saveAdminPassword')->name('save-adminpassword');
  Route::get('/changeadminpassword/{id}', 'AdminController@changeAdminPassword')->name('change-adminpassword');
  Route::get('/products', 'AdminController@getProducts')->name('get-products');
  Route::get('/categories', 'AdminController@getCategories')->name('get-categories');
  Route::post('/saveproduct', 'AdminController@saveProduct')->name('save-product');
  Route::post('/savecategory', 'AdminController@saveCategory')->name('save-category');
  Route::get('/productmanage/{id?}', 'AdminController@productManage')->name('product-manage');
  Route::get('/categorymanage/{id?}', 'AdminController@categoryManage')->name('category-manage');
  Route::delete('/deleteproduct/{id}', 'AdminController@deleteProduct')->name('delete-product');
  Route::delete('/deletecategory/{id}', 'AdminController@deleteCategory')->name('delete-category');
  Route::get('/approve/{id}', 'AdminController@approveCategory');
  Route::get('/disapprove/{id}', 'AdminController@disapproveCategory');
  Route::get('/payments','AdminController@getAdminPayments')->name('user-payments');
});
Route::prefix('user')->middleware(['user', 'auth'])->group(function () {
  Route::get('/dashboard', 'UserController@index')->name('user-dashboard');
  // Route::get('/onloadproducts/{id}', 'UserController@index')->name('user-dashboard');
  Route::get('/userprofile/{id}', 'UserController@getUserProfile')->name('user-profile');
  Route::post('/edituserprofile', 'UserController@editUserProfile')->name('edit-userprofile');
  Route::post('/saveuserpassword', 'UserController@saveUserPassword')->name('save-userpassword');
  Route::get('/changeuserpassword/{id}', 'UserController@changeUserPassword')->name('change-userpassword');
  Route::get('/productdetail/{id}', 'UserController@productDetail')->name('product-detail');
  Route::get('/editcart/{id}', 'UserController@viewProductDetail')->name('edit-cart-detail');
  Route::get('/carts', 'CartController@index')->name('user-cart');
  Route::post('/addcartitem', 'CartController@addCartItem')->name('add-cart');
  Route::post('/editcartitem', 'CartController@editCartItem')->name('edit-cart');
  Route::delete('/deletecartitem/{id}', 'CartController@deleteCartItem')->name('delete-cartitem');
  Route::get('/orders', 'OrderHistoryController@index')->name('user-order');
  Route::get('/payment', 'PaymentController@index')->name('user-payment');
  Route::post('/checkout', 'PaymentController@userCheckout')->name('user-checkout');
  Route::get('/orderhistory/{id}','OrderHistoryController@orderHistory')->name('order-history');
});