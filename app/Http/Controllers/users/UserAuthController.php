<?php

namespace App\Http\Controllers\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Users;
use Session;
use URL;
use DB;
use App\Models\Userkyc;
use App\Models\Balance;
use App\Models\Currency;
use App\Models\Board;
use Illuminate\Support\Facades\Mail;



class UserAuthController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }


    public function forgotpassword(){

        if (Session::get('userId') != '') {

            return redirect('/');
        }
        $data['title'] = 'Forgot Password';
        $data['js_file'] = 'auth';
        $data['pageTitle'] = 'forgot password';
        $data['subTitle'] = 'forgot password';
        return view('user/Auth/forgotpassword', $data);
    }

    public function userotp()
    {

        if (Session::get('userId') != '') {
            return redirect('/');
        }
        $data['title'] = 'Login OTP';
        $data['js_file'] = 'auth';
        $data['pageTitle'] = 'Login OTP';
        $data['subTitle'] = 'Login OTP';
        return view('user/Auth/userotp', $data);
    }



    public function user_tfa()
    {

        if (Session::get('userId') != '') {
            return redirect('/');
        }
        $data['title'] = 'usertfa';
        $data['js_file'] = 'auth';
        $data['pageTitle'] = 'Login OTP';
        $data['subTitle'] = 'Login OTP';
        return view('user.Auth.tfa-otp', $data);
    }

    public function tfalogin(Request $request){

        if ($request->ajax()) {
            $this->validate($request, [
                'tfa_code' => 'required|min:6|max:6',

            ]);

            $tfa_code = $request->input('tfa_code');
            $user_idss = $request->input('user_id');


         $user_id   = encrypt_decrypt('decrypt',$user_idss);

            $user = Users::find($user_id);

            if ($user) {
                if ($user->tfa_status == 1 && $user->randcode != '') {

                    $ga = new Google2FA();

                    $checkResult = $ga->verifyKey($user->randcode, trim($tfa_code), 1);



                    if ($checkResult == 1) {

                     $otp_code = random_int(100000, 999999);

                         $updateData = [
                             'login_otp' => encrypt_decrypt('encrypt',$otp_code),
                         ];

                         Users::where('id',$user->id)->update($updateData);

                        $email_id = encrypt_decrypt('decrypt',$user->email);

                        $username = $user->username;
                        $data = 'Login OTP : ' . $otp_code;

                        // Assuming "sendemail" is a custom function
                        $send = send_mail(5,$email_id,'Login OTP',['###USER###' => $username,'###OTP###' => $otp_code,'###SITENAME###' => 'UniwinETC','###COPY###' => 'Copyright © 2023 MLM All rights reserved.']);

                        if ($send) {
                            $res = [
                                'status' => 1,
                                'msg' => 'OTP Is Sent To The Registered Mail',
                                'page' => '',
                                'user_id' => encrypt_decrypt('decrypt',$user->id),
                            ];
                             echo json_encode($res) ;
                        }
                    } else {
                        $res = [
                            'status' => 0,
                            'msg' => 'Invalid TFA Code !!',
                            'page' => 'login',
                        ];
                        echo json_encode($res) ; die;
                    }
                }
            } else {
                $res = [
                    'status' => 0,
                    'msg' => 'Invalid User!!',
                    'page' => 'login',
                ];
                 echo json_encode($res) ; die;
            }


        }
    }


    public function forgotpass()
    {
        if (Session::get('userId') != '') {

            return redirect('/');
        }
        $data['title'] = 'Forgot Password';
        $data['js_file'] = 'auth';
        $data['pageTitle'] = 'forgot password';
        $data['subTitle'] = 'forgot password';
        return view('user/Auth/forgotpass', $data);
    }


    public function createBoard($userId, $directId,$PlacementID){

        echo '<pre>';
        // Check if the directId exists
        $directExists = DB::table('BoUSxHTrYdJvmTurER')->where('user_id', $directId);
        $placementUser = userIdByreferrerId($PlacementID);

            $newUser = [
            'user_id' => $userId,
            'placement_id' => $placementUser,
            'directId' => $directId,
            'board' => 1,
            'created_at' => date('y-m-d H:i:s'),
            'updated_at' => date('y-m-d H:i:s'),
        ];

        $insertUser = DB::table('BoUSxHTrYdJvmTurER')->insert($newUser);
        self::checkBoard($newUser);



    }


    function checkBoard($arrayData){

        echo '<pre>';

        $placement_id = $arrayData['user_id'];
        $placement_id = $arrayData['placement_id'];
        $directID  = $arrayData['directId'];
        $board  = $arrayData['board'];


            // print_r($arrayData);


            $checkupline = DB::table("BoUSxHTrYdJvmTurER")->where('placement_id',$placement_id)->get();
            $out = [];
            foreach ($checkupline as $key => $value) {

                    $out[$key]['user_id'] = $value->user_id;
                    $out[$key]['placement_id'] = $value->placement_id;


                // self::checkBoard($data);
            }

            print_r($out);

    }

    public function updateBoard($userId, $placementId)
    {
        $referrerData = DB::table('BoUSxHTrYdJvmTurER')->select('board')
            ->where('user_id', $placementId)->first();

        if ($referrerData) {
            // Calculate the new board value (you might have a specific logic for this)
            $newBoardValue = $referrerData->board + 1;

            // Update the user's board
            DB::table('BoUSxHTrYdJvmTurER')
                ->where('user_id', $userId)
                ->update([
                    'board' => $newBoardValue,
                    'updated_at' => now(),
                ]);

            return 'Board updated successfully. New Board Level: ' . $newBoardValue;
        } else {
            return 'Referrer not found.';
        }
    }







    public function signup(Request $request)
    {

  


        if (Session::get('userId') != '') {
            return redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = Validator::make(
                $request->all(),
                [
                    'username' => 'required|alpha',
                    'email' => 'required',
                    'mobNumber' => 'required',
                    'password' => 'required',
                    'c_password' => 'required',
                    'referral_code' => 'required',
                ],
                [
                    'username.required' => 'Please enter username',
                    'email.required' => 'Please enter your email id',
                    'mobNumber.required' => 'Please enter your mobile number',
                    'password.required' => 'Please enter a password',
                    'c_password.required' => 'Please enter a confirm Password',
                    'referral_code' => 'Please enter a referral code',
                ]
            );

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                $res = ['status' => 0, 'msg' => $errors, 'page' => 'register'];
                echo json_encode($res);
                die;
            }

            $username = trim(strip_tags(strtolower($request['username'])));
            $email = encrypt_decrypt('encrypt', trim(strip_tags(strtolower($request['email']))));
            $mobNumber = trim(strip_tags($request['mobNumber']));
            $password = encrypt_decrypt('encrypt', trim(strip_tags($request['password'])));
            $c_password = trim(strip_tags($request['c_password']));
            $referral_code = trim(strip_tags($request['referral_code']));

            $check_user = Users::select('username')->where('username', $username);

            if ($check_user->count() == 0) {
                $checkEmail = Users::select('email')->where('email', $email);
                $last_referral = Users::select('referralId')->orderBy('id', "DESC");

                $referral = @($last_referral->count() > 0) ? (int) substr($last_referral->first()->referralId, 4) + 1 : 'REF0174583711';
                $activation_code =  md5(random_int(100000, 999999));

                if ($checkEmail->count() == 0) {
                    $check_ref_code = Users::select('referralId', 'is_verify', 'id')->where('referralId', $referral_code);

                    if ($check_ref_code->count() == 0) {
                        $res = ['status' => 0, 'msg' => 'Invalid referral code!', 'page' => 'register'];
                        echo json_encode($res);
                        die;
                    }

                    if ($check_ref_code->first()->is_verify == 0) {
                        $res = ['status' => 0, 'msg' => 'This referral user not yet activated', 'page' => 'register'];
                        echo json_encode($res);
                        die;
                    }

                    $user_referral_code = 'REF0' . $referral;
                    $activation_code =  md5(random_int(100000, 999999));

                    $getReffCode = self::getUplineReferrID($referral_code);





                    $insertUser = [
                        'username' => strtolower($username),
                        'email' => $email,
                        'mobile_no' => $mobNumber,
                        'password' => $password,
                        'referralId' => $user_referral_code,
                        'referrerId' => $getReffCode['referrerId'],
                        'level_no' => $getReffCode['level_no'],
                        'directId' => $referral_code,
                        'last_ip' => '',
                        'loginOtp' => '',
                        'mlmType'  => $getReffCode['mlmType'],
                        'activationCode'  => $activation_code,
                        'is_active'  => 0,
                        'is_verify'  => 0,
                        'created_at' => date('Y-m-d H:i:s')
                    ];



                    $insert = Users::insert($insertUser);


                    $insertId = Users::orderBy('id', 'desc')->take(1)->first()->id;

                    $link = URL::to('/') . '/accountActivate/' . $activation_code;

                    $send = send_mail(1, strtolower($request['email']), 'Registration', ['###USER###' => $username, '###LINK###' => $link, '###registerverify_link###' => $link, '###SITENAME###' => 'MLM']);


                    if ($insert) {


                                    // echo $referral_code."<br>";
                                    $referId     = userIdByreferrerId($referral_code);
                                    // echo $referId."<br>";
                                    self::createBoard($insertId ,$referId);

                        $user_id = $insertId;
                        user_activity($user_id, 'New account register');

                        $res = ['status' => 1, 'msg' => 'Register successfully. Activation link has been sent to your registered email address', 'page' => 'home'];
                        echo json_encode($res);
                        die;
                    }else {
                        $res = ['status' => 0, 'msg' => 'Registration invalid', 'page' => 'register'];
                        echo json_encode($res);
                        die;
                    }
                } else {
                    $res = ['status' => 0, 'msg' => 'Email id already exists!', 'page' => 'login'];
                    echo json_encode($res);
                    die;
                }
            } else {
                $res = ['status' => 0, 'msg' => 'User name already exists!', 'page' => 'login'];
                echo json_encode($res);
                die;
            }
        } else {
            $data['refeerralLink'] = ($request->ref) ? $request->ref : '';
            $data['js_file'] = 'auth';
            $data['title'] = 'Sign Up';
            return view('user/Auth/signup', $data);
        }
    }



    function getUplineReferrID($referral_code){

        $getType = setting();

        if($getType->mlm == 2){
            $return_value["referrerId"] = $referral_code;
            $return_value["level_no"] = 0;
            $return_value["mlmType"] = @($getType->mlm) ? $getType->mlm : 2;

            return $return_value;
        }
        else{
            $uplineCount = Users::where('referrerId',$referral_code)->where('mlmType',1);
            $width = 2;

            if($uplineCount->count() < $width){
                $upline_id=$referral_code;
                $return_value=array();
                $return_value["referrerId"]=$upline_id;
                $return_value["level_no"]=Users::where('referralId',$upline_id)->where('mlmType',1)->first()->level_no+1;
                $return_value["mlmType"] = @($getType->mlm) ? $getType->mlm : 2;

                $getUploneCount = Users::where('referralId',$referral_code)->where('mlmType',1);

                $resId = @($getUploneCount->first()->id) ? $getUploneCount->first()->id : 1;

                $uplineCount = (int) $uplineCount->count()+1;
                // echo 'resId--->'.$resId;
                // echo '<br>';
                // echo 'uplineCount--->'.$uplineCount;
                // die;

                Users::where('id',$resId)->update(['uplineCount' => $uplineCount]);
                return $return_value;
            }else{
                $new_user = Users::where('referrerId',$referral_code)->where('uplineCount' ,'<',$width)->where('mlmType',1)->first();

                if(isset($new_user->referralId)){

                    $newUserreferralId = $new_user->referralId;
                } else{
                   $new_user = Users::where('uplineCount','<',$width)->where('mlmType',1)->first();
                   $newUserreferralId = $new_user->referralId;
                }

                // if(Users::where('referrerId',$referral_code)->where('uplineCount' ,'<',$width)->where('mlmType',1)->first()){
                // }
                // echo $new_user->id; die;
                // $depth = 1000;
                return self::getUplineReferrID($new_user->referralId);
            }



        }
    }

    function account_activate($code = "")
    {



        if ($code == '') {
            Session::flash('error', 'Invalid link');
            return redirect('signin');
        }

        if ($code) {

            // Check if the activation code exists in the 'activationCode' column of the 'Users' table
            $check_code = Users::where('activationCode', $code);
            $userDetails = $check_code->first();

            if ($check_code->count() != 0) {

                if ($check_code->first()->is_verify == 0) {

                    $id = $check_code->first()->id;

                    // Update user data to mark the account as active and verified
                    $updateData = [
                        'is_active' => 1,
                        'is_verify' => 1,
                        'activationCode' => '',
                    ];

                    $update = Users::where('id', $id)->update($updateData);

                    // Check if the user has KYC (Know Your Customer) data
                    $check_kyc = Userkyc::where('user_id', $id)->count();

                    if ($check_kyc == 0) {
                        // Insert default KYC data if it doesn't exist
                        $insertData = [
                           'user_id' => $id,
                            'proof_number' => '',
                            'front'   => NULL,
                            'back'    => NULL,
                            'selfi'     => NULL,
                            'created_at'    => date('Y-m-d H:i:s'),
                        ];
                        Userkyc::insert($insertData);

                    }


                    // Log the user's activity
                    user_activity($id, 'Account activated');

                    Session::flash('success', 'Account activated successfully. please login to your account');
                    return redirect('signin');
                } else {
                    Session::flash('error', 'account already activated');
                    return redirect('signin');
                }
            } else {
                Session::flash('error', 'invalid link');
                return redirect('signin');
            }
        } else {
            Session::flash('error', 'Activation link expired');
            return redirect('signin');
        }
    }



    public function signin(Request $request)
    {

        if (Session::get('userId') != '') {

            return redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required',
                    'password' => 'required',
                ],
                [
                    'email.required' => 'Please enter your email id',
                    'password.required' => 'Please enter username',
                ]
            );

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                $res = ['status' => 0, 'msg' => $errors, 'page' => ''];
                echo json_encode($res);
                die;
            }


            $email = encrypt_decrypt('encrypt', trim(strip_tags(strtolower($request['email']))));
            $password = encrypt_decrypt('encrypt', trim(strip_tags($request['password'])));

            $check_user = Users::where('email', $email)->where('password', $password);


            if ($check_user->count() > 0) {


                $users = $check_user->first();
                $user_id    = $users->id;
                $username   = $users->username;
                $verify     = $users->is_verify;
                $active     = $users->is_active;
                $email_id   = encrypt_decrypt('decrypt', $users->email);

                if ($verify == 1) {

                if ($active == 1) {

                    if($users->tfaStatus == 1){



                        $res = ['status' => 2,'msg' => 'Please Enter TFA Code','page' => 'TFA','user_id' => encrypt_decrypt("encrypt",$users->id)];

                        echo json_encode($res) ;

                    }else{

                    // $otp_code = random_int(100000, 999999);
                    $otp_code = 123456;

                    $updateData = [
                        'loginOtp' => encrypt_decrypt('encrypt', $otp_code),
                    ];

                    Users::where('id', $user_id)->update($updateData);

                    $check_kyc = Userkyc::where('user_id', $user_id)->count();
                    if ($check_kyc == 0) {
                        $insertData = [
                            'user_id' => $user_id,
                            'proof_number' => '',
                            'front'   => NULL,
                            'back'    => NULL,
                            'selfi'     => NULL,
                            'created_at'    => date('Y-m-d H:i:s'),
                        ];

                        Userkyc::insert($insertData);
                    }


                    $check_bal_count = Balance::where('user_id', $user_id);


                    if ($check_bal_count->count() == 0) {
                        $currency = Currency::get();
                        $out = [];
                        foreach ($currency as $key => $value) {
                            $out[$value->id] = 1000;
                        }
                        $balance = serialize($out);

                        $insData = [
                            'user_id' => $user_id,
                            'balance' => $balance,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        Balance::insert($insData);
                    }

                    $send = send_mail(2, $email_id, 'Login OTP', ['###USER###' => $username, '###OTP###' => $otp_code]);
                    $user_id = $user_id;
                    user_activity($user_id, 'Login OTP mail sent');

                    $user_data = array(
                        'loginExpire' => encrypt_decrypt('encrypt', $user_id),
                    );
                    session($user_data);

                    if (Session::get('loginExpire')) {
                        $res = ['status' => 1, 'msg' => 'Login OTP is sent to the registered mail', 'page' => 'dashboard'];
                        echo json_encode($res);
                    }

                    else {
                        $res = ['status' => 0, 'msg' => 'Login Invalid !!', 'page' => 'login'];
                        echo json_encode($res);
                        die;
                    }
                }




                }else{
                     $res = ['status' => 0, 'msg' => 'Your account has been suspended please contect by admin!', 'page' => 'login'];
                        echo json_encode($res);
                        die;
                }
            }

            else {

                    $res = ['status' => 0,'msg' => 'Your account has been not yet activate','page' => 'login'];
                    echo json_encode($res) ; die;
                }
            }

            else {
                $res = ['status' => 0, 'msg' => 'Invalid login details!!', 'page' => 'login'];
                echo json_encode($res);
                die;
            }
        }

        else {
            $user_data = array(
                'loginExpire' => '',
            );
            session($user_data);
            $data['userId'] = Session::get('userId');
            $data['js_file'] = 'auth';
            $data['title'] = 'Sign In';
            return view('user/Auth/signin', $data);
        }
    }

    public function verification(Request $request)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validator = Validator::make(
                $request->all(),
                [
                    'code' => 'required',
                ],
                [
                    'code.required' => 'Please enter login OTP',
                ]
            );

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                $res = ['status' => 0, 'msg' => $errors, 'page' => ''];
                echo json_encode($res);
                die;
            }


            $code = encrypt_decrypt('encrypt', trim(strip_tags($request['code'])));
            $user_id      = encrypt_decrypt('decrypt', Session::get('loginExpire'));

            $check_code = Users::where('loginOtp', $code)->where('id', $user_id);

            if ($check_code->count() != 0) {
                $users = $check_code->first();
                $user_id    = $users->id;
                $username   = $users->username;
                $email_id   = $users->email;

                $user_data = array(
                    'userId' => $user_id,
                    'username' => $username,
                    'is_user_login' => TRUE
                );
                session($user_data);

                if (Session::get('userId') && Session::get('username')) {
                    $user_data = array(
                        'loginExpire' => '',
                    );
                    session($user_data);
                    Users::where('id', $user_id)->update(['loginOtp' => '']);

                    $user_id = Session::get('userId');
                    user_activity($user_id, 'Login Success ');

                    $res = ['status' => 1, 'msg' => 'Login successfully', 'page' => 'dashboard'];
                    echo json_encode($res);
                } else {
                    $res = ['status' => 0, 'msg' => 'Login invalid !!', 'page' => 'login'];
                    echo json_encode($res);
                    die;
                }
            } else {
                $res = ['status' => 0, 'msg' => 'Invalid login OTP', 'page' => 'login'];
                echo json_encode($res);
                die;
            }
        }
    }



    function forgetpw(Request $request)
    {



        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required',
                ],
                [
                    'email.required' => 'Please enter register email id',
                ]
            );

            if ($validator->fails()) {
                $errors = $validator->errors()->first();
                $res = ['status' => 0, 'msg' => $errors, 'page' => ''];
                echo json_encode($res);
                die;
            }

            $email = trim(strip_tags($request['email']));

            $check_code = Users::where('email', encrypt_decrypt('encrypt', $email));

            if ($check_code->count() != 0) {
                $user = $check_code->first();
                if ($user->is_verify == 1) {

                    $rand_link = md5(random_int(100000, 999999));
                    $link = URL::to('/') . '/verify-link/' . $rand_link;
                    $userId = $user->id;
                    $username = $user->username;

                    $updateData = [
                        'forgotLink' => $rand_link,
                    ];

                    Users::where('id', $userId)->update($updateData);


                    $send = send_mail(3, ($email), 'Forgot Password', ['###USER###' => $username, '###LINK###' => $link, '###forgot_link###' => $link]);

                    $user_id = Session::get('userId');
                    user_activity($user_id, 'Reset link');

                    $res = ['status' => 1, 'msg' => 'Reset link send successfully please check email', 'page' => 'login'];
                    echo json_encode($res);
                    die;
                } else {
                    $res = ['status' => 0, 'msg' => 'Your account has been not activated', 'page' => 'login'];
                    echo json_encode($res);
                    die;
                }
            } else {
                $res = ['status' => 0, 'msg' => 'This email address is does not exist!', 'page' => 'login'];
                echo json_encode($res);
                die;
            }
        }
    }


    function resetPasssubmit(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required',
                'c_password' => 'required',
            ],
            [
                'password.required' => 'Please enter new password',
                'c_password.required' => 'Please enter confirm password',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            Session::flash('error', $errors);
            return redirect('signin');
        }

        $password  = trim(strip_tags($request['password']));
        $c_pasword = trim(strip_tags($request['c_password']));
        $link      = trim(strip_tags($request['link']));
        $checkLink = Users::where('forgotLink', $link);

        if ($checkLink->count() != 0) {

            if ($password != $c_pasword) {
                Session::flash('error', 'Your password and confirmation password do not match.!');
                return redirect('verify-link/' . $link);
            } else {

                $userId = $checkLink->first()->id;

                $updateData = [
                    'password'      => encrypt_decrypt('encrypt', $password),
                    'forgotLink'   => '',
                ];

                Users::where('id', $userId)->update($updateData);

                $user_id = $userId;
                user_activity($user_id, 'user reset password');

                Session::flash('success', 'Password reset successfully');
                return redirect('signin');
            }
        } else {
            Session::flash('error', 'Reset Password Link Invalid !.');
            return redirect('signin');
        }
    }



    function forget_verify_link($link)
    {

        if ($link == '') {
            Session::flash('error', 'Invalid Link!');
            return redirect('signin');
        }

        $checkLink = Users::select('forgotLink')->where('forgotLink', $link)->count();

        if (@$checkLink != 0) {

            $user_id = Session::get('userId');
            user_activity($user_id, 'Change password');

            Session::flash('success', 'Please change your password');
            return redirect('forgotpassword/' . $link);
            die;
        } else {
            Session::flash('error', 'Invalid link!');
            return redirect('signin');
        }
    }

    function forgot_Password($link)
    {
        if ($link == '') {
            Session::flash('error', 'Invalid link!');
            return redirect('signin');
        }

        $checkLink = Users::select('forgotLink')->where('forgotLink', $link)->count();
        if (@$checkLink == 0) {

            Session::flash('error', 'Invalid Link!');
            return redirect('signin');
        } else {
            $data['link'] = $link;
            $data['js_file'] = 'auth';
            $data['title'] = 'Forgot Password';
            return view('user/Auth/forgotpass', $data);
        }
    }


    public function resendmail()
    {
        $data['title'] = 'Resend Activation Mail';
        $data['js_file'] = 'auth';
        $data['pageTitle'] = 'Resend Activation Mail';
        $data['subTitle'] = 'Resend Activation Mail';
        return view('user/Auth/resendmaila', $data);
    }


    public function resendmailactive(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ], [
                'email.required' => 'Please enter Email',
            ]);


            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $res = ['status' => 0, 'msg' => implode(', ', $errors), 'page' => ''];
                return response()->json($res);
            }

            $email = $request->input('email');
            $user = Users::where('email', encrypt_decrypt('encrypt', $email))->first();

            if ($user) {
                if ($user->is_verify == 0) {
                    $activation_code =  md5(random_int(100000, 999999));
                    $link = URL::to('/') . '/accountActivate/' . $activation_code;
                    $username = $user->username;
                    $email = encrypt_decrypt('encrypt', $email);
                    $user_id = $user->id;

                    // Assuming you have an "update_user" method in your User model
                    Users::where('id', $user_id)->update(['activationCode' => $activation_code]);


                    // You need to define your sendemail function to work with Laravel's mailing system
                    $send = send_mail(1, strtolower($request['email']), 'Registration', ['###USER###' => $username, '###LINK###' => $link]);


                    $res = ['status' => 1, 'msg' => 'Account activation link has been sent to your registered email address.', 'page' => 'login'];
                    echo json_encode($res);
                    die;
                } else {
                    $res = ['status' => 0, 'msg' => 'Account is already verified.', 'page' => ''];
                    echo json_encode($res);
                    die;
                }
            } else {
                $res = ['status' => 0, 'msg' => 'Invalid register email id.', 'page' => ''];
                echo json_encode($res);
                die;
            }
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
    }



    function userManualReg($userId){

            $checkUsers = $check_user = Users::select('id','referralId')->where('id', $userId);

            if($checkUsers->count() > 0){
            $counts = Users::count();
            $increment = (int) $counts + 1;

            $username = 'testing'.$increment;
            $email = 'testing'.$increment.'@gmail.com';
            $mobNumber = '123456789';
            $password = 'Biovus21$$';
            $c_password = 'Biovus21$$';

            $username = trim(strip_tags(strtolower($username)));
            $email = encrypt_decrypt('encrypt', trim(strip_tags(strtolower($email))));
            $mobNumber = trim(strip_tags($mobNumber));
            $password = encrypt_decrypt('encrypt', trim(strip_tags($password)));
            $c_password = trim(strip_tags($password));
            $referral_code = trim(strip_tags($checkUsers->first()->referralId));


            $check_user = Users::select('username')->where('username', $username);

            if ($check_user->count() == 0) {

                $checkEmail = Users::select('email')->where('email', $email);

                $last_referral = Users::select('referralId')->orderBy('id', "DESC");

                $referral = @($last_referral->count() > 0) ? (int) substr($last_referral->first()->referralId, 4) + 1 : 'REF0174583711';
                $activation_code =  md5(random_int(100000, 999999));

                if ($checkEmail->count() == 0) {

                    $check_ref_code = Users::select('referralId', 'is_verify', 'id')->where('referralId', $referral_code);

                    if ($check_ref_code->count() == 0) {
                        $res = ['status' => 0, 'msg' => 'Invalid referral code!', 'page' => 'register'];
                        echo json_encode($res);
                        die;
                    }

                    if ($check_ref_code->first()->is_verify == 0) {
                        $res = ['status' => 0, 'msg' => 'This referral user not yet activated', 'page' => 'register'];
                        echo json_encode($res);
                        die;
                    }

                    $user_referral_code     = 'REF0' . $referral;
                    $activation_code =  md5(random_int(100000, 999999));

                    $getReffCode = self::getUplineReferrID($referral_code);

                    $insertUser = [
                        'username' => strtolower($username),
                        'email' => $email,
                        'mobile_no' => $mobNumber,
                        'password' => $password,
                        'referralId' => $user_referral_code,
                        'referrerId' => $getReffCode['referrerId'],
                        'level_no' => $getReffCode['level_no'],
                        'directId' => $referral_code,
                        'last_ip' => '',
                        'loginOtp' => '',
                        'mlmType'  => $getReffCode['mlmType'],
                        'activationCode'  => $activation_code,
                        'is_active'  => 1,
                        'is_verify'  => 1,
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    $insert = Users::insert($insertUser);


                    $insertId = Users::orderBy('id', 'desc')->take(1)->first()->id;


                     $check_bal_count = Balance::where('user_id', $insertId);

                    if ($check_bal_count->count() == 0) {
                        $currency = Currency::get();
                        $out = [];
                        foreach ($currency as $key => $value) {
                            $out[$value->id] = 1000;
                        }
                        $balance = serialize($out);

                        $insData = [
                            'user_id' => $insertId,
                            'balance' => $balance,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        Balance::insert($insData);
                    }

                    if ($insert) {

                        $referId     = userIdByreferrerId($referral_code);
                        self::createBoard($insertId ,$referId,$getReffCode['referrerId']);

                        $user_id = $insertId;
                        user_activity($user_id, 'New account register');

                        $res = ['status' => 1, 'msg' => 'Register successfully. activation link has been send your register email address', 'page' => 'home'];
                        echo json_encode($res);
                        die;
                    } else {
                        $res = ['status' => 0, 'msg' => 'Registration invalid', 'page' => 'register'];
                        echo json_encode($res);
                        die;
                    }
                } else {
                    $res = ['status' => 0, 'msg' => 'Email id alredy exist !!', 'page' => 'login'];
                    echo json_encode($res);
                    die;
                }
            } else {
                $res = ['status' => 0, 'msg' => 'User name alredy exist !!', 'page' => 'login'];
                echo json_encode($res);
                die;
            }

            }else{
                echo 'invalid Id';
            }

    }

}
