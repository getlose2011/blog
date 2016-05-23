<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Category;
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

    //get admin/article/create
    public function create(){
        $cate_id_arr = (new Category())->tree();
        return view('admin.article.add', compact('cate_id_arr'));
    }

}
