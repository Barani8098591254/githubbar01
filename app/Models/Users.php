<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;

class Users extends Authenticatable{


    protected $table = 'UeAVBvpelsUJpczNv';

    protected $fillable = [
        // Other fillable properties
        'tfaStatus','randcode',
    ];


    // protected $fillable = [
    //     'username',
    //     'email',
    //     'password',
    //     'c_password',
    //     'mobile_no',
    //     'referralId',
    //     'referrerId',
    //     'directId',
    //     'is_active',
    //     'is_verify',
    //     'tfaStatus',
    //     'randcode',
    //     'level_no',
    //     'uplineCount',

    // ];

}

?>
