@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <!-- 手机注册 -->
                <div class="card">
                <div class="card-header">手机{{ __('Register') }}  第①步 </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('verificationCodes.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">手机号码</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
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
        </div>
    </div>
</div>
@endsection
