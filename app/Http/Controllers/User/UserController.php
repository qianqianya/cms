<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\UserModel;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::where('id', '=', 2)->get()->toArray();
        echo '<pre>';
        print_r($user);
    }

    public function add()
    {
        $data = [
            'name' => str_random(3),
            'age' => mt_rand(20, 30),
        ];
        $info = UserModel::insert($data);
        var_dump($info);
    }

    public function delete()
    {
        $user = UserModel::where('id', '=', 2)->delete();
        var_dump($user);
    }

    public function update()
    {
        $data = [
            'name' => str_random(3),
            'age' => mt_rand(20, 30),
        ];
        $info = UserModel::where('id', '=', 3)->update($data);
        var_dump($info);
    }
    public function userList(){
        $list=userModel::all();
       // print_r($info);exit;
        $info=[
            'list '=>$list,
            'page'=>10
        ];
        return view('user.user',$info);
    }
}