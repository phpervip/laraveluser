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
          <a class="nav-link active" href="{{ route('users.setbindsns',$user->id) }}">帐号绑定</a>
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
      <div class="card-header">
        <h4>
          <i class="glyphicon glyphicon-edit"></i> 绑定手机
        </h4>
      </div>
      <div class="card-body">
        <form action="{{ route('users.bindphoneupdate', $user->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          @include('shared._error')
          <div class="alert alert-danger" id="ajaxmessage">
          </div>
          <div class="form-group">
            <label for="phone-field">输入手机号</label>
            <div class="row col-md-12">
                <input class="form-control col-md-8" type="text" name="phone" id="phone-field" value="18959165336" />
                <button id="sendCode" type="button" class="btn btn-xs btn-default col-md-3 offset-md-1 text-primary">发送验证码</button>
            </div>
          </div>
          <div class="form-group">
            <label for="code-field">输入验证码</label>
            <div class="row col-md-12">
                <input class="form-control col-md-8" type="text" name="code" id="code-field" value="" />
            </div>
          </div>
          <div class="form-group row" style="display:block;">
             <label for="password-confirm" class="col-md-4 col-form-label text-md-right">key值</label>
                  <div class="col-md-6">
                      @if(isset($key))
                      <input type="text" name="verification_key" required value="{{ $key }}">
                      @else
                      <input type="text" name="verification_key" required value="{{ old('verification_key') }}">
                      @endif
                  </div>
          </div>
          <div class="well well-sm text-center">
            <button type="submit" class="btn btn-primary">保存</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@stop

@section('scripts')
<script>
    $("#ajaxmessage").hide();
    $("#sendCode").click(function(){
        var phone = $('input[name="phone"]').val();
        console.log(phone);
        var url = '/phone/ajaxsend?phone='+ phone;
        $.ajax({
          type:'GET',
          url:url,
          data:{},
          dataType:'json',
          success:function(res){
            $("#ajaxmessage").hide();
            console.log(res);
            $('input[name="verification_key"]').val(res.key);
          },
          error:function(res){
            var jsonResponse = JSON.parse(res.responseText);
            console.log(jsonResponse);
            $("#ajaxmessage").show();
            $('#ajaxmessage').html(jsonResponse.errors.phone[0]);
          },
        });
    });
</script>
@endsection
