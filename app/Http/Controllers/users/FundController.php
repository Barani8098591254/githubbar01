<?php

namespace App\Http\Controllers\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use Session;
use App\Models\Userkyc;
use App\Models\Currency;
use App\Models\UserModel;
use URL;
use App\Models\Plan;
use PragmaRX\Google2FAQRCode\Google2FA;


class FundController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

    function index()
    {

        $data['currency'] = Currency::where('status', 1)->orderBy('id', 'DESC')->get();
        $data['js_file'] = '';
        $data['title'] = 'Wallet Fund';
        $data['pageTitle'] = 'Wallet Fund';
        $data['subTitle'] = 'Wallet Fund';
        return view('user.Fund.fund', $data);
    }
}
