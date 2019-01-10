<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsModel;
use App\Model\CartModel;

class CartController extends Controller
{
    public $uid;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->uid = session()->get('id');
            return $next($request);
        });

    }
    //
    /*public function index(Request $request)
    {
        $goods = session()->get('cart_goods');
        //var_dump($goods);exit;
        if(empty($goods)){
            echo '购物车是空的';
        }else{
            foreach($goods as $k=>$v){
                echo 'Goods ID: '.$v;echo '</br>';
                $detail = GoodsModel::where(['goods_id'=>$v])->first()->toArray();
                echo '<pre>';print_r($detail);echo '</pre>';
            }
        }
    }*/
    public function index(Request $request)
    {
/*//var_dump($this->uid);exit;
        $cart_goods = CartModel::where(['uid'=>$this->uid])->get()->toArray();
        var_dump($cart_goods);exit;
        if(empty($cart_goods)){
            //header('Refresh:2;url=/goodsList');
            return "购物车是空的";
        }
        
        //echo '<pre>';print_r($cart_goods);echo '</pre>';echo '<hr>';
        if($cart_goods){
            //获取商品最新信息
            foreach($cart_goods as $k=>$v){
                $goods_info = GoodsModel::where(['goods_id' => $v['goods_id']])->first()->toArray();
                $goods_info['id'] = $v['id'];
                $goods_info['num'] = $v['num'];
                $goods_info['add_time'] = $v['add_time'];
                $data[] = $goods_info;
            }
        }

        $list=[
            'data'=>$data
        ];
        //var_dump($list);exit;
        return view('cart.cartList',$list);*/
        $cart_goods = CartModel::where(['uid'=>$this->uid])->get()->toArray();
        //var_dump($cart_goods);exit;
        if(empty($cart_goods)){
            die("购物车是空的");
        }
        //var_dump($cart_goods);exit;
        //echo '<pre>';print_r($cart_goods);echo '</pre>';echo '<hr>';
        if($cart_goods){
            //获取商品最新信息
            foreach($cart_goods as $k=>$v){
                $goods_info = GoodsModel::where(['goods_id' => $v['goods_id']])->first();
                $goods_info['id'] = $v['id'];
                $goods_info['num'] = $v['num'];
                $goods_info['add_time'] = $v['add_time'];
                $list[] = $goods_info;
            }
        }

        $data = [
            'list'  => $list
        ];
        return view('cart.cartList',$data);

    }

    /**
     * 添加商品
     */
    public function cartAdd($goods_id)
    {

        $cart_goods = session()->get('cart_goods');

        //是否已在购物车中
        if (!empty($cart_goods)) {
            if (in_array($goods_id, $cart_goods)) {
                echo '已存在购物车中';
                exit;
            }
        }

        session()->push('cart_goods', $goods_id);

        //减库存
        $where = ['goods_id' => $goods_id];
        $store = GoodsModel::where($where)->value('goods_store');

        if ($store <= 0) {
            echo '库存已不足';
            exit;
        }
        $res = GoodsModel::where(['goods_id' => $goods_id])->decrement('goods_store');

        if ($res) {
            echo '添加成功';
        }
    }
    public function  cartAdd2(Request $request){
        $goods_id = $request->input('goods_id');
        $num = $request->input('num');
        /*var_dump($goods_id);
        var_dump($num);
        exit;*/

        //检查库存
        $store_num = GoodsModel::where(['goods_id'=>$goods_id])->value('goods_store');
        //var_dump($store_num);exit;
        if($store_num<=0){
            //echo 1;exit;
            $response = [
                'error' => 5001,
                'msg'   => '库存不足'
            ];
            return $response;
        }

        //写入购物车表
        $data = [
            'goods_id'  => $goods_id,
            'num'       => $num,
            'add_time'  => time(),
            'uid'       => session()->get('id'),
            'session_token' => session()->get('u_token')
        ];

        $cid = CartModel::insertGetId($data);
        if(!$cid){
            $response = [
                'error' => 5002,
                'msg'   => '添加购物车失败，请重试'
            ];
            return $response;
        }


        $response = [
            'error' => 0,
            'msg'   => '添加成功'
        ];
        return $response;
    }
    /**
     * 删除商品
     */
    public function cartDelete($goods_id)
    {
        //判断 商品是否在 购物车中
        $goods = session()->get('cart_goods');
        //echo '<pre>';print_r($goods);echo '</pre>';die;
        $where=[
            'goods_id'=>$goods_id
        ];
        $goodsmodel=GoodsModel::where($where)->first();
        //print_r($goodsmodel);exit;

        if(in_array($goods_id,$goods)){
            //执行删除
            foreach($goods as $k=>$v){
                if($goods_id == $v){
                    session()->pull('cart_goods.'.$k);
                }
            }
        }else{
            //不在购物车中
            die("商品已经从购物车中移除");
        }

    }
    public function goodsDel2($a){
        $res=CartModel::where(['uid'=>$this->uid,'goods_id'=>$a])->delete();
        if($res){
            echo '删除成功';
            header('refresh:2,url=/cartList');
        }else{
            echo '删除失败';
            header('refresh:2,url=/cartList');
        }
    }

}
