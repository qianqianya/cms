@extends('layout.bst')
@section('content')
    <table class="table table-bordered">
        <h2>商品列表</h2>
        <thead>
        <tr>
            <td>ID</td>
            <td>商品名称</td>
            <td>库存</td>
            <td>添加时间</td>
            <td>操作</td>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $v)
            <tr>
                <td>{{$v['goods_id']}}</td>
                <td>{{$v['goods_name']}}</td>
                <td>{{$v['goods_store']}}</td>
                <td>{{date('Y-m-d H:i:s',$v['goods_time'])}}</td>
                <td><a href="/details/{{$v['goods_id']}}">加入购物车</a></td>

            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
