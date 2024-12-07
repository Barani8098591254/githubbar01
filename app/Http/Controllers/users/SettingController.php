<?php

namespace App\Http\Controllers\users;

use App\Models\Useractivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Users;
use Session;
use DB;
use App\Models\Userkyc;
use App\Models\Deposit;
use App\Models\Currency;
use App\Models\UserModel;
use App\Models\Plan;
use App\Models\LevelCommission;
use URL;
use PragmaRX\Google2FAQRCode\Google2FA;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{


    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

    public function userprofile(Request $request)
    {



        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validatedData = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'dob' => 'required',
                'mobile' => 'required',
                'address' => 'required',
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
            ], [
                'firstname.required' => 'Enter first name',
                'lastname.required' => 'Enter last name',
                'dob.required' => 'Select your date of birth',
                'mobile.required' => 'Enter your mobile number',
                'address.required' => 'Enter your current address',
                'country.required' => 'Select your country',
                'state.required' => 'Enter your state',
                'city.required' => 'Enetr your city',
            ]);



            $firstname = trim(strip_tags($request['firstname']));
            $lastname = trim(strip_tags($request['lastname']));
            $dob = trim(strip_tags($request['dob']));
            $mobile = trim(strip_tags($request['mobile']));
            $address = trim(strip_tags($request['address']));
            $country = trim(strip_tags($request['country']));
            $state = trim(strip_tags($request['state']));
            $city = trim(strip_tags($request['city']));

            $userprofile = '';

            
            $updateData = [
                'firstname' => $firstname,
                'lastname'  =>  $lastname,
                'mobile_no'  => $mobile,
                'dob'     =>   $dob,
                'address'    => $address,
                'country'    => $country,
                'state'      =>   $state,
                'city'       => $city

            ];

            $user_id = Session::get('userId');

            $update = Users::where('id', $user_id)->update($updateData);

            if ($update) {

                user_activity($user_id, 'Profile Update');

                $res = ['status' => 1, 'msg' => 'User profile has been update successfully', 'page' => '', 'img' => $userprofile];
                echo json_encode($res);
                die;
            } else {

                $res = ['status' => 0, 'msg' => 'Oops somthing went wrong!', 'page' => ''];
                echo json_encode($res);
                die;
            }
        }

        $userId = Session::get('userId');
        $user = Users::where('id', $userId)->first();

        if ($user->tfaStatus == 0) {
            $google2fa = new Google2FA();
            $data['secretKey'] = $google2fa->generateSecretKey();

            $data['qrcode'] = $google2fa->getQRCodeInline(
                config('MLM'),
                encrypt_decrypt('decrypt', $user->email),
                $data['secretKey']
            );
            $data['user'] =  (int)$user->tfaStatus;
        } else if ($user->tfaStatus == 1) {

            $data['secretKey'] = $user->tfa_secret;

            $data['user'] =  (int)$user->tfaStatus;

            $data['randcode'] =  $user->randcode;
        }


        $data['js_file'] = 'profile';

        $data['title'] = 'Profile';
        $data['pageTitle'] = 'User Profile';
        $data['subTitle'] = 'Profile';
        $data['user'] = $user;

        $data['country'] = Country::select('id', 'name')->get();
        $data['kyc'] = Userkyc::where('user_id', $userId)->first();
        $data['checkWpin'] = Users::select('w_pin')->where('id', $userId)->first();

        return view('user.Setting.profile', $data);
    }


    public function profile_pic(Request $request)
    {

        $userId = userId();
        $file = $_FILES["file"];
        $path = 'user_profile';

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $frontImg = Cloudinary::upload($request->file('file')->getRealPath())->getSecurePath();

        if ($frontImg) {
            $frontImg = $frontImg;
            Users::where('id', $userId)->update(['profile_pic' => $frontImg]);
            $res = ['status' => 1, 'msg' => 'User profile upload successfully', 'page' => ''];
            echo json_encode($res);
            die;
        } else {
            $res = ['status' => 0, 'msg' => 'User profile upload invalid', 'page' => ''];
            echo json_encode($res);
            die;
        }
    }


    public function deposit()
    {

        $data['currencyList'] = Currency::where('status', 1)->where('type', 1)->where('deposit_status', 1)->get();
        $data['title'] = 'Deposit';
        $data['js_file'] = 'deposit';
        $data['pageTitle'] = 'Deposit';
        $data['subTitle'] = 'Deposit';
        return view('user.Setting.deposit', $data);
    }

    public function create_address($currency)
    {
        $userModel = new UserModel();
        $currency = Currency::where('status', 1)->where('deposit_status', 1)->where('symbol', $currency);

        if ($currency->count() > 0) {
            $userId = userId();

            $result = $userModel->createAddress($currency->first()->symbol, $userId, $currency->first()->network_type);

            $balance = get_balance($userId, $currency->first()->id);

            if ($currency->first()->network_type == '') {
                $network = $currency->first()->name . ' ' . ' Network';
            } else {
                $network = strtoupper($currency->first()->network_type) . ' ' . ' Type Token Network';
            }

            if ($result['status'] == 1) {
                $qrcode = 'https://chart.googleapis.com/chart?cht=qr&chl=' . $result['address'] . '&chs=192x192&chld=L|0';

                $res = ['status' => 1, 'address' => $result['address'], 'currency' => $result['currency'], 'qrcode' => $qrcode, 'balance' => number_format($balance, 8), 'network' => $network, 'tag' => ($result['tag']) ? $result['tag'] : ''];
                echo json_encode($res);
                die;
            } else {
                $qrcode = 'https://chart.googleapis.com/chart?cht=qr&chl=&chs=192x192&chld=L|0';
                $res = ['status' => 0, 'address' => '', 'currency' => $curr, 'qrcode' => $qrcode, 'balance' => number_format($balance, 8), 'network' => $network, 'tag' => ($result['tag']) ? $result['tag'] : ''];
                echo json_encode($res);
                die;
            }
        } else {
            $qrcode = 'https://chart.googleapis.com/chart?cht=qr&chl=&chs=192x192&chld=L|0';
            $res = ['status' => 2, 'address' => '', 'currency' => '', 'qrcode' => $qrcode, 'balance' => number_format(0, 8), 'network' => '', 'tag' => ''];
            echo json_encode($res);
            die;
        }
    }


    public function withdraw()
    {
        $data['title'] = 'Withdraw';
        $data['js_file'] = '';
        $data['pageTitle'] = 'Withdraw';
        $data['subTitle'] = 'Withdraw';
        return view('user.Setting.withdraw', $data);
    }



    function getLevelInformation() {

        $planData = Plan::select('id')->where('status', 1)->orderBy('id','ASC')->first();

        if($planData){
            $result = LevelCommission::where('plan_id',$planData->id)->get()->toArray();
        } else {
            $result = array();
        }

        return $result;
    }


    public function userreferral()
    {
        $data['levelsData'] = self::getLevelInformation();

        $userData = Users::select('referralId')->where('id', userId())->first();

        $data['directRef'] = Plan::select('direct_commission')->where('status',1)->first();



        $userData = Users::select('referralId')->where('id',userId())->first();

        if ($userData) {
            $data['referralLink'] = URL::to('/signup') . '?ref=' . $userData->referralId;
            $data['referralCount'] = Users::select('referralId')->where('referrerId', $userData->referralId)->count();
        } else {
            $data['referralCount'] = 0;
            $data['referralLink'] = '';
        }


        $data['plan'] = plan::where('status', 1)->where('status', 1)->get();
        $data['currencyList'] = Currency::where('type',0)->where('status', 1)->where('withdraw_status', 1)->get();


        $data['title'] = 'Referral';
        $data['js_file'] = '';
        $data['pageTitle'] = 'Referral';
        $data['subTitle'] = 'Referral';
        return view('user.Setting.referral', $data);
    }

    public function fetchLevelCommissions(Request $request)
    {
        $planId = $request->input('id');

        $levelcommsionid = $request->input('plan_id');
        $plan = Plan::find($planId);


        $levelsData = LevelCommission::where('plan_id', $levelcommsionid)->get();


        return response()->json(['levelsData' => $levelsData]);

    }

    public function myreferrals()
    {
        $userData   = Users::select('referralId')->where('id',userId())->first();
        $data['referral'] = Users::where('referrerId',$userData->referralId)->orderBy('id','DESC')->get();

        $data['js_file'] = '';
        $data['title'] = 'My Referral';
        $data['pageTitle'] = 'My Referral';
        $data['subTitle'] = 'My Referral';
        return view('user.Setting.myreferrals', $data);
    }


    public function getMyReferraldata(Request $request)
    {
        // Get the user ID, assuming there's a function called userId() that provides it
        $userId = userId();

        // Get parameters from the DataTables AJAX request
        $draw = $request->input('draw');
        $row = $request->input('start');
        $rowperpage = $request->input('length');
        $columnIndex = $request->input('order.0.column');
        $columnName = 'id'; // You should specify the actual column name
        $columnSortOrder = 'desc'; // Specify sorting order (asc or desc)
        $searchValue = $request->input('search.value');

        // Date search values
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        // Initialize a search query array
        $searchQuery = [];

        // If there is a search value, add it to the search query
        if (!empty($searchValue)) {
            $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%" . $searchValue . "%' or UeAVBvpelsUJpczNv.referralId like '%" . $searchValue . "%')";
        }

        // Date filter
        if (!empty($searchByFromdate) && !empty($searchByTodate)) {
            $startDate = $searchByFromdate . ' 00:00:00';
            $endDate = $searchByTodate . ' 23:59:59';
            $searchQuery[] = "(UeAVBvpelsUJpczNv.created_at between '" . $startDate . "' and '" . $endDate . "')";
        }

        // Define the WHERE clause

        $referralId = user_details(userId(),'referralId'); // Assuming referralId should be based on the user ID

        $WHERE = "WHERE directId= '" . $referralId . "'";
        if (!empty($searchQuery)) {
            $referralId = $referralId;
            $WHERE = " WHERE " . implode(' and ', $searchQuery) . ' and directId = '."'". $referralId ."'";
        }

        // Get total records count
        $totalRecords = Users::where('directId', $referralId)->count();

        // Get total records count with filtering
        $sel = DB::select("SELECT count(*) as allcount from UeAVBvpelsUJpczNv " . $WHERE);
        $totalRecordwithFilter = $sel[0]->allcount;

        // Fetch data with pagination and sorting
        $empQuery = DB::select("SELECT * FROM UeAVBvpelsUJpczNv $WHERE
            ORDER BY $columnName $columnSortOrder
            LIMIT $row, $rowperpage",);

        $data = [];
        $i = $row + 1;

        foreach ($empQuery as $key => $value) {
            $status = ($value->is_active == 1) ? '<span class="label text-success">Active </span>' : '<span class="label text-danger">Deactive </span>';

            $data[] = [
                'id' => $i,
                "userId" => getuserName($value->id),
                'referralId' => $value->referralId,
                'status' => $status, // Use the calculated $status here
                "date" => date('d, M y h:i A', strtotime($value->created_at)),
            ];
            $i++;
        }

        // Prepare the response
        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        ];

        return response()->json($response);
    }





    function userchangepassword(Request $request)
    {



        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validatedData = $request->validate([
                'current_password' => 'required',
                'password' => 'required',
                'c_password' => 'required',

            ], [
                'current_password.required' => 'Enter first name',
                'password.required' => 'Enter last name',
                'c_password.required' => 'Select your date of birth',

            ]);

            $current_password = trim(strip_tags($request['current_password']));
            $password         = trim(strip_tags($request['password']));
            $c_password       = trim(strip_tags($request['c_password']));

            $user_id = Session::get('userId');
            $get_password = Users::where('id', $user_id)->first();

            if (encrypt_decrypt('encrypt', $current_password) == $get_password->password) {

                if ($password == $c_password) {

                    $updateData = [
                        'password'  => encrypt_decrypt('encrypt', $password),
                    ];

                    $email_id = encrypt_decrypt('decrypt', $get_password->email);
                    $username = Session::get('username');

                    $update = Users::where('id', $user_id)->update($updateData);


                    $user_id = Session::get('userId');
                    user_activity($user_id, 'password Change');


                    $res = ['status' => 1, 'msg' => 'Your password changed successfully. Please login again', 'page' => ''];
                    echo json_encode($res);
                    die;
                } else {
                    $res = ['status' => 0, 'msg' => 'Your password and confirmation password do not match.', 'page' => ''];
                    echo json_encode($res);
                    die;
                }
            } else {
                $res = ['status' => 0, 'msg' => 'Current password is wrong!.', 'page' => ''];
                echo json_encode($res);
                die;
            }
        } else {
        }
    }



    public function tfaview()
    {

        $user_id = Session::get('userId');
        $user = Users::find($user_id);
        if ($user !== null) {
            $google2fa = new Google2FA();
            if ($user->tfaStatus == 0) {
                $data['secretKey'] = $google2fa->generateSecretKey();

                // echo $data['secretKey'];
                // die;
                $data['qrcode'] = $google2fa->getQRCodeInline(
                    config('MLM'),
                    encrypt_decrypt('decrypt', $user->email),
                    $data['secretKey'],

                );


                $data['user'] =  (int)$user->tfaStatus;
                $data['js_file'] = 'profile';
                $data['title'] = 'Two - Factor - Authentication ';
                $data['pageTitle'] = 'Two - Factor - Authentication ';
                $data['subTitle'] = 'Two - Factor - Authentication ';
                die;
                return view('user.Setting.profile', $data);
            }

            elseif ($user->tfaStatus == 1) {

                $data['secretKey'] = $user->tfa_secret;

                $data['user'] =  (int)$user->tfaStatus;

                $data['randcode'] =  $user->randcode;

                $data['js_file'] = '';

                $data['title'] = 'Two - Factor - Authentication ';

                $data['pageTitle'] = 'Two - Factor - Authentication ';

                $data['subTitle'] = 'Two - Factor - Authentication ';

                return view('user.Setting.profile', $data);
            }
        } else {
            echo "Error";
        }
    }




    public function tfaenable(Request $request)
    {
        $user_id = Session::get('userId');

        if ($request->isMethod('post')) {
            $request->validate([
                'tfa_code' => 'required',
                'password' => 'required',
            ]);

            $user = Users::find($user_id);
            $ga = new Google2FA();

            $tfa_code = strip_tags($request->input('tfa_code'));
            $secret = strip_tags($request->input('randcode'));
            $password = strip_tags($request->input('password'));



            if (encrypt_decrypt('decrypt', $user->password) == $password) {

                $checkResult = $ga->verifyKey($secret, $tfa_code);

                if ($checkResult == 1) {
                    if ($user->randcode == '' && $user->tfaStatus == 0) {

                        $user->randcode = $secret;
                        $user->tfaStatus = 1;
                        $user->save();

                        session()->flash('success', 'TFA Enabled successfully!');
                        return redirect('logout');
                        die;
                    }
                    elseif ($user->randcode != '' && $user->tfaStatus == 1) {

                        $user->randcode = null;

                        $user->tfaStatus = 0;

                        $user->save();

                        session()->flash('success', 'TFA disabled successfully!');
                        return redirect()->back();
                    }
                } else {
                    session()->flash('error', 'Wrong TFA code!');
                }
            } else {
                session()->flash('error', 'Wrong login password');
            }
        } else {
            session()->flash('error', 'Login password is wrong!');
        }
    }







    public function deposithistory()
    {
        $data['depositList'] = Deposit::where('user_id', userId())->orderBy('id', 'DESC')->get();
        $data['title'] = 'deposit';
        $data['js_file'] = 'deposit';
        $data['pageTitle'] = 'deposithistory';
        $data['subTitle'] = 'deposithistory';
        return view('user.Setting.deposithistory', $data);
    }


    public function usergetdeposithistory(Request $request)
    {
        $userId = userId();
        $draw = $request['draw'];
        $row = $request['start'];
        $rowperpage = $request['length']; // Rows display per page
        $columnIndex = $request['order'][0]['column']; // Column index
        $columnName = $request['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $request['order'][0]['dir']; // asc or desc
        $searchValue = $request['search']['value']; // Search value


        ## Date search value
        $searchByFromdate = $request['searchByFromdate'];
        $searchByTodate = $request['searchByTodate'];

        ## Search Query
        $searchQuery = array();
        if ($searchValue != '') {


            $searchQuery[] = "(deXxaZzBolrXMQLG.currency like '%" . $searchValue . "%' or deXxaZzBolrXMQLG.amount like '%" . $searchValue . "%' or deXxaZzBolrXMQLG.address like '%" . $searchValue . "%' or deXxaZzBolrXMQLG.txid like '%" . $searchValue . "%'or deXxaZzBolrXMQLG.created_at like '%" . $searchValue . "%')";
        }


        // Date filter
        if ($searchByFromdate != '' && $searchByTodate != '') {
            $startDate = $searchByFromdate . ' 00:00:00';
            $endDate = $searchByTodate . ' 23:59:59';
            $searchQuery[] = "(deXxaZzBolrXMQLG.created_at between '" . $startDate . "' and '" . $endDate . "')";
        }

        $WHERE = " WHERE user_id=" . $userId;

        if (count($searchQuery) > 0) {
            $WHERE = " WHERE " . implode(' and ', $searchQuery) . ' and user_id = ' . $userId;
        }


        // Total records count
        $totalRecords = Deposit::where('user_id', $userId)->count();

        // Total records count with filter
        $sel = DB::select("select count(*) as allcount from deXxaZzBolrXMQLG " . $WHERE);
        $totalRecordwithFilter = $sel[0]->allcount;


        $empQuery = DB::select("SELECT * FROM deXxaZzBolrXMQLG $WHERE
                        ORDER BY $columnName $columnSortOrder
                        LIMIT $row, $rowperpage");

        $data = array();
        $i = 1;
        foreach ($empQuery as $status => $value) {
            if ($value->status == 1) {
                $statusLabel = '<span class="label text-success">Completed</span>';
            } elseif ($value->status == 0) {
                $statusLabel = '<span class="label text-danger">Rejected</span>';
            }

            $data[] = array(
                'id' => $i,
                "currency" => $value->currency,
                // "amount" => number_format($value->amount,8),
                'amount' => number_format($value->amount,getDecimal($value->currency)->decimal),
                "address" => '<i class="fa fa-copy curPointer copyAdd" title=' . $value->address . '" data-id="' . $value->address . '"> ' . substr($value->address, 0, 15) . '</i>' . '...',
                "txid" => '<i class="fa fa-copy curPointer copyAdd" title=' . $value->txid . '" data-id="' . $value->txid . '"> ' . substr($value->txid, 0, 15) . '</i>' . '...',
                "status" => $statusLabel,
                "date" => date('d, M y h:i A', strtotime($value->created_at)),
            );
            $i++;
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        echo json_encode($response);
    }









    function security(Request $request)
    {


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validatedData = $request->validate([
                'pin' => 'required',
                'c_pin' => 'required',

            ], [
                'pin.required' => 'Enter security pin',
                'c_pin.required' => 'Enter correct security pin',
            ]);

            $pin = trim($request['pin']);
            $c_pin = trim(strip_tags($request['c_pin']));


            $user_id = Session::get('userId');


            $get_password = Users::where('id', $user_id)->first();



            if ($pin == $c_pin) {

                $updateData = [
                    'w_pin'  => encrypt_decrypt('encrypt', $pin),
                ];

                $email_id = encrypt_decrypt('decrypt', $get_password->email);
                $username = Session::get('user_name');

                $update = Users::where('id', $user_id)->update($updateData);

                $user_id = Session::get('userId');
                user_activity($user_id, 'Withdraw update');

                $res = ['status' => 1, 'msg' => 'Your security Pin Set successfully', 'page' => ''];
                echo json_encode($res);
                die;

                // $send = sendemail($email_id,3,'',['###USER###' => $username]);

            } else {
                $res = ['status' => 0, 'msg' => 'Your security Pin and confirmation security Pin do not match.', 'page' => ''];
                echo json_encode($res);
                die;
            }
        } else {
            $userId = Session::get('userId');
            $data['title'] = 'Security Pin';


            return view('user.Setting.profile', $data);
        }
    }







    public function chnage_wPin(Request $request)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validatedData = $request->validate([
                'current_pin' => 'required',
                'pin' => 'required',
                'c_pin' => 'required',

            ], [
                'current_pin.required' => 'Enter first name',
                'pin.required' => 'Enter last name',
                'c_pin.required' => 'Select your date of birth',
            ]);

            $current_pin = trim(strip_tags($request['current_pin']));
            $pin         = trim(strip_tags($request['pin']));
            $c_pin       = trim(strip_tags($request['c_pin']));

            $user_id = Session::get('userId');
            $get_password = Users::select('w_pin')->where('id', $user_id)->first();

            if (encrypt_decrypt('encrypt', $current_pin) == $get_password->w_pin) {

                if ($pin == $c_pin) {

                    $updateData = [
                        'w_pin'  => encrypt_decrypt('encrypt', $pin),
                    ];

                    $email_id = encrypt_decrypt('decrypt', $get_password->email);
                    $username = Session::get('user_name');

                    $update = Users::where('id', $user_id)->update($updateData);

                    $user_id = Session::get('userId');
                    user_activity($user_id, 'Security pin update');

                    $res = ['status' => 1, 'msg' => 'Your security pin changed successfully.', 'page' => ''];
                    echo json_encode($res);
                    die;
                    // $send = sendemail($email_id,3,'',['###USER###' => $username]);

                } else {
                    $res = ['status' => 0, 'msg' => 'Your security pin and confirmation security pin do not match.', 'page' => ''];
                    echo json_encode($res);
                    die;
                }
            } else {
                $res = ['status' => 0, 'msg' => 'Current cecurity Pin is wrong!.', 'page' => ''];
                echo json_encode($res);
                die;
            }
        }
    }






    public function send_email_pin(Request $request){
        $get_user = encrypt_decrypt('decrypt', $request['pin']);

        if (userId() == $get_user) {

            $check_user = Users::select('id', 'email', 'username')->where('id', $get_user)->first();

            if ($check_user) {

                $user_id = $check_user->id;
                $email = encrypt_decrypt('decrypt', $check_user->email);
                $user_name = $check_user->username;
                $pin = encrypt_decrypt('encrypt', random_int(100000, 999999));
                $link = URL::to('/') . '/reset_security_pin?link=' . $pin;


                $updateData = [
                    'resetPin' => $pin,
                ];

                $update = Users::where('id', $get_user)->update($updateData);

                $send = send_mail(10, $email, 'Reset Security Pin', ['###USER###' => $user_name, '###LINK###' => $link, '###reset_link###' => $link]);


                if ($send) {

                    $res = ['status' => 1, 'msg' => 'Reset link send successfully please check email', 'page' => ''];
                    echo json_encode($res);
                    die;
                }
            } else {

                $res = ['status' => 0, 'msg' => 'Invalid user!.', 'page' => ''];
                echo json_encode($res);
                die;
            }
        } else {
            $res = ['status' => 0, 'msg' => 'Invalid user!.', 'page' => ''];
            echo json_encode($res);
            die;
        }
    }




    function reset_security_pin(Request $request)
    {

        if ($request->link) {
            $get_user = encrypt_decrypt('decrypt', $request->link);

            // if($get_user = userId()){

            $check_user = Users::select('id', 'email', 'username')->where('resetPin', $request->link)->first();



            if ($check_user) {

                $updateData = [
                    'resetPin' => '',
                    'w_pin' => '',
                ];
                $update = Users::where('id', userId())->update($updateData);

                user_activity(userId(), 'Reset withdraw pin');
                Session::flash('success', 'Security pin reset successfully.please set new security pin !.');
                return redirect('profile');
            } else {
                Session::flash('error', 'Reset Pin expire !.');
                return redirect('profile');
            }
        } else {
            Session::flash('error', 'Invalid Link');
            return redirect('profile');
        }



        // }else{
        //     $this->session->set_flashdata('error', 'Reset Pin Expire !.');
        //     redirect('setting','refresh'); die;
        // }

    }



    public function userActivity()
{
    $userId = userId();

    // $data['Useractivity'] = DB::table('UatMuXaJtDhDLqIe')
    // ->join('UeAVBvpelsUJpczNv', 'UatMuXaJtDhDLqIe.userId', '=', 'UeAVBvpelsUJpczNv.id')
    // ->where('UeAVBvpelsUJpczNv.id', $userId)
    // ->orderBy('UatMuXaJtDhDLqIe.id', 'desc')
    // ->get(['UatMuXaJtDhDLqIe.*', 'UeAVBvpelsUJpczNv.*']);


    $data['js_file'] = 'User Activity';
    $data['title'] = 'User Activity';
    $data['pageTitle'] = 'User Activity';
    $data['subTitle'] = 'User Activity';

    return view('user.Setting.useractivity', $data);
}


 public function getuserActivity(Request $request)
 {
     $userId = userId();
                 $draw = $request->input('draw');
                 $row = $request->input('start');
                 $rowperpage = $request->input('length');
                 $columnIndex = $request->input('order.0.column');
                 $columnName = $request->input('columns.' . $columnIndex . '.data');
                 $columnSortOrder = $request->input('order.0.dir');
                 $searchValue = $request->input('search.value');

               ## Date search value
               $searchByFromdate = $request['searchByFromdate'];
               $searchByTodate = $request['searchByTodate'];

                ## Search Query
                $searchQuery = array();
                if($searchValue != ''){
                    $searchQuery[] = "(UatMuXaJtDhDLqIe.activity like '%".$searchValue."%' or UatMuXaJtDhDLqIe.ip like '%".$searchValue."%' or UatMuXaJtDhDLqIe.browser like '%".$searchValue."%' or UatMuXaJtDhDLqIe.os like '%".$searchValue."%')";
                    }
                     $WHERE = " WHERE userId=" . $userId;

                     if (count($searchQuery) > 0) {
                         $WHERE = " WHERE " . implode(' and ', $searchQuery) . ' and userId = ' . $userId;
                     }


                     $totalRecords = Useractivity::count();


                     // ## Total number of records with filtering
                     $sel = DB::select("select count(*) as allcount FROM UatMuXaJtDhDLqIe INNER JOIN UeAVBvpelsUJpczNv ON UatMuXaJtDhDLqIe.userId = UeAVBvpelsUJpczNv.id ".$WHERE);

                     $totalRecordwithFilter = $sel[0]->allcount;

                        $newSortOrder = ($columnSortOrder === 'asc') ? 'desc' : 'asc';

                        $empQuery = DB::select("SELECT UatMuXaJtDhDLqIe.*, UeAVBvpelsUJpczNv.username FROM UatMuXaJtDhDLqIe INNER JOIN UeAVBvpelsUJpczNv ON UatMuXaJtDhDLqIe.userId = UeAVBvpelsUJpczNv.id $WHERE
                        ORDER BY $columnName $newSortOrder
                        LIMIT $row, $rowperpage");



                     $data = array();
                     $i = 1;
                     foreach ($empQuery as $key => $value) {

                         $data[] = array(
                             'id' => $i,
                            //  "userId"=>getuserName($value->userId),
                             "activity"=>$value->activity,
                             "ip"=>$value->ip,
                             "browser"=>$value->browser,
                             "os"=> $value->os,
                             "date" => date('d, M y h:i A', strtotime($value->created_at)),

                         );
                         $i++;
                     }

                     ## Response
                     $response = array(
                         "draw" => intval($draw),
                         "iTotalRecords" => $totalRecords,
                         "iTotalDisplayRecords" => $totalRecordwithFilter,
                         "aaData" => $data
                     );

                     echo json_encode($response);

 }


}



