@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首頁</a> &raquo; 全部友情連結
    </div>
    <!--面包屑导航 结束-->


    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>友情連結列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>新增友情連結</a>
                    <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>友情連結列表</a>
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
                        <th>連結標題</th>
                        <th>連結網址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" name="ord[]" onchange="changeOrder(this, '{{$v->link_id}}');" value="{{$v->link_order}}">
                            </td>
                            <td class="tc">{{$v->link_id}}</td>
                            <td>
                                <a href="#">{{$v->link_name}}</a>
                            </td>
                            <td>
                                <a href="#">{{$v->link_title}}</a>
                            </td>
                            <td>
                                <a href="#">{{$v->link_url}}</a>
                            </td>
                            <td>
                                <a href="{{url('admin/links/'.$v->link_id)}}/edit">修改</a>
                                <a href="javascript:delLink('{{$v->link_id}}');">删除</a>
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
        function changeOrder(obj, link_id) {
            $.post('{{url('admin/links/changeorder')}}',{'_token':'{{csrf_token()}}', 'link_order':obj.value, 'link_id':link_id}, function(data){
                if(data.status == 0){
                    layer.alert(data.message, {icon: 6});
                }else{
                    layer.alert(data.message, {icon: 5});
                }
            });
        }

        //删除
        function delLink(link_id) {
            layer.confirm('確定刪除嗎？', {
                btn: ['刪除','取消']
            }, function(){
                $.post('{{url('admin/links')}}/'+link_id, {'_method':'DELETE', '_token':'{{csrf_token()}}', 'link_id':link_id}, function(data){
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