<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
//use App\Http\Requests;
require_once ('resources/org/code/Code.class.php');//引入第三方的code

class LoginController extends CommonController
{
    //

    public function login(){
//        $pdo = DB::connection()->getPdo();
//        dd($pdo);
        return view('admin.login');
    }

    public function code(){
        $code = new \code;//從底層去方找
        echo $code->make();
    }

    public function getcode(){
        $code = new \code;//從底層去方找
        echo $code->get();
    }

}
