@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')

<div class="row">

  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
    <div class="card ">
      <img class="card-img-top" src="{{ $user->avatar }}" alt="{{ $user->name }}" οnerrοr="this.src='http://laraveluser.yyii.info/uploads/images/avatars/201908/13/2_1565693480_FEzilyMfBu.png'">
      <div class="card-body">
            <h5><strong>个人简介</strong></h5>
            <p>{{ $user->introduction }}</p>
            <hr>
            <h5><strong>注册于</strong></h5>
            <p>{{ $user->created_at->diffForHumans() }}</p>
      </div>
    </div>
    <div class="card ">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="##">帐号绑定</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('users.edit',$user->id) }}">编辑资料</a>
        </li>
      </ul>
   </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="card ">
      <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
      </div>
    </div>
    <hr>

    {{-- 要绑定的内容 --}}
    <div class="card">
      <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          @include('shared._error')
          <table class="table">
              <tbody>
                <tr>
                  <td>手机号码</td>
                  <td>{{$user->phone}}</td>
                  @if($user->phone)
                    <td><i class="icon checkmark green"></i> 已验证</td>
                    <td><a target="_blank" href="" class="tdu"></a></td>
                    @else
                    <td>未绑定</td>
                    <td><a target="_blank" href="{{route('users.bindphoneshow',$user->id)}}" class="tdu">前往绑定</a></td>
                  @endif
                </tr>
                <tr>
                  <td>邮箱</td>
                  <td>{{$user->email}}</td>
                   @if($user->email)
                    <td><i class="icon checkmark green"></i> 已验证</td>
                    <td><a target="_blank" href="" class="tdu"></a></td>
                    @else
                    <td>未填写</td>
                    <td><a target="_blank" href="{{ route('users.edit',$user->id) }}" class="tdu">前往补充</a></td>
                  @endif
                </tr>
              </tbody>
          </table>
        </form>
      </div>
    </div>

  </div>
</div>
@stop
