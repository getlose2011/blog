<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::any('/','Home\IndexController@index');
Route::any('/cate/{cate_id}','Home\IndexController@cate');
Route::get('/a/{art_id}', 'Home\IndexController@article');

Route::any('admin/login','Admin\LoginController@login');
Route::get('admin/code','Admin\LoginController@code');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware'=>'adminlogin'], function () {
    Route::get('index','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('logout','IndexController@logout');
    Route::any('pass','IndexController@pass');
    Route::post('cate/changeorder','CategoryController@changeOrder');
    Route::resource('category', 'CategoryController');//資源控制器路由
    Route::resource('article', 'ArticleController');//資源控制器路由
    Route::resource('links', 'LinksController');//資源控制器路由
    Route::post('links/changeorder','LinksController@changeOrder');
    Route::resource('navs', 'NavsController');//資源控制器路由
    Route::post('navs/changeorder','NavsController@changeOrder');

    Route::get('config/putfile', 'ConfigController@putFile');
    Route::resource('config', 'ConfigController');//資源控制器路由
    Route::post('config/changecontent', 'ConfigController@changecontent');//列表頁送出
    Route::post('config/changeorder', 'ConfigController@changeOrder');



    Route::any('upload','CommonController@upload');
});