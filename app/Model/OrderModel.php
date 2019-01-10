<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    //
    protected $table='order';
    public $timestamps=false;


    /**
     * 生成订单号
     */
    public static function orderNumber()
    {
        return date('Y-m-d H:i:s') . rand(11111,99999) . rand(2222,9999);
    }
}
