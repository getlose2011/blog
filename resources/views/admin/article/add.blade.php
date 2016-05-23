@extends('layouts.admin')
@section('content')
    <!-​​-麵包屑導航 開始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 歡迎使用登陸網站後台，建站的首選工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首頁</a> &raquo; {{!isset($data)?'新增文章分類':'編輯文章分類'}}
    </div>
    <!-​​-麵包屑導航 結束-->
    <!-​​-結果集標題與導航組件 開始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>文章管理</h3>
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
                            <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
                        </div>
        </div>
    </div>
    <!--結果集標題與導航組件 結束-->
    <div class="result_wrap">
        @if(!isset($data))
            <form action="{{url('admin/category')}}" method="post">
                @else
                    <form action="{{url('admin/category/'.$data->cate_id)}}" method="post">
                        <input type="hidden" name="_method" value="put" />
                        @endif
                        {{csrf_field()}}
                        <table class="add_tab">
                            <tbody>
                                 <tr>
                                     <th width="120">分類：</th>
                                     <td>
                                        <select name="cate_id">
                                            @foreach($cate_id_arr as $v)
                                                <?php
                                                $selected = '';
                                                if(isset($data) && $data->cate_id == $v->cate_id){
                                                    $selected = ' selected';
                                                }
                                                ?>
                                                <option value="{{$v->cate_id}}" {{$selected}}>{{$v->_cate_name}}</option>
                                            @endforeach
                                        </select>
                                     </td>
                                </tr>
                                <tr>
                                    <th>文章標題：</th>
                                    <td>
                                        <input type="text" class="lg" name="cate_title" value="{{isset($data)?$data->cate_title:''}}" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>編輯：</th>
                                    <td>
                                        <input type="text" class="lg" name="" value="{{isset($data)?$data->art_editor:''}}" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>縮略圖：</th>
                                    <td>
                                        <style>
                                            .uploadify{display:inline-block;}
                                            .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                                            table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                                        </style>
                                        <link rel="stylesheet" type="text/css" href="{{asset('resources/org/uploadify/uploadify.css')}}">
                                        <script src="{{asset('resources/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                                        <input type="text" class="lg" name="" value="{{isset($data)?$data->art_thumb:''}}" />
                                        <script type="text/javascript">
                                            <?php $timestamp = time();?>
                                            $(function() {
                                                $('#file_upload').uploadify({
                                                    'buttonText' : '上傳檔案',
                                                    'formData'     : {
                                                        'timestamp' : '<?php echo $timestamp;?>',
                                                        '_token'     : '{{csrf_token()}}'
                                                    },
                                                    'swf'      : '{{asset('resources/org/uploadify/uploadify.swf')}}',
                                                    'uploader' : '{{url('admin/upload')}}'
                                                });
                                            });
                                        </script>
                                        <input id="file_upload" name="file_upload" type="file" multiple="true">
                                     </td>
                                </tr>
                                <tr>
                                    <th>關鍵字：</th>
                                    <td>
                                        <textarea name="cate_keywords">{{isset($data)?$data->cate_keywords:''}}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th>描述：</th>
                                    <td>
                                        <textarea name="cate_description">{{isset($data)?$data->cate_description:''}}</textarea>
                                     </td>
                                </tr>
                                <tr>
                                    <th>文章內容：</th>
                                    <td>
                                        <style>
                                            .edui-default{line-height: 28px;}
                                            div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                                            {overflow: hidden; height:20px;}
                                            div.edui-box{overflow: hidden; height:22px;}
                                        </style>
                                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
                                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
                                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh.js')}}"></script>
                                        <script id="editor" name="art_content" type="text/plain" style="width:700px;height:400px;"></script>
                                        <script type="text/javascript">var ue = UE.getEditor('editor');</script>
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
            </form>
    </div>
@endsection