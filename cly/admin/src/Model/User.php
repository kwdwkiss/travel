<?php

namespace Cly\Admin\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function register($mobile, $password, $inviterMobile)
    {
        $user = null;
        \DB::transaction(function () use (&$user, $mobile, $password, $inviterMobile) {
            $user = User::create([
                'mobile' => $mobile,
                'password' => bcrypt($password),
            ]);
        });
        return $user;
    }
}
