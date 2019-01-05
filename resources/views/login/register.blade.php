@extends('layout.register')

@section('content')
<form class="form-signin" action="/register" method="post">
    {{csrf_field()}}
    <h2 class="form-signin-heading">用户注册</h2>
    <label for="inputNickName">用户名</label>
    <input type="text" name="username" id="inputNickName" class="form-control" placeholder="请输入您的名字" required autofocus>

    <label for="inputAge">Email</label>
    <input type="text" name="email" id="inputAge" class="form-control" placeholder="请输入您的可用邮箱" required autofocus>

    <label for="inputPassword" >密码</label>
    <input type="password" name="pwd" id="inputPassword" class="form-control" placeholder="请输入您的密码" required>

    <label for="inputPassword2" >确认密码</label>
    <input type="password" name="password" id="inputPassword2" class="form-control" placeholder="请确认您的密码" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">注册</button>
</form>
@endsection