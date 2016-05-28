<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends CommonController
{
    //get admin/navs
    public function index(){
        $categorys_data = Navs::orderBy('nav_order', 'asc')->get();
        return view('admin.navs.index')->with('data', $categorys_data);
    }

    //get admin/navs/create
    public function create(){
        return view('admin.navs.add');
    }

    //post admin/navs
    public function store(){
        $input = Input::except('_token');//除了token之外全部的值保存
        $validator = $this->checkValidator($input);
        if ($validator->passes()) {
            //https://laravel.com/docs/5.2/eloquent#mass-assignment
            //insert須在Model增加 fillable 或是 guarded 來保護Mass Assignment
            $re = Navs::create($input);
            if($re){
                return redirect('admin/navs');
            }else{
                return back()->with('errors','新增失敗');
            }
        } else{
            return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
        }
    }

    //get admin/navs/{navs}/edit
    public function edit($navs_id){
        $data = Navs::find($navs_id);//find()找主鍵的值
        return view('admin.navs.add')->with('data', $data);
    }

    //put admin/navs/{navs}
    public function update($nav_id){
        $input = Input::except('_token', '_method');//除了token之外全部的值保存
        $validator = $this->checkValidator($input);
        if ($validator->passes()) {
            $re = Navs::where('nav_id', $nav_id)->update($input);// update 特別要注意 where判斷
            if($re){
                return redirect('admin/navs');
            }else{
                return back()->with('errors','修改失敗');
            }
        }else{
            return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
        }
    }

    //delete admin/navs/{nav_id}
    public function destroy($nav_id){
        $re = Navs::where('nav_id', $nav_id)->delete();
        if($re){
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

    //ajax 友情連結排序
    public function changeOrder()
    {
        $input = Input::all();
        $link = Navs::find($input['nav_id']);
        $link->nav_order = $input['nav_order'];
        $re = $link->update();
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
            'nav_name' => 'required',
            'nav_url' => 'required',
        ];

        $messages = [
            'nav_name.required' => '導航名稱必填',
            'nav_url.required' => '導航連結必填',
        ];
        return Validator::make($input, $rules, $messages);
    }

}
