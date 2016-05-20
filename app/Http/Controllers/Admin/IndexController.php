<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Model\User;

class IndexController extends CommonController
{
    //

    public function index(){
        return view('admin.index');
    }

    public function info(){
        return view('admin.info');
    }

    public function pass(){
        if($input = Input::all()){//判斷表單是否提交
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];

            $messages = [
                'password.required' => '新密碼必填',
                'password.between' => '新密碼6-20位',
                'password.confirmed' => '新密碼和確認密碼不相符',
            ];

            $validator = Validator::make($input, $rules, $messages);//(驗證項目, 驗證規則, option錯誤要顯示的內容)
            if($validator->passes()){//判斷驗證是否成功
                $user = User::first();//取到第一筆資料
                if($input['password_o'] == Crypt::decrypt($user->user_pass)){

                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return redirect('admin/info');
                }else{
                    return back()->with('errors','原密碼錯誤');
                }
            }else{
                //dd($validator->errors()->all());查看全部錯誤訊息
                
                //php artisan --version看一下版本，如果是5.2.26以上的，在路由處刪除web
                return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
            }

        }else{
            return view('admin.pass');
        }

    }
    
    public function logout(){
        session(['user' => null]);
        return redirect('admin/login');
    }

}
