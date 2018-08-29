<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/21
 * Time: 上午10:19
 */

namespace Cly\Admin\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Cly\Admin\Exceptions\JsonException;
use Cly\Admin\Http\Resources\UserResource;
use Cly\Admin\Model\Sms;
use Cly\Admin\Model\User;
use Cly\RegExp\RegExp;

class IndexController extends Controller
{
    public function index()
    {
        $user = \Auth::guard('user')->user();
        $laravel = [
            'user' => $user ? new UserResource($user) : null,
            'taxonomy' => app('taxonomy')->toArray(),
        ];
        return view('cly_admin::index', compact('laravel'));
    }

    public function login()
    {
        $mobile = request('mobile');
        $password = request('password');
        $remember = request('remember');

        if (\Auth::guard('user')->attempt([
            'mobile' => $mobile,
            'password' => $password
        ], $remember)) {
            return [];
        } else {
            return [
                'code' => 100,
                'message' => '登录失败'
            ];
        }
    }

    public function logout()
    {
        \Auth::guard('user')->logout();
        return [];
    }

    public function user()
    {
        $user = \Auth::guard('user')->user();
        return $user ? new UserResource($user) : [];
    }

    public function sms()
    {
        $mobile = request('mobile');
        $action = request('action');

        if (!preg_match(RegExp::MOBILE, $mobile)) {
            throw new JsonException('手机号码格式错误');
        }
        if ($action && $action == 'register') {
            $user = User::where('mobile', $mobile)->first();
            if ($user) {
                throw new JsonException('用户已注册，请找回密码：登录->忘记密码');
            }
        }
        if ($action && $action == 'forget') {
            $user = User::where('mobile', $mobile)->first();
            if (!$user) {
                throw new JsonException('用户不存在，请先注册');
            }
        }

        $ipCount = Sms::where('ip', request()->getClientIp())
            ->where('created_at', '>', Carbon::now()->subMinutes(30))
            ->count();
        if ($ipCount >= 30) {
            return [
                'code' => -1,
                'message' => '一个ip30分钟内只能发30次'
            ];
        }

        //60秒内，未过期的，未使用的code
        $sms = Sms::where('mobile', $mobile)
            ->where('status', 0)//未使用
            ->where('expired_at', '>', Carbon::now())
            ->where('created_at', '>', Carbon::now()->subSeconds(60))->first();

        if ($sms) {
            $leftTime = $sms->created_at->timestamp + 60 - Carbon::now()->timestamp;
            return [
                'code' => -1,
                'message' => "还剩${leftTime}秒才能发送"
            ];
        }

        $code = random_int(1000, 9999);

        if (env('ALIYUN_SMS_SEND_ENABLE', true)) {
            $result = app('aliyun.sms')->send($mobile, $code);
        } else {
            $result = ['success' => true];//调试，开发时不发送短信
        }

        if ($result['success']) {
            $sms = Sms::create([
                'mobile' => $mobile,
                'code' => $code,
                'status' => 0,
                'expired_at' => Carbon::now()->addMinutes(5),
                'ip' => request()->getClientIp(),
                'result' => json_encode($result)
            ]);

            return [
                'code' => 0,
                'message' => '发送验证码成功',
                'data' => [
                    'mobile' => $sms->mobile,
                    'expired_at' => $sms->expired_at
                ]
            ];
        } else {
            $sms = Sms::create([
                'mobile' => $mobile,
                'code' => $code,
                'status' => -1,
                'expired_at' => Carbon::now()->addMinutes(5),
                'ip' => request()->getClientIp(),
                'result' => json_encode($result)
            ]);

            return [
                'code' => -1,
                'message' => '发送验证码失败，请稍后再试，如果多次尝试未能成功，请联系客服。',
                'data' => [
                    'mobile' => $sms->mobile,
                    'expired_at' => $sms->expired_at,
                    'result' => $result
                ]
            ];
        }
    }
}