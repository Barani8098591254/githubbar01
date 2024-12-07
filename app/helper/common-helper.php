<?php
use App\Models\Country;
use App\Models\Users;
use App\Models\Admin;
use Jenssegers\Agent\Facades\Agent;
use App\Models\Adminactivity;
use App\Models\Email_Template;
use App\Models\Setting;
use App\Models\Useractivity;
use App\Models\staticcontent;
use App\Models\Balance;
use App\Models\Userkyc;
use App\Models\Currency;
use Cloudinary\Uploader;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\kyc;
use App\Models\Ipblock;
use App\Models\Plan;
use App\Models\LevelCommission;
use App\Models\Swap;
use App\Models\Inverstment;


// use Session;

function admin_url(){

    return env('ADMIN_URL', null);

}

function adminBaseurl(){
    $url = URL::to('/').'/'.env('ADMIN_URL').'/';
    return $url;
}


function currencyId(){
    return 2;
}


function n($id){
    $currency = Currency::select('decimal')->where('id',$id);

    if($currency->count() > 0){
        return $currency->first()->decimal;
    }else{
        return 8;
    }

}

function encrypt_decrypt($type , $message){
    $encrypt_method = "AES-256-CBC";
    $secret_key = env('KEY');
    $secret_iv = env('IV');
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if($type == 'encrypt'){
    $output = openssl_encrypt($message, $encrypt_method, $key, 0, $iv);
    $encrypt = base64_encode($output);
    return $encrypt;
   }else{
    $decrypt = openssl_decrypt(base64_decode($message), $encrypt_method, $key, 0, $iv);
    return $decrypt;
    }
   }



   function send_mail($id,$toemail,$subject="",$dataArray=[]){


    $template = Email_Template::where('id',$id)->first();
    $site_setting = Setting::first();


    $common_site_setting = [
        '###SITENAME###' => $site_setting->sitename,
        '###LOGO###' => 'https://res.cloudinary.com/dkrgnrfhr/image/upload/v1694241414/logo1_naw20v.png',
        '##LOGO###' => 'https://res.cloudinary.com/dkrgnrfhr/image/upload/v1694241414/logo1_naw20v.png',
        '###FBLINK###' => 'https://www.facebook.com/unlayer',
        '###FBIMG###'  => 'https://cdn.tools.unlayer.com/social/icons/rounded/facebook.png',
        '###LINKED###' => 'https://www.linkedin.com/company/unlayer/mycompany/',
        '###LINKDEDIMG###' => 'https://cdn.tools.unlayer.com/social/icons/rounded/linkedin.png',
        '###INSTALINK###' => 'https://www.instagram.com/unlayer_official/',
        '###INSTAIMG###'  => 'https://cdn.tools.unlayer.com/social/icons/rounded/instagram.png',
        '###TWITLINK###'  => 'https://www.instagram.com/unlayer_official/',
        '###TWITIMG###'  => 'https://res.cloudinary.com/ddgcnuz4k/image/upload/v1694077400/1690643591twitter-x-logo-png_takudy.png',
        '###COPYRIGHT###'  => 'Copyright © 2023 MLM Allrights reserved.',

    ];

    $content = array_merge($common_site_setting,$dataArray);

    $info = array(
            'from' => env("MAIL_FROM_ADDRESS"),
            'name' => $site_setting->sitename,
            'subject' => ($subject) ? $subject : $template->subject,
            'body' => strtr($template->template,$content),
        );

        $emails = trim($toemail);


       $mail =  Mail::send(['html' => 'mail'], $info, function ($message) use($info,$emails)
        {
            $message->to($emails);
            $message->subject($info['subject']);
            $message->from($info['from'], $info['name']);
        });

        return 1;
    }


    function getCountryname($id){
        $country = Country::where('id',$id)->first();

        if($country){
            return $country->name;
        }else{
            return '--';
        }
    }





function setting(){

	$setting = Setting::first();

	return $setting;
}


function users()
{
    $user = Users::first();

	return $user;
}



function admin(){

	$admin = Admin::where('admin_id',adminId())->first();

	return $admin;
}

function adminId(){

	if(@Session::get('adminId')){
		return Session::get('adminId');
	}else{
		return '';
	}
}

function adminMail(){
    if(@Session::get('admin_email')){
        return 'vijay@biovustech.com '; //Session::get('admin_email');
    }else{
        return 'vijay@biovustech.com';
    }

}




function getIP(){


    if (!empty($_SERVER['HTTP_CLIENT_IP']))
     {
       $ip = $_SERVER['HTTP_CLIENT_IP'];
     }
     elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
     {
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
     }
     else
     {
       $ip = $_SERVER['REMOTE_ADDR'];
     }
   return $ip;
}

function getbrowser(){
    $browser = Agent::browser();
    return ($browser) ? $browser : 'browser';

}

function platform(){
    $data['browser'] = Agent::browser();
    $data['browserVersion'] = Agent::version($data['browser']);
    $data['platform'] = Agent::platform();
    $data['full_user_agent_string'] = @$_SERVER['HTTP_USER_AGENT'];

    return $data;
    }


    function admin_activity($admin_id='',$action = ''){


        $admin_id = $admin_id;
        $ip = getIP();

        if($admin_id){
        $browserDtls = platform();

        $InsertData = [
        'adminId' => $admin_id,
        'ip' => ($ip) ? $ip : '',
        'activity' => $action,
        'browser' => ($browserDtls['browser']) ? $browserDtls['browser'] : '',
        'os' => ($browserDtls['platform']) ? $browserDtls['platform'] : '',
        // 'others' => ($browserDtls['full_user_agent_string']) ? $browserDtls['full_user_agent_string'] : '',
        // 'date_time'=>date('Y-m-d H:i:s'),
        ];

        Adminactivity::insert($InsertData);

        return true;

        }else{
        return true;
        }
}



function user_activity($user_id='',$action = ''){


    $user_id = $user_id;
    $ip = getIP();

    if($user_id){
    $browserDtls = platform();

    $InsertData = [
    'userId' => $user_id,
    'ip' => ($ip) ? $ip : '',
    'activity' => $action,
    'browser' => ($browserDtls['browser']) ? $browserDtls['browser'] : '',
    'os' => ($browserDtls['platform']) ? $browserDtls['platform'] : '',
    'others' => ($browserDtls['full_user_agent_string']) ? $browserDtls['full_user_agent_string'] : '',
    'created_at'=>date('Y-m-d H:i:s'),
    ];
    Useractivity::insert($InsertData);

    return true;

    }else{
    return true;
    }
}


// function userId(){
//     $userId = @Session::get('userId');
//         if($userId){
//             return $userId;
//         }else{
//             return '';
//         }
// }



function getkycdetails($id){

    $row = kyc::where('user_id',$id);

        if($row->count() > 0){

            return $row->first();

        }else{

            return FALSE;
        }
}




function getuserName($id){
    $user = Users::select('username')->where('id',$id)->first();

    if($user){
        return $user->username;
    }else{
        return '--';
    }
}


function useruplineCount($uplineCount){
    $user = Users::select('username')->where('uplineCount',$uplineCount)->first();



    if($user){
        return $user->username;
    } else {
        return '--';
    }
}

function userreferrerId($referrerId){
    $user = Users::select('username')->where('referrerId',$referrerId)->first();


    if($user){
        return $user->username;
    } else {
        return '--';
    }
}


function userdirectId($directId){
    $user = Users::select('username')->where('directId',$directId)->first();


    if($user){
        return $user->username;
    } else {
        return '--';
    }
}



function getplanname($id){
    $user = Plan::select('name')->where('id',$id)->first();

    if($user){
        return $user->name;
    }else{
        return '--';
    }
}


function getplan($id){
    $user = Plan::where('id',$id)->first();

    if($user){
        return $user;
    }else{
        return '--';
    }
}


function getadminName($id){
    $user = Users::select('username')->where('id',$id)->first();

    if($user){
        return $user->username;
    }else{
        return 'Admin';
    }
}





function getUserById($id) {

    $user = Users::find($id);


    if ($user) {
        return $user->toArray();
    } else {
        return null;
    }
}



function check_static($id){

    $staticcontent = staticcontent::where('id',$id)->where('status',1)->first();

    return @$staticcontent->description;
}




function get_balance($userId, $currencyId){


    $result = Balance::where('user_id',$userId)->first();


    if($result) {

        $data = unserialize($result->balance);

        if(isset($data[$currencyId])){

            $balance = $data[$currencyId];
            $balance = floatval(preg_replace('/[^\d.]/', '', $balance));
            // $balance = bcadd($balance,0,8);
            $balance = bcadd($balance,0,8);


        } else {

            update_balance($userId, $currencyId, 0);

            $balance = 0;
        }

    } else {

        $balance = 0;
    }

    return $balance;
}




 function get_currency($id) {

        $result = Currency::select('symbol', 'id','usdprice','decimal')->where('id',$id)->first();
        return $result;
}

//  function get_currencySymbol($symbol) {

//         $result = Currency::select('id')->where('symbol',$symbol)->first()->id;

//         echo "<pre>";
//         print_r( $result);
//         die;


//         return $result;
// }


function get_currencySymbol($symbol) {
    $currency = Currency::select('id')->where('symbol', $symbol)->first();

    if ($currency) {
        $result = $currency->id;

        return $result;
    } else {
        return null;
    }
}







 function getDecimal($symbol) {

        $result = Currency::where('symbol',$symbol)->first();
        return $result;
}




function update_balance($userId, $currencyId, $balance){

    $balance = floatval(preg_replace('/[^\d.]/', '', $balance));
        $balance = bcadd($balance,0,8);

        $result = Balance::where('user_id',$userId)->first();

        if($result) {

            $data = unserialize($result->balance);

            // $data[$currencyId] = $balance;

            $update = Balance::where('user_id',$userId)->update(array('balance' => serialize($data)));

            if($update) {

                return TRUE;

            } else {

                return FALSE;
            }

        } else {
            $balance = $out[$currencyId] = 0;
            $balance = serialize($balance);
            // echo $balance;
            // die;
            $insData = [
                'user_id' => $userId,
                'balance' => $balance,
                'created_at' => date('Y-m-d H:i:s')
            ];
            Balance::insert($insData);
            return TRUE;
        }

}


function userId(){
    $userId = @Session::get('userId');
        if($userId){
            return $userId;
        }else{
            return '';
        }
}





 function getKycStatus($status){
    switch ($status) {
        case 0:
        case 2:
            return ['text' => 'Not Yet Uploaded', 'color' => ''];
        case 1:
            return ['text' => 'Pending', 'color' => '#ffc107'];
        case 3:
            return ['text' => 'Approved', 'color' => '#13d487'];
        default:
            return ['text' => 'Rejected', 'color' => '#fd8b8b'];
    }
}





function getuserEmail($id){
    $user = Users::select('email')->where('id',$id)->first();

    if($user){
        return encrypt_decrypt('decrypt',$user->email);
    }else{
        return '--';
    }
}



function upload (Request $request) {
    $file = $request->file('file');


    if ($file->getError() !== UPLOAD_ERR_OK) {
        $return['msg'] = 'File upload failed';
        $return['status'] = 0;
        return $return;
    }

    $extension = $file->getClientOriginalExtension();

    if (!in_array($extension, $allowedExtensions)) {
        $return['msg'] = 'File Must Be In jpg, jpeg, png Format';
        $return['status'] = 0;
        return $return;
    }

    $filename = time() . '.' . $extension;

    try {
        $cloudinaryResponse = Cloudinary::upload($file->getPathname(), array(
            "folder" => $folder
        ));

        if ($cloudinaryResponse) {
            $return['msg'] = $cloudinaryResponse->getSecurePath();
            $return['status'] = 1;
        } else {
            $return['msg'] = 'Image upload error on Cloudinary';
            $return['status'] = 0;
        }
    } catch (\Exception $e) {
        $return['msg'] = 'Error: ' . $e->getMessage();
        $return['status'] = 0;
    }

    return $return;
}



function user_details($id,$key){

    $user = Users::where('id',$id)->first()->$key;


    if($user){
        return $user;
    }else{
        return '';
    }
}



function userStatus($key){
    $id = userId();
    $user = Users::select('is_active','is_verify')->where('id',$id)->first()->$key;

    if($user){
        return $user;
    }else{
        return '';
    }
}


function user_detailsRow($id){
    $user = Users::where('id',$id)->first();

    if($user){
        return $user;
    }else{
        return '';
    }
}

function ipBlock($ip){

    $result = Ipblock::where('ip',$ip)->where('status',1)->count();

    return $result;


}


function getfrom_currency($id){
    $user = Currency::select('symbol')->where('id',$id)->first();

    // echo "<pre>";
    // print_r($user);
    // die;

    if($user){
        return $user->symbol;
    }else{
        return '--';
    }
}





function getto_currency($id){
    $user = Currency::select('symbol')->where('id',$id)->first();

    if($user){
        return $user->symbol;
    }else{
        return '--';
    }
}






function userIdByreferrerId($referrerId){
    $user = Users::where('referralId',$referrerId)->first();
    if($user){
        return $user->id;
    }else{
        return '';
    }
}



