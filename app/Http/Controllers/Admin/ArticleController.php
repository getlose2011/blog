<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArticleController extends CommonController
{
    //
    //get admin/article
    public function index(){
       // $category_data = array();
       // return view('admin.article.index')->with('data', $categorys_data);
    }

    //get admin/article/{article}/edit
    public function create(){
        $cate_id_arr = array();
        return view('admin.article.add', compact('cate_id_arr'));
    }

}
