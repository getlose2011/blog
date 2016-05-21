<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Category;
use Illuminate\Support\Facades\Input;

class CategoryController extends CommonController
{
    //get admin/category
    public function index(){
       //第1種寫法
        //$cate = new Category();
       // $categorys_data = $cate->tree();
        //第2種寫法
        //$categorys_data = (new Category())->tree();
        //第3種寫法靜態方法
        $categorys_data = Category::tree();
        return view('admin.category.index')->with('data', $categorys_data);
    }   

    //post admin/category
    public function store(){
        $input = Input::all();
        dd($input);
    }

    //get admin/category/create
    public function create(){
        $data = Category::where('cate_pid', 0)->get();
        //dd($data);
        return view('admin.category.add', compact('data'));
    }

    //get admin/category/{category}
    public function show(){

    }

    //put admin/category/{category}
    public function update(){

    }

    //delete admin/category/{category}
    public function destroy(){

    }

    //get admin/category/{category}/edit
    public function edit(){

    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $ruslut = $cate->update();
        if($ruslut){
            $data = [
                'status' => 1,
                'message' => '儲存成功',
            ];
        }else{
            $data = [
                'status' => 0,
                'message' => '儲存失敗,請稍後再試',
            ];
        }
        return $data;
    }

}
