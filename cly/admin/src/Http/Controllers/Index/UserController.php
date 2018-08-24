<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/24
 * Time: 下午4:20
 */

namespace Cly\Admin\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Cly\Admin\Exceptions\JsonException;
use Cly\Admin\Model\Sms;
use Cly\Admin\Model\User;
use Cly\RegExp\RegExp;

class UserController extends Controller
{
    public function register()
    {
        //网站关闭注册
        $closeRegister = env('SITE_CLOSE');
        if ($closeRegister) {
            throw new JsonException('网站暂时关闭注册功能，具体开放时间请持续关注网站');
        }

        $mobile = request('mobile');
        $password = request('password');
        $code = request('code');
        $remember = request('remember');
        $inviterMobile = request('inviter', '');

        if (!preg_match(RegExp::MOBILE, $mobile)) {
            throw new JsonException('手机号码格式错误');
        }

        if (!preg_match(RegExp::PASSWORD, $password)) {
            throw new JsonException('密码必须包含字母、数字、符号两种组合且长度为8-16');
        }

        if ($inviterMobile && !preg_match(RegExp::MOBILE, $inviterMobile)) {
            throw new JsonException('邀请人手机号码格式错误');
        }

        $user = User::where('mobile', $mobile)->first();
        if ($user) {
            throw new JsonException('用户已注册，请找回密码：登录->忘记密码');
        }

        //未使用，未过期的code
        $sms = Sms::where('mobile', $mobile)
            ->where('status', 0)
            ->where('code', $code)
            ->where('expired_at', '>', Carbon::now())
            ->first();
        if (!$sms) {
            throw new JsonException('验证码错误');
        }
        $sms->update(['status' => 1]);

        $user = User::register($mobile, $password, $inviterMobile);

        \Auth::guard('user')->login($user, $remember);

        return [];
    }

    public function forgetPassword()
    {
        $mobile = request('mobile');
        $password = request('password');
        $code = request('code');
        $remember = request('remember');

        if (!preg_match(RegExp::MOBILE, $mobile)) {
            throw new JsonException('手机号码格式错误');
        }

        if (!preg_match('/^(?![0-9]+$)(?![a-zA-Z]+$)(?![^a-zA-Z^\d]+$).{8,16}$/', $password)) {
            throw new JsonException('密码必须包含字母、数字、符号两种组合且长度为8-16');
        }

        $user = User::where('mobile', $mobile)->first();
        if (!$user) {
            throw new JsonException('用户不存在，请先注册');
        }

        //未使用，未过期的code
        $sms = Sms::where('mobile', $mobile)
            ->where('status', 0)
            ->where('code', $code)
            ->where('expired_at', '>', Carbon::now())
            ->first();
        if (!$sms) {
            throw new JsonException('验证码错误');
        }
        $sms->update(['status' => 1]);

        $user->update(['password' => bcrypt($password)]);

        \Auth::guard('user')->login($user, $remember);

        return [];
    }
}