<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Overtrue\EasySms\EasySms;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Home\VerificationCodeRequest;
use App\Http\Requests\Home\PhoneRegisterRequest;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms){

        $phone = $request->phone;
        if(!app()->environment('production')){
            // 非真机发送
            $code  = '1234';
        }else{
            // 真机发送.
                // 生成4位随机数,左侧补0
                $code = str_pad(random_int(1,9999),4,0,STR_PAD_LEFT);
                try{
                    $result = $easySms->send($phone,[
                        'content'=>"【忆莲池】您的验证码是{$code}。如非本人操作，请忽略本短信"
                    ]);

                }catch(\Overtrue\EasySms\Exceptions\NotGatewayAvailableException $exception){
                    $message = $exception->getException('yunpian')->getMessage();
                    return $this->response->errorInternal($message?:'短信发送异常');
                }
        }

        $key = 'verificationCode_'.str_random(15);

        $expiredAt = now()->addMinutes(10);

        // 缓存验证码 10分钟过期。
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);

        // return redirect()->route('registersteptwo')->with('key', $key)->with('success', '手机验证码已发送');
        if(!app()->environment('production')){
            session()->flash('success', '手机验证码为1234');
        }else{
            session()->flash('success', '手机验证码已发送');
        }

        return view('auth.registersteptwo')->with('key', $key);
    }

     //  此方法是看到网上的案例，未使用，暂留作参考。
     public function ajaxregister(VerificationCodeRequest $request, EasySms $easySms)
     {
          //获取前端ajax传过来的手机号
          $phone = $request->phone;
          // 生成4位随机数，左侧补0
          $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);

          try {
               $result = $easySms->send($mobile, [
                    'content' => "【忆莲池】您的验证码是{$code}。如非本人操作，请忽略本短信"
               ]);
          } catch (Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
               $response = $exception->getExceptions();
               return response()->json($response);
          }

          //生成一个不重复的key 用来搭配缓存cache判断是否过期
          $key = 'verificationCode_' . str_random(15);
          $expiredAt = now()->addMinutes(10);

          // 缓存验证码 10 分钟过期。
          \Cache::put($key, ['mobile' => $mobile, 'code'=> $code], $expiredAt);

          return response()->json([
           'key' => $key,
           'expired_at' => $expiredAt->toDateTimeString(),
          ], 201);
     }

     public function register(PhoneRegisterRequest $request)
     {
         // 暂不知如何把 此处验证码错误返回 显示在验证码输入框的下一行。
         // 获取刚刚缓存的验证码和key
         // key 放在页面的隐藏域里。
         $verifyData = \Cache::get($request->verification_key);

         //如果数据不存在，说明验证码已经失效。
         if(!$verifyData) {
            session()->flash('success', '短信验证码已失效');
            return view('auth.registersteptwo')->with('key', $request->verification_key)->with('message', '短信验证码已失效');
         }

         // 检验前端传过来的验证码是否和缓存中的一致
         if (!hash_equals($verifyData['code'], $request->verification_code)) {
            session()->flash('success', '短信验证码错误');
            return view('auth.registersteptwo')->with('key', $request->verification_key);
         }

         $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
         ]);

         // 清除验证码缓存
         \Cache::forget($request->verification_key);

         return redirect()->route('login')->with('success', '注册成功！');

    }

}


