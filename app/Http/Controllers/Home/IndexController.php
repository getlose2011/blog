<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Links;
use App\Http\Model\Category;

class IndexController extends CommonController
{
    //
    public function index(){
        //點擊量最高的6篇文章（站長推薦）
        $pics = Article::orderBy('art_view','desc')->take(6)->get();

        //點擊量最高的6篇文章
        $hot = Article::orderBy('art_view','desc')->take(5)->get();

        //最新發佈文章8篇
        $new = Article::orderBy('art_time','desc')->take(8)->get();

        //圖文列表5篇（帶分頁）
        $data = Article::orderBy('art_time','desc')->paginate(5);

        //友情連接
        $links = Links::orderBy('link_order','asc')->get();


        return view('home.index', compact('hot','new','pics','data','links'));
    }

    public function cate($cate_id){
        //圖文列表4篇（分頁）
        $data = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);

        //查看次數自增
        Category::where('cate_id',$cate_id)->increment('cate_view');

        //子分類
        $submenu = Category::where('cate_pid',$cate_id)->get();

        $field = Category::find($cate_id);
        return view('home.list',compact('field','data','submenu'));
    }

    public function article($art_id){
        //Join查詢 inner join
        $field = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();

        //查看次數自增
        Article::where('art_id',$art_id)->increment('art_view');
        
        //前一篇
        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        
        //後一篇
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();

        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();

        return view('home.new',compact('field','article','data'));
    }

}
