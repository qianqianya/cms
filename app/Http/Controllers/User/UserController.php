<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
   /* //查询
    public function index()
    {
        $user = UserModel::where('id', '=', 2)->get()->toArray();
        echo '<pre>';
        print_r($user);
    }
//增加
    public function add()
    {
        $data = [
            'name' => str_random(3),
            'age' => mt_rand(20, 30),
        ];
        $info = UserModel::insert($data);
        var_dump($info);
    }
//删除
    public function delete()
    {
        $user = UserModel::where('id', '=', 2)->delete();
        var_dump($user);
    }
//修改
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
    }*/

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View|string
     * 注册
     */
    public function register(Request $request)
    {
        if(request()->isMethod('post')) {
            //var_dump($request->input());exit;
            echo __METHOD__;
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            $username = $request->input('username');

            $info = UserModel::where(['username'=>$username])->first();
            if($info){
                die("用户名已存在");
            }
            $pwd=$request->input('pwd');
            $password=$request->input('password');
            if($pwd!=$password){
                return '密码和确认密码不一致';
            }
            $pwd = password_hash($pwd,PASSWORD_BCRYPT);

            $data = [
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'pwd' => $pwd,
                'ctime' => time(),
            ];
            //var_dump($data);exit;

            $uid = UserModel::insertGetId($data);
           // var_dump($uid);

            if ($uid) {
                echo '注册成功';
                setcookie('id',$uid,time()+86400,'/','www.shop.com',false,true);
                header('refresh:2,url=/login');
            } else {
                echo '注册失败';
            }
        }else{
            return view('login.register');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     * 登陆
     */
    public function login(Request $request)
    {
        if (request()->isMethod('post')) {
            $email = $request->input('email');
            $pwd = $request->input('pwd');
            $res = UserModel::where(['email' => $email])->first();
            // var_dump($res);exit;
            if ($res) {
                if (password_verify($pwd, $res->pwd)) {
                    $token = substr(md5(time().mt_rand(1,99999)),10,10);
                    setcookie('id',$res->id,time()+86400,'/','',false,true);
                    setcookie('token',$token,time()+86400,'/user','',false,true);


                    $request->session()->put('u_token',$token);
                    $request->session()->put('id',$res->id);

                    //header("Refresh:3;url=/user/center");
                    header("Refresh:3;url=/center");
                    echo "登录成功";
                } else {
                    die("密码不正确");
                }
            } else {
                return ("用户不存在");
            }
        } else {
            return view('login.login');
        }
    }
    public function center(Request $request)
    {

       /* if($_COOKIE['token'] != $request->session()->get('token')){
            return("非法请求");
        }else{
            echo '正常请求';
        }


        echo 'token: '.$request->session()->get('token'); echo '</br>';
        //echo '<pre>';print_r($request->session()->get('u_token'));echo '</pre>';

        echo '<pre>';print_r($_COOKIE);echo '</pre>';
        die;*/
        if(empty($_COOKIE['id'])){
            header('Refresh:2;url=/login');
             echo '请先登录';exit;
        }else{
            echo 'UID: '.$_COOKIE['id'] . ' 欢迎回来';
        }
    }
    public function quit(){
        setcookie('id',null);
        setcookie('token',null);
        request()->session()->pull('u_token',null);
        request()->session()->pull('id',null);
        header('refresh:2,url=/login');

    }

}