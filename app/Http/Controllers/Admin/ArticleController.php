<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //
    //get admin/article
    public function index(){
        //分頁 Pagination
        $data = Article::orderBy('art_id','desc')->paginate(5);
       return view('admin.article.index', compact('data'));
    }

    //get admin/article/create
    public function create(){
        $cate_id_arr = (new Category())->tree();
        return view('admin.article.add', compact('cate_id_arr'));
    }

    //post admin/article/
    public function store(){
        $input = Input::except('_token');
        $input['art_time'] = time();
        $validator = $this->checkValidator($input);
        if ($validator->passes()) {
            //https://laravel.com/docs/5.2/eloquent#mass-assignment
            //insert須在Model增加 fillable 或是 guarded 來保護Mass Assignment
            $re = Article::create($input);
            if($re){
                return redirect('admin/article');
            }else{
                return back()->with('errors','新增失敗');
            }
        } else{
            return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
        }
    }

    //判斷 input 裡的 Validator::make
    private function checkValidator($input){
        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
        ];

        $messages = [
            'art_title.required' => '文章標題請填寫',
            'art_content.required' => '內容請填寫',
        ];
        return Validator::make($input, $rules, $messages);
    }

}
