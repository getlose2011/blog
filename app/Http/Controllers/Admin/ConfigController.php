<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController
{
    //get admin/config
    public function index(){
        $categorys_data = Config::orderBy('conf_order', 'asc')->get();
        return view('admin.config.index')->with('data', $categorys_data);
    }

    //get admin/config/create
    public function create(){
        return view('admin.conf.add');
    }

    //post admin/config
    public function store(){
        $input = Input::except('_token');//除了token之外全部的值保存
        $validator = $this->checkValidator($input);
        if ($validator->passes()) {
            //https://laravel.com/docs/5.2/eloquent#mass-assignment
            //insert須在Model增加 fillable 或是 guarded 來保護Mass Assignment
            $re = Config::create($input);
            if($re){
                return redirect('admin/config');
            }else{
                return back()->with('errors','新增失敗');
            }
        } else{
            return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
        }
    }

    //get admin/config/{config}/edit
    public function edit($config_id){
        $data = Config::find($config_id);//find()找主鍵的值
        return view('admin.config.add')->with('data', $data);
    }

    //put admin/config/{config}
    public function update($conf_id){
        $input = Input::except('_token', '_method');//除了token之外全部的值保存
        $validator = $this->checkValidator($input);
        if ($validator->passes()) {
            $re = Config::where('conf_id', $conf_id)->update($input);// update 特別要注意 where判斷
            if($re){
                return redirect('admin/config');
            }else{
                return back()->with('errors','修改失敗');
            }
        }else{
            return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
        }
    }

    //delete admin/config/{conf_id}
    public function destroy($conf_id){
        $re = Config::where('conf_id', $conf_id)->delete();
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

    //ajax 配置項目排序
    public function changeOrder()
    {
        $input = Input::all();
        $link = Config::find($input['conf_id']);
        $link->conf_order = $input['conf_order'];
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
            'conf_name' => 'required',
            'conf_url' => 'required',
        ];

        $messages = [
            'conf_name.required' => '導航名稱必填',
            'conf_url.required' => '導航連結必填',
        ];
        return Validator::make($input, $rules, $messages);
    }

}
