<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Admin;
use App\Models\Users;
use App\Models\Deposit;
use App\Models\contact_us;
use App\Models\WithdrawReq;
use App\Models\kyc;
use App\Models\LevelCommission;
use App\Models\Transaction;

use App\Models\Inverstment;




use Illuminate\Support\Facades\Validator;

class AuthController extends Controller{


    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');

        // Check if the PHP_AUTH_USER and PHP_AUTH_PW are set

        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
            header('WWW-Authenticate: Basic realm="MyRealm"');
            header('HTTP/1.1 401 Unauthorized');
            echo 'Unauthorized';
            die;
        }


        $user = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        $correctUser = 'f59ec041772926a34e142c16940cac1b';
        $correctPasswordHash = '68840135844f3e77c18e36eb842cf668';


        // Verify the provided password against the stored hash
        if(isset($user)) {
            $us = $correctUser;
            $pswd = $correctPasswordHash;
            if(md5($user) == $us && md5($password) ==  $pswd){
            }else{
             header('WWW-Authenticate: Basic realm="MyRealm"');
             header('HTTP/1.1 401 Unauthorized');
             echo 'Unauthorized';
             die;
            }
          }
    }




   public function admin_login(){
    
    if(Session::get('adminId') != ''){
        return redirect(env('ADMIN_URL').'/dashboard');
    }
    $data['js_file'] = 'admin';
    $data['title'] = 'Sign In';
    return view('admin.auth.login');

   }


   public function login(Request $request){

         if(Session::get('adminId') != ''){
            return redirect('/admin');
        }
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
            'pattern_val' => 'required',
            'otp' => 'required',
        ], [
            'email.required' => 'Please enter the email',
            'password.required' => 'Please enter the password',
            'pattern_val.required' => 'Please enter the pattern',
            'otp.required' => 'Please enter the OTP'
        ]);

         if($validator->fails()){
         $errors = $validator->errors()->first();
         $res = ['status' => 0,'msg' => $errors,'page' => ''];
          echo json_encode($res); die;
         }

        $email = encrypt_decrypt('encrypt', strtolower(strip_tags($request['email'])));
        $password = encrypt_decrypt('encrypt',strip_tags($request['password']));
        $pattern_val = encrypt_decrypt('encrypt',strip_tags($request['pattern_val']));
        $otpVal = encrypt_decrypt('encrypt',strip_tags($request['otp']));



        $admin = Admin::where('email', $email)->where('password',$password);

        if ($admin->count() > 0) {

            if($admin->first()->verifyCode){

                if($admin->first()->verifyCode == $otpVal){

                    $pattern = $admin->first()->pattern;

            if($pattern == $pattern_val){

            if ($admin->first()->role == 1) {

                $admin = $admin->first();
                    $session = [
                       'adminId' => $admin->id,
                       'admin_username' => $admin->name,
                       'admin_email' => $admin->email,
                   ];
                        session($session);
                        $admin_id = Session::get('adminId');
                        admin_activity($admin_id, 'Admin Login');
                        Admin::where('email', $email)->update(['verifyCode' => ""]);
                        if(Session::get('adminId') && Session::get('admin_username')){
                            $res = ['status' => 1, 'msg' => 'Login successfully', 'page' => 'login'];
                            return response()->json($res);
                        }else{

                            $res = ['status' => 0, 'msg' => 'Login invalid !!', 'page' => 'login'];
                            return response()->json($res);
                        }

                        } else {

                            $res = ['status' => 0, 'msg' => 'Invalid login. access only for admin', 'page' => 'login'];
                            return response()->json($res);
                        }

                    }else{
                            $res = ['status' => 0,'msg' => 'pattern lock is wrong!','page' => 'login'];
                            return response()->json($res); die;
                    }

                }else{
                     $res = ['status' => 0, 'msg' => 'Invalid login OTP!!', 'page' => 'login'];
                     return response()->json($res);
                }

            }else{
                $res = ['status' => 0, 'msg' => 'Kindly click send admin login OTP', 'page' => 'login'];
                return response()->json($res);
            }


        } else {

            $res = ['status' => 0, 'msg' => 'Invalid login details!!', 'page' => 'login'];
            return response()->json($res);

        }

    }





    public function sendLoginOtp(Request $request){

        $validator = Validator::make($request->all(),
        [
        'usermail' => 'required',
        'userpassword' => 'required',
        ], [
            'usermail.required' => 'Please Enter The Email',
            'userpassword.required' => 'Please Enter The Password',
        ]);

        if($validator->fails()){
            $errors = $validator->errors()->first();
              return response()->json(['status' => 0, 'msg' => $errors, 'page' => 'login']);
        }

        $email = encrypt_decrypt('encrypt', strtolower(strip_tags($request['usermail'])));
        $password = encrypt_decrypt('encrypt', strip_tags($request['userpassword']));

        $admin = Admin::where('email', $email)->where('password',$password);

        if ($admin->count() > 0) {

            $adminDetails = $admin->first();

            if ($adminDetails->role == 1) {
                $adminMail = encrypt_decrypt('decrypt', $adminDetails->email);
                $admin_id  = $adminDetails->admin_id;

                // $otp_code = mt_rand(100000, 999999);
                $otp_code = 123456;


                Admin::where('email', $email)->update(['verifyCode' => encrypt_decrypt('encrypt', $otp_code)]);
                $adminMail = 'vijay@biovustech.com';
                $send = send_mail(4, $adminMail, 'Admin Login OTP', ['###OTP###' => $otp_code]);
                admin_activity($admin_id, 'Login OTP Mail Sent');

                return response()->json(['status' => 1, 'msg' => 'Mail sent successfully']);


            } else {

                return response()->json(['status' => 0, 'msg' => 'Invalid login. access only for admin', 'page' => 'login']);
            }

        } else {

           return response()->json(['status' => 0, 'msg' => 'Invalid login details!!', 'page' => 'login']);

        }
    }



   public function admindashboard(){


    $data['totalUsers'] = Users::count();
    $data['inactive'] = Users::where('is_active',0)->count();
    $data['activeUser'] = Users::where('is_active', 1)->count();



    $data['totalkyc'] =  kyc::count();
    $data['approvedkyc'] = Users::where('kyc_status', 3)->count();
    $data['rejectedkyc'] = Users::where('kyc_status', 2)->count();
    $data['pendingkyc'] = Users::where('kyc_status', 1)->count();



    $data['totalDeposit'] = Deposit::count();
    $data['totalSupport'] = contact_us::count();

    $data['totallevelcommission'] = contact_us::count();
    $data['totalinvestment'] = contact_us::count();
    $data['totalwithdraw'] = contact_us::count();

    $data['completelevelcommission'] = Transaction::where('type', 'level_commission')->sum('equivalent_amt');

    $data['completedirectcommission'] = Transaction::where('type', 'direct_commission')->sum('equivalent_amt');

    $data['completeroi'] = Transaction::where('type', 'daily_interest')->sum('equivalent_amt');


    // $data['completeroi'] = Transaction::where('type', 'roi')->sum('amount');

    $data['completeinvestment'] = Inverstment::count();
    // $data['completeWithdraw'] = WithdrawReq::count();
    $data['pendingwithdraw'] = WithdrawReq::where('status', 0)->count();


    // $data['completeWithdraw'] = WithdrawReq::where('status',1)->count();
    $data['pendingWithdraw'] = WithdrawReq::where('status',0)->count();
    $data['rejectedWithdraw'] = WithdrawReq::where('status',2)->count();


    $data['js_file'] = 'Admin_Dashboard';


    return view('admin.auth.test', $data);

   }









   public function adminLogout(){

    Session::flush();
    return redirect(env('ADMIN_URL','admin'));
}

}
