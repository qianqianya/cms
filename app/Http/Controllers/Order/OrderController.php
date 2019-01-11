<?php

namespace App\Http\Controllers\Order;

use App\Model\CartModel;
use App\Model\GoodsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\OrderModel;

class OrderController extends Controller
{

    public $id;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->id = session()->get('id');
            return $next($request);
        });
    }

    //

    public function index()
    {
        echo __METHOD__;
    }

    /**
     * 下单
     */
    public function order(Request $request)
    {
        //查询购物车商品
        $cart_goods = CartModel::where(['uid'=>session()->get('id')])->orderBy('id','desc')->get()->toArray();
        if(empty($cart_goods)){
            die("购物车中无商品");
        }
        $order_amount = 0;
        foreach($cart_goods as $k=>$v){
            $goods_info = GoodsModel::where(['goods_id'=>$v['goods_id']])->first()->toArray();
            $goods_info['num'] = $v['num'];
            $list[] = $goods_info;

            //计算订单价格 = 商品数量 * 单价
            $order_amount += $goods_info['goods_price'] * $v['num'];
        }

        //生成订单号
        $order_sn = OrderModel::orderNumber();
        //echo $order_sn;
        $data = [
            'order_sn'      => $order_sn,
            'uid'           => session()->get('id'),
            'add_time'      => time(),
            'order_amount'  => $order_amount
        ];

        $oid = OrderModel::insertGetId($data);
        if(!$oid){
            echo '生成订单失败';
        }

        echo '下单成功,订单号：'.$oid .' 跳转支付';
        header('refresh:2,url=/orderList');


        //清空购物车
        CartModel::where(['uid'=>session()->get('id')])->delete();
    }

    public function orderList(){
        $list=OrderModel::where(['uid'=>$this->id])->get();
        $data=[
            'list'=>$list
        ];
        return view('order.orderList',$data);
    }
     public function orderDel($oid){
         $where=[
             'oid'=>$oid
         ];
         $res=OrderModel::where($where)->delete();
         //var_dump($res);exit;
         if($res){
             echo '删除成功';
             header('refresh:2,url=/orderList');
         }else{
             echo '删除失败';
             header('refresh:2,url=/orderList');
         }
     }
    public function orderPay($oid){
       //var_dump($oid);exit;
        $where=[
            'oid'=>$oid
        ];
        $list=OrderModel::where($where)->get();

       //var_dump($list);exit;
        if(empty($list)){
            header('refresh:2,url=/orderList');
            die('订单'. $oid .'不存在');
        }
        $data=[
            'list'=>$list
        ];
        //支付成功 修改支付时间
        OrderModel::where(['oid'=>$oid])->update(['pay_time'=>time(),'pay_amount'=>rand(1111,9999),'is_pay'=>1,'status'=>2]);

//增加消费积分 ...

        header('Refresh:2;url=/orderList');
        echo '支付成功，正在跳转';


    }



    public function pay(){
        $url='http://www.order.com';
        $client=new Client([
            'base_uri'=>$url,
            'timeout'=>2.0,
        ]);

        $response=$client->request('GET','.order.php');
        echo $response->getBody();
    }

}
