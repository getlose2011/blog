<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;

//use App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //
    public function upload(){
        $file = Input::file('Filedata');//file方法為取得文件裡的訊息
        if($file -> isValid()){
            //$realPath = $file -> getRealPath();//暫時文件的絕對路徑
            $entension = $file -> getClientOriginalExtension(); //上傳文件的副檔名
            //$mimeTye = file -> getMimeType(); 文件的類型 例如image/jpeg
            $real_name = date("YmdHis").mt_rand(100, 999).'.'.$entension;
            //base_path()根目錄
            $path = $file -> move(base_path().'/uploads', $real_name);
            return 'uploads/'.$real_name;
        }
    }
}
