@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首頁</a> &raquo; 全部自訂義導航
    </div>
    <!--面包屑导航 结束-->


    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>自訂義導航列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>新增自訂義導航</a>
                    <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>自訂義導航列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>連結名稱</th>
                        <th>連結別名</th>
                        <th>連結網址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" name="ord[]" onchange="changeOrder(this, '{{$v->nav_id}}');" value="{{$v->nav_order}}">
                            </td>
                            <td class="tc">
                                {{$v->nav_id}}
                            </td>
                            <td>
                                {{$v->nav_name}}
                            </td>
                            <td>
                                {{$v->nav_alias}}
                            </td>
                            <td>
                                {{$v->nav_url}}
                            </td>
                            <td>
                                <a href="{{url('admin/navs/'.$v->nav_id)}}/edit">修改</a>
                                <a href="javascript:delNav('{{$v->nav_id}}');">删除</a>
                                <!--<a href="javascript:;" onclick="delCate({{$v->cate_id}})">删除</a>另一個寫法-->
                            </td>
                        </tr>
                    @endforeach
                </table>


                <div class="page_nav">
                    <div>

                    </div>
                </div>
                <div class="page_list">
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(obj, nav_id) {
            $.post('{{url('admin/navs/changeorder')}}',{'_token':'{{csrf_token()}}', 'nav_order':obj.value, 'nav_id':nav_id}, function(data){
                if(data.status == 0){
                    layer.alert(data.message, {icon: 6});
                }else{
                    layer.alert(data.message, {icon: 5});
                }
            });
        }

        //删除
        function delNav(nav_id) {
            layer.confirm('確定刪除嗎？', {
                btn: ['刪除','取消']
            }, function(){
                $.post('{{url('admin/navs')}}/'+nav_id, {'_method':'DELETE', '_token':'{{csrf_token()}}', 'nav_id':nav_id}, function(data){
                    if(data.status == 0){
                        layer.alert(data.message, {icon: 6});
                        location.href = location.href;//刷新頁面
                    }else{
                        layer.alert(data.message, {icon: 5});
                    }
                });
            });
        }
    </script>
@endsection