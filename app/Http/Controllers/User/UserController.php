<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\UserModel;

class UserController extends Controller
{
    public function index(){
       $user=UserModel::where('id','=',2)->get()->toArray();
        echo '<pre>';
        print_r($user);
    }
}