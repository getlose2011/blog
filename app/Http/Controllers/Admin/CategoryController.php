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

    //get admin/category/{category}
    public function show(){

    }

    //post admin/category
    public function store(){
        $input = Input::except('_token');//除了token之外全部的值保存
        $validator = $this->checkValidator($input);
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
        $cate_id_arr = Category::where('cate_pid', 0)->get();
        return view('admin.category.add', compact('cate_id_arr'));
    }

    //get admin/category/{category}/edit
    public function edit($cate_id){
        $cate_id_arr = Category::where('cate_pid', 0)->get();
        $data = Category::find($cate_id);//find()找主鍵的值
        return view('admin.category.add', compact('data', 'cate_id_arr'));
    }

    //put admin/category/{category}
    public function update($cate_id){
        $input = Input::except('_token', '_method');//除了token之外全部的值保存
        if($input['cate_pid'] == $cate_id){
            return back()->with('errors','父級分類名稱不能指到分類名稱');
        }  
        $validator = $this->checkValidator($input);
        if ($validator->passes()) {
            $re = Category::where('cate_id', $cate_id)->update($input);// update 特別要注意 where判斷
            if($re){
                return redirect('admin/category');
            }else{
                return back()->with('errors','修改失敗');
            }
        }else{
            return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
        }
    }

    //delete admin/category/{category}
    public function destroy($cate_id){
        $re = Category::where('cate_id', $cate_id)->delete();
        if($re){
            Category::where('cate_pid', $cate_id)->update(['cate_pid'=>0]);
            $data = [
                'status' => 0,
                'message' => '刪除成功',
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '刪除失敗,請稍後再試',
            ];
        }
        return $data;
    }

    //ajax 文章排序
    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $re = $cate->update();
        if($re){
            $data = [
                'status' => 0,
                'message' => '儲存成功',
            ];
        }else{
            $data = [
                'status' => 1,
                'message' => '儲存失敗,請稍後再試',
            ];
        }
        return $data;
    }

    //判斷 input 裡的 Validator::make
    private function checkValidator($input){
        $rules = [
            'cate_name' => 'required',
        ];

        $messages = [
            'cate_name.required' => '分類名稱必填',
        ];
        return Validator::make($input, $rules, $messages);
    }

}
