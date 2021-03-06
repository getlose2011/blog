@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首頁</a> &raquo; 全部分類
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>分類管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增分類</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>分類列表</a>
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
                        <th>分類名稱</th>
                        <th>標題</th>
                        <th>查看次數</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" name="ord[]" onchange="changeOrder(this, '{{$v->cate_id}}');" value="{{$v->cate_order}}">
                            </td>
                            <td class="tc">{{$v->cate_id}}</td>
                            <td>
                                <a href="#">{{$v->_cate_name}}</a>
                            </td>
                            <td>
                                <a href="#">{{$v->cate_title}}</a>
                            </td>
                            <td>
                                <a href="#">{{$v->cate_view}}</a>
                            </td>
                            <td>
                                <a href="{{url('admin/category/'.$v->cate_id)}}/edit">修改</a>
                                <a href="javascript:delCate('{{$v->cate_id}}');">删除</a>
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
        function changeOrder(obj, cate_id) {
            $.post('{{url('admin/cate/changeorder')}}',{'_token':'{{csrf_token()}}', 'cate_order':obj.value, 'cate_id':cate_id}, function(data){
                if(data.status == 0){
                    layer.alert(data.message, {icon: 6});
                }else{
                    layer.alert(data.message, {icon: 5});
                }
            });
        }

        //删除
        function delCate(cate_id) {
            layer.confirm('確定刪除嗎？', {
                btn: ['刪除','取消']
            }, function(){
                $.post('{{url('admin/category')}}/'+cate_id, {'_method':'DELETE', '_token':'{{csrf_token()}}', 'cate_id':cate_id}, function(data){
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