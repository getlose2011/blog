<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
//use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\Http\Model\User;

require_once ('resources/org/code/Code.class.php');//引入第三方的code

class LoginController extends CommonController
{
    public function login(){
        if($input = Input::all()){//判斷表單是否提交
            $code = new \code;
            $_code = $code->get();
            if($input['code'] != $_code){
                return back()->with('msg','驗證碼錯誤');//回上頁並給值要用session('msg')接收
            }
            $user = User::first();//取到第一筆資料
            if($user->user_name != $input['user_name'] || Crypt::decrypt($user->user_pass) != $input['password']){
                return back()->with('msg','帳號或密碼有誤');//回上頁並給值要用session('msg')接收
            }
            session(['user' => $user]);
            dd(session('user'));
        }else{
            return view('admin.login');
        }
    }

    //圖片驗證碼
    public function code(){
        $code = new \code;
        echo $code->make();
    }

}
