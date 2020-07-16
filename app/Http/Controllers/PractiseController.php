<?php
namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;
class PractiseController extends Controller
{
    //
    public function practise1(){
    //  $category= Category::all();
      //print_r($category->toArray());
      //exit();
      return view('practise.practise1');
      exit(); 
    }
    public function loadAjaxTable(Request $request)
    {
       // echo "inside";
        //exit();
        $data = Category::paginate(5);
        if ($request->ajax()) {
            echo "inside";
            return view('practise.presult', compact('data'));
        }
        echo "outside";
        return view('practise.practise1',compact('data'));
    }
}
