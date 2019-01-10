{{-- 订单页面--}}
@extends('layout.bst')

@section('content')
    <table class="table table-hover">
        <h2>订单页面</h2>
        <tr class="success">
            <td>ID</td>
            <td>订单编号</td>
            <td>价格</td>
            <td>时间</td>
            <td>操作</td>
        </tr>
        @foreach($list as $v)
            <tr class="info">
                <td>{{$v->oid}}</td>
                <td>{{$v->order_sn}}</td>
                <td>{{$v->order_amount}}</td>
                <td>{{date("Y-m-d H:i:s",$v->add_time)}}</td>
                <td>
                    <li class="btn"><a href="/orderDel/{{$v->oid}}">删除订单</a></li>||
                    @if($v['status']==1)
                        <li class="btn"><a href="/orderPay/{{$v->oid}}">去支付</a></li>
                    @elseif($v['status']==2)
                        <li class="btn"><a href="javascript">已支付</a></li>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>

@endsection
