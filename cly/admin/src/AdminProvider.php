<?php
/**
 * Created by PhpStorm.
 * User: kwdwkiss
 * Date: 2018/8/17
 * Time: 下午2:27
 */

namespace Cly\Admin;


use Aliyun\Oss;
use Aliyun\Sms;
use Cly\Admin\Console\Commands\InstallCmd;
use Cly\Admin\Http\Middleware\JsonSuccessResponse;
use Cly\Session\SessionGuard;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AdminProvider extends ServiceProvider
{
    public function boot()
    {
        //兼容utf8mb4字符编码
        Schema::defaultStringLength(191);

        //console
        if ($this->app->runningInConsole()) {
            //注册命令
            $this->commands([
                InstallCmd::class
            ]);
        }

        //web
        if (!$this->app->runningInConsole()) {
            //加载中间件
            $router = $this->app->get('router');
            $router->pushMiddlewareToGroup('web', JsonSuccessResponse::class);
        }

        //注册路由
        $this->loadRoutesFrom(dirname(__DIR__) . '/routes/index.php');
        $this->loadRoutesFrom(dirname(__DIR__) . '/routes/admin.php');

        //数据库迁移
        $this->loadMigrationsFrom(dirname(__DIR__) . '/database/migrations');

        //加载视图
        $this->loadViewsFrom(dirname(__DIR__) . '/resource/views', 'cly_admin');

        //原生的session，刷新会有bug
        \Auth::extend('cly_session', function ($app, $name, $config) {
            $provider = \Auth::createUserProvider($config['provider'] ?? null);

            $guard = new SessionGuard($name, $provider, $app['session.store']);

            // When using the remember me functionality of the authentication services we
            // will need to be set the encryption instance of the guard, which allows
            // secure, encrypted cookie values to get generated for those cookies.
            if (method_exists($guard, 'setCookieJar')) {
                $guard->setCookieJar($app['cookie']);
            }

            if (method_exists($guard, 'setDispatcher')) {
                $guard->setDispatcher($app['events']);
            }

            if (method_exists($guard, 'setRequest')) {
                $guard->setRequest($app->refresh('request', $guard, 'setRequest'));
            }

            return $guard;
        });
    }

    public function register()
    {
        //覆盖app的config
        $this->mergeConfigTo(dirname(__DIR__) . '/config/auth.php', 'auth');
        $this->mergeConfigTo(dirname(__DIR__) . '/config/database.php', 'database');

        //注入短信服务
        $this->app->singleton('aliyun.sms', function () {
            $accessKeyId = env('ALIYUN_SMS_ACCESS_KEY_ID');
            $accessKeySecret = env('ALIYUN_SMS_ACCESS_KEY_SECRET');
            $signName = env('ALIYUN_SMS_SIGN_NAME');
            $templateCode = env('ALIYUN_SMS_TEMPLATE_CODE');
            return new Sms($accessKeyId, $accessKeySecret, $signName, $templateCode);
        });

        //注入oss服务
        $this->app->singleton('aliyun.oss', function () {
            $accessKeyId = env('ALIYUN_OSS_ACCESS_KEY_ID');
            $accessKeySecret = env('ALIYUN_OSS_ACCESS_KEY_SECRET');
            $endpoint = env('ALIYUN_OSS_ENDPOINT');
            $bucket = env('ALIYUN_OSS_BUCKET');
            $oss = new Oss($accessKeyId, $accessKeySecret, $endpoint);
            $oss->setBucket($bucket);
            return $oss;
        });

        $this->app->singleton('taxonomy', function () {
            return new Taxonomy();
        });
    }

    protected function mergeConfigTo($path, $key)
    {
        $config = $this->app['config']->get($key, []);

        $this->app['config']->set($key, array_merge($config, require $path));
    }
}