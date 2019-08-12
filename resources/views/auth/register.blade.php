@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <ul id="myTab" class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" href="#home" data-toggle="tab">邮箱注册</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#phone_register" data-toggle="tab">手机注册</a>
          </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active show" id="home">
                <!-- 邮箱注册 -->
                <div class="card">
               <!--  <div class="card-header">邮箱{{ __('Register') }}</div> -->
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="captcha" class="col-md-4 col-form-label text-md-right">验证码</label>

                            <div class="col-md-6">
                              <input id="captcha" class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }}" name="captcha" required>

                              <img class="thumbnail captcha mt-3 mb-2" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">

                              @if ($errors->has('captcha'))
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('captcha') }}</strong>
                                </span>
                              @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <!-- 邮箱注册/! -->
            </div>
            <div class="tab-pane fade" id="phone_register">
                <!-- 手机注册 -->
                <div class="card">
                <!-- <div class="card-header">手机{{ __('Register') }}</div> -->
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">手机号码</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="captcha" class="col-md-4 col-form-label text-md-right">验证码</label>

                            <div class="col-md-6">
                              <input id="captcha" class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }}" name="captcha" required>

                              <img class="thumbnail captcha mt-3 mb-2" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">

                              @if ($errors->has('captcha'))
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('captcha') }}</strong>
                                </span>
                              @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <!-- 手机注册/! -->
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

@section('script')
  <script type="text/javascript">
    $(function () {
      $('#myTab li:eq(1) a').tab('show');
    });
  </script>
@stop

