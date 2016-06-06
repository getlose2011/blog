<?php

namespace App\Http\Controllers\Home;

//use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Http\Model\Article;
use App\Http\Controllers\Controller;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    //
    public function __construct()
    {
        //點擊量最高的6篇文章
        $hot = Article::orderBy('art_view','desc')->take(5)->get();

        //最新發佈文章8篇
        $new = Article::orderBy('art_time','desc')->take(8)->get();

        $navs = Navs::all();

        //所有視圖view共用資料
        View::share('navs',$navs);
        View::share('hot',$hot);
        View::share('new',$new);
    }
}
