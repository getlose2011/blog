<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Category;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

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
        $input = Input::except('_token');//除了token之外全部的值保存
        $rules = [
            'cate_pid' => 'required',
            'cate_name' => 'required',
        ];

        $messages = [
            'cate_pid.required' => '父級分類必須',
            'cate_name.required' => '分類名稱必填',
        ];

        $validator = Validator::make($input, $rules, $messages);
        if ($validator->passes()) {
            //https://laravel.com/docs/5.2/eloquent#mass-assignment
            //insert須在Model增加 fillable 或是 guarded 來保護Mass Assignment
            $re = Category::create($input);
            if($re){
                
                return redirect('admin/category');
            }else{
                return back()->with('errors','新增失敗');
            }
        } else{
            return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
        }
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
        $re = $cate->update();
        if($re){
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
