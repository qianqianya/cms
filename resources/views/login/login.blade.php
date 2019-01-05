@extends('layout.register')

@section('content')
    <form class="form-signin" action="/login" method="post">
        {{csrf_field()}}
        <h2 class="form-signin-heading">请登录</h2>
        <label for="inputEmail">Email</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="@" required autofocus>
        <label for="inputPassword" >Password</label>
        <input type="password" name="pwd" id="inputPassword" class="form-control" placeholder="请输入您的密码" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> 记住密码
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登陆</button>
    </form>
@endsection