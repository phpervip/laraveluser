<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Http\Requests\Home\UserRequest;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Home\PhoneBindRequest;
use Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }


    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);

        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }


    public function setbindsns(User $user)
    {
        return view('users.setbindsns', compact('user'));
    }

    public function phoneshow(User $user){
        return view('users.phoneshow', compact('user'));
    }

    public function phoneupdate(PhoneBindRequest $request, User $user){
         $verifyData = \Cache::get($request->verification_key);

         //如果数据不存在，说明验证码已经失效。
         if (!$verifyData) {
            session()->flash('danger', '短信验证码已失效');
            return view('users.phoneshow', compact('user'))->with('key', $request->verification_key);
         }

         // 检验前端传过来的验证码是否和缓存中的一致
         // dd($verifyData['code']);
         if (!hash_equals($verifyData['code'], $request->code)) {
            session()->flash('danger', '短信验证码错误');
            return view('users.phoneshow', compact('user'))->with('key', $request->verification_key);
         }

          // 如果提交的手机号不一致
         if (!hash_equals($verifyData['phone'], $request->phone)) {
            session()->flash('danger', '手机号码不一致');
            return view('users.phoneshow', compact('user'))->with('key', $request->verification_key);
         }

         $phone = User::where('id', '=', Auth::id())->update(
           ['phone' => $verifyData['phone']]
         );

         // 清除验证码缓存
         \Cache::forget($request->verification_key);

         return redirect()->route('users.setbindsns', Auth::id())->with('success', '绑定成功');
    }
}
