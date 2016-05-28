@extends('layouts.admin')
@section('content')
    <!-​​-麵包屑導航 開始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 歡迎使用登陸網站後台，建站的首選工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首頁</a> &raquo; {{!isset($data)?'新增自訂義導航':'編輯自訂義導航'}}
    </div>
    <!-​​-麵包屑導航 結束-->
    <!-​​-結果集標題與導航組件 開始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>自訂義導航管理</h3>
            @if(count($errors) > 0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @else
                        {{$errors}}
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>新增導航</a>
                <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>導航列表</a>
            </div>
        </div>
    </div>
	<!--結果集標題與導航組件 結束-->
    <div class="result_wrap">
        @if(!isset($data))
            <form action="{{url('admin/navs')}}" method="post">
        @else
            <form action="{{url('admin/navs/'.$data->nav_id)}}" method="post">
            <input type="hidden" name="_method" value="put" />
        @endif
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                         <th><i class="require">*</i>導航名稱：</th>
                        <td>
                            <input type="text" name="nav_name" value="{{isset($data)?$data->nav_name:''}}" />
                            <input type="text" name="nav_alias" value="{{isset($data)?$data->nav_alias:''}}" />
                            <span><i class="fa fa-exclamation-circle yellow"></i>導航名稱必須填寫</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>URL：</th>
                         <td>
                            <input type="text" class="lg" name="nav_url" value="{{isset($data)?$data->nav_url:'http://'}}" />
                          </td>
                    </tr>                                     
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="nav_order" value="{{isset($data)?$data->nav_order:0}}" />
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </input>
    </div>
@endsection