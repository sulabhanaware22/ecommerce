<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    //
    protected $table="category";
    public static function getCategories(){
    $result= Category::where('deleted_flag',0)->get();
    return $result;
    }
    public static function getCategory($id=''){
    $result= Category::findOrFail($id);
    return $result;
    }
    public static function addCategory($request){
    $category= new Category();
    $category->name= $request->input('categoryName');
    $result=$category->save();
    return $result;
    }
    public static function editCategory($request,$id){
        $category= Category::findOrFail($id);
        $category->name= $request->input('categoryName');
        $result=$category->save();
        return $result;
    }
    public static function deleteCategory($id){
        $category= Category::findOrFail($id);
        $category->deleted_flag=1;
        $result=$category->save();
        return $result;
    }
    public static function approveCategory($id){
        $category= Category::findOrFail($id);
        $category->status=1;
        $result=$category->save();
        return $result;
    }
    public static function disapproveCategory($id){
        $category= Category::findOrFail($id);
        $category->status=0;
        $result=$category->save();
        return $result;
    }
}
