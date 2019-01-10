@extends('layout.bst')

@section('content')
    <table class="table table-hover">
        <h2>购物车页面</h2>
        <tr class="success">
            <td>ID</td>
            <td>商品名称</td>
            <td>购买数量</td>
            <td>总价格</td>
            <td>添加时间</td>
            <td>操作</td>
        </tr>
        @foreach($list as $k=>$v)
            <tr class="warning">
                <td>{{$v->id}}</td>
                <td>{{$v->goods_name}}</td>
                <td>{{$v->num}}</td>
                <td>{{$v->goods_price}}</td>
                <td>{{date("Y-m-d H:i:s",$v->add_time)}}</td>
                <td><li class="btn"><a href="/goodsDel2/{{$v['id']}}">删除</a></li></td>
            </tr>
        @endforeach
    </table>
    <a href="/orderAdd" class="	btn btn-success" style="float:right;width: 200px">提交订单</a>
@endsection
