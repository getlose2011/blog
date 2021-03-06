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

    //get admin/article/{article}/edit
    public function edit($art_id){
        $cate_id_arr = Category::tree();
        $data = Article::find($art_id);//find()找主鍵的值
        return view('admin.article.add', compact('data', 'cate_id_arr'));
    }

    //put admin/article/{article}
    public function update($art_id){
//        $input = Input::except('_token', '_method');//除了token, method之外全部的值保存
//        $validator = $this->checkValidator($input);
//
//        if ($validator->passes()) {
//            $re = Article::where('art_id', $art_id)->update($input);// update 特別要注意 where判斷
//            if($re){
//                return redirect('admin/article');
//            }else{
//                return back()->with('errors','文章修改失敗');
//            }
//        }else{
//            return back()->withErrors($validator);//回傳錯誤訊息給上頁變數為$errors
//        }
        $input = Input::except('_token','_method');
        $re = Article::where('art_id',$art_id)->update($input);
        if($re){
            return redirect('admin/article');
        }else{
            return back()->with('errors','文章更新失败，请稍后重试！');
        }
    }

    //delete admin/article/{article}
    public function destroy($art_id){
        $re = Article::where('art_id', $art_id)->delete();
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
