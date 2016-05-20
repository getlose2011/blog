<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Category;

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

    }

    //get admin/category/create
    public function create(){

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

}
