<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\GoodsModel;

class GoodsController extends Controller
{
    /**
     * 商品展示
     */
    public function goodsList(){
        $list=GoodsModel::all()->toArray();
        $data=[
            'list'=>$list
        ];
        return view('goods.goodsList',$data);
    }
    /**
     * 删除商品
     */
    public function goodsDel(){

    }
    /**
     * @param $goods_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 详情
     */
    public function details($goods_id)
    {
        $goods = GoodsModel::where(['goods_id'=>$goods_id])->first();

        //商品不存在
        if(!$goods){
            header('Refresh:2;url=/');
            echo '商品不存在,正在跳转至首页';
            exit;
        }

        $data = [
            'goods' => $goods
        ];
        return view('goods.goodsDetails',$data);
    }
}
