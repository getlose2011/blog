<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController
{
    //get admin/links
    public function index(){
        $categorys_data = Links::orderBy('link_order', 'asc')->get();
        return view('admin.links.index')->with('data', $categorys_data);
    }

    //get admin/links/create
    public function create(){
        return view('admin.links.add');
    }

    //post admin/links
    public function store(){
        $input = Input::except('_token');//除了token之外全部的值保存
        $validator = $this->checkValidator($input);
        if ($validator->passes()) {
            //https://laravel.com/docs/5.2/eloquent#mass-assignment
            //insert須在Model增加 fillable 或是 guarded 來保護Mass Assignment
            $re = Links::create($input);
            if($re){
                return redirect('admin/links');
            }else{
                return back()->with('errors','新增失敗');
            }
        } else{
            return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
        }
    }

    //get admin/links/{links}/edit
    public function edit($links_id){
        $data = Links::find($links_id);//find()找主鍵的值
        return view('admin.links.add')->with('data', $data);
    }

    //put admin/links/{links}
    public function update($link_id){
        $input = Input::except('_token', '_method');//除了token之外全部的值保存
        $validator = $this->checkValidator($input);
        if ($validator->passes()) {
            $re = Links::where('link_id', $link_id)->update($input);// update 特別要注意 where判斷
            if($re){
                return redirect('admin/links');
            }else{
                return back()->with('errors','修改失敗');
            }
        }else{
            return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
        }
    }

    //delete admin/links/{link_id}
    public function destroy($link_id){
        $re = Links::where('link_id', $link_id)->delete();
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
        $link = Links::find($input['link_id']);
        $link->link_order = $input['link_order'];
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
            'link_name' => 'required',
            'link_url' => 'required',
        ];

        $messages = [
            'link_name.required' => '友情名稱必填',
            'link_url.required' => '友情連結必填',
        ];
        return Validator::make($input, $rules, $messages);
    }

}
