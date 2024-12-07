<?php

namespace App\Http\Controllers\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Users;
use Session;
use DB;
use App\Models\Userkyc;
use App\Models\Deposit;
use App\Models\Currency;
use App\Models\WithdrawReq;
use App\Models\Setting;



class withdrawontroller extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

    public function withdraw()
    {
        $data['currencyList'] = Currency::where('status', 1)->where('type',1)->where('withdraw_status', 1)->get();
        $data['withdrawList'] = WithdrawReq::where('user_id', userId())->orderBy('id', 'DESC')->get();

        $data['settingwithdraw'] = Setting::where('id', 1)->first();

        $data['title'] = 'Withdraw';
        $data['js_file'] = 'withdraw';
        $data['pageTitle'] = 'Withdraw';
        $data['subTitle'] = 'Withdraw';
        return view('user.Setting.withdraw', $data);
    }







    function sendwithdrawotp(Request $request)
    {

        $user_id = $request['value'];

        if ($user_id) {
            $decrypt = encrypt_decrypt('decrypt', $user_id);

            if ($decrypt == userId()) {

                $checkUser = Users::where('id', $decrypt);

                if ($checkUser->count() > 0) {

                    $user = $checkUser->first();

                    if(empty($user->w_pin)){
                        $res = ['status' => 0, 'msg' => 'Kindly set security pin.'];
                         echo json_encode($res);
                         die;
                    }

                    if(setting()->withdraw == 2){
                        $res = ['status' => 0, 'msg' => 'Withdraw disabled'];
                        echo json_encode($res);
                        die;
                    }

                    $getwithdrawdetails = user_details($decrypt,'withdraw_status');

                    if($getwithdrawdetails == 2 || $getwithdrawdetails == ''){
                        $res = ['status' => 0, 'msg' => 'Withdraw disabled contact to admin'];
                        echo json_encode($res);
                        die;
                    }

                    $user_email = encrypt_decrypt('decrypt', $user->email);

                    //    $withdrawotp =  random_int(100000, 999999);

                    $withdrawotp = 123456;

                    $username = $user->username;
                    $user_id = $user->id;

                    $updateDate = [
                        'withdrawotp' =>    encrypt_decrypt('encrypt', $withdrawotp),
                    ];

                    Users::where('id', $user_id)->update($updateDate);

                    $user_id = Session::get('userId');
                    user_activity($user_id, 'Withdraw OTP');

                    $send = send_mail(6, $user_email, 'Withdraw OTP', ['###USER###' => $username, '###OTP###' => $withdrawotp]);



                    $res = ['status' => 1, 'msg' => 'Withdraw OTP send successfully. please check your email !!', 'page' => ''];
                    echo json_encode($res);
                } else {
                    $res = ['status' => 0, 'msg' => 'Invalid user data'];
                    echo json_encode($res);
                }
            } else {
                $res = ['status' => 0, 'msg' => 'Invalid user data'];
                echo json_encode($res);
            }
        }
    }



    public function withdrawSubmit(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validatedData = $request->validate([
                'receive_address' => 'required',
                'currency' => 'required', // Ensure 'currency' is required
                'withdraw_amount' => 'required|numeric',
                'security_pin' => 'required',
                'email_otp' => 'required',
            ], [
                'receive_address.required' => 'Please enter withdraw address',
                'currency.required' => 'Please enter currency', // Corrected field name
                'withdraw_amount.required' => 'Please enter withdraw amount',
                'security_pin.required' => 'Please enter security pin',
                'email_otp.required' => 'Please enter email OTP',
            ]);


            $user_id = Session::get('userId');

            $userId = userId();


            $getUserKydDetails = user_details($userId,'kyc_status');

            $getwithdrawdetails = user_details($userId,'withdraw_status');



            if(setting()->kyc == 1){


                if($getUserKydDetails != 3 || $getUserKydDetails == ''){
                    Session::flash('error', 'Please kindly fill KYC once approved after continue');
                    return redirect('profile');
                }

             }

             if(setting()->withdraw == 2){
                Session::flash('error', 'Withdraw disabled');
                return redirect('withdraw');
             }

             if($getwithdrawdetails == 2 || $getwithdrawdetails == ''){
                Session::flash('error', 'Withdraw disabled contact to admin');
                return redirect('withdraw');
            }

            $userAddress = DB::table('AdAeoXPAFVfEWIEg')->select('address')->where('user_id',$userId)->where('currency',$request['wth-currency']);
            if($userAddress->count() > 0){
                 if(trim(strip_tags(strtolower($request['receive_address']))) == $userAddress->first()->address){
                    Users::where('id', userId())->update(['withdrawotp' => '']);
                    Session::flash('error', 'User deposit address and withdraw address same');
                    return redirect('withdraw');
                 }
            }

            $currencyId = trim(strip_tags($request['currency']));
            $receive_address = trim(strip_tags($request['receive_address']));
            $withdraw_amount = bcadd($request['withdraw_amount'], 0, 5);
            $security_pin = trim(strip_tags($request['security_pin']));
            $addressTag = '';
            $otp = trim(strip_tags($request['email_otp']));

            $checkOtp = Users::select('withdrawotp')->where('id', userId())->first();

            if ($checkOtp->withdrawotp == encrypt_decrypt('encrypt', $otp) && $checkOtp->withdrawotp != '') {

                $currencyDetails = Currency::where('id', $currencyId)->first();
                $withdraw_status = $currencyDetails->withdraw_status;
                $status      = $currencyDetails->status;

                if ($withdraw_status != 1 || $status != 1) {
                    Session::flash('error', 'Currency not valid');
                    return redirect('withdraw');
                }


                $isExist = Users::where('id', userId())->where('w_pin', encrypt_decrypt('encrypt', $security_pin))->first();

                if ($isExist) {

                    $userEmail = encrypt_decrypt('decrypt', $isExist->email);
                    $userName = $isExist->username;

                    $withdrawSettings = DB::table('wsGHkkBbywgOkjXg')->select('cuKZJurxYSsFaXNv.withdraw_status', 'cuKZJurxYSsFaXNv.symbol', 'wsGHkkBbywgOkjXg.*')->Join('cuKZJurxYSsFaXNv', 'cuKZJurxYSsFaXNv.id', '=', 'wsGHkkBbywgOkjXg.currency_id')->where('wsGHkkBbywgOkjXg.currency_id', $currencyId)->first();

                    if ($withdrawSettings) {

                        $minAmount = $withdrawSettings->min;
                        $maxAmount = $withdrawSettings->max;
                        $feeAmount = $withdrawSettings->fee;
                        $binanceFeeAmount = 0;
                        $limitDay  = $withdrawSettings->per_day_limit;
                        $getBalane = get_balance(userId(), $currencyId);
                        $getCurncy = get_currency($currencyId);

                        

                        $totalReqAmount = DB::table('wrhRWuSQVNefeaEO')->where('user_id',$userId)->where('status','!=',2)->whereDate('created_at',date('Y-m-d'))->sum('amount');

                 
                        $userBalance = $getBalane;

                        if ($withdraw_amount > 0.000001) {

                            if ((float)$userBalance >= (float)$withdraw_amount) {

                                if ((float)$withdraw_amount >= (float)$minAmount && (float)$withdraw_amount <= (float)$maxAmount) {

                                    if ((float)$withdraw_amount > (float)$feeAmount) {



                                        $fromDate = date('Y-m-d H:i:s', strtotime('-24 hour'));
                                        $toDate = date('Y-m-d H:i:s');
                                        $sumamount = 0;
                                        $previousAmt = $sumamount;

                                        $receiveAmount = (float)$withdraw_amount - (float)$feeAmount;
                                        $subtractAmnt  = (float)$withdraw_amount + (float)$feeAmount;
                                        $updateBalance = (float)$getBalane - (float)$withdraw_amount;

                                        $isChkAmount = (float)$previousAmt + (float)$getCurncy->usdprice * $receiveAmount;

                                        $reqsumAmt = $totalReqAmount + $withdraw_amount;

                                   
                                        if($limitDay < $reqsumAmt){
                                            Session::flash('error', 'Withdraw limit per day exceed');
                                            return redirect('withdraw');
                                            die;
                                        }



                                        $binanceStatus = 0;


                                        $txnId = 'WIRC' . date('ymdhis');

                                        $data = array(
                                            'user_id'      => userId(),
                                            'amount'       => bcadd($withdraw_amount, 0, 8),
                                            'recive_amount' => $receiveAmount,
                                            'fee'          => $feeAmount,
                                            'currency'     => $getCurncy['symbol'],
                                            'currency_id'  => $currencyId,
                                            'address'      => $receive_address,
                                            'txid'     => $txnId,
                                            'status'       => 0,
                                            'recject_by' => '',
                                            'reason' => '',
                                            'tag'          => $addressTag,
                                            'created_at'   => date('Y-m-d, H:i:s'),
                                        );

                                        $insert = WithdrawReq::insert($data);

                                        if ($insert) {

                                            $updateBalance = update_balance(userId(), $currencyId, $updateBalance);
                                            $withdrawType = 'Pending';


                                            $mailContnt = [
                                                '###TYPE###' => $withdrawType,
                                                '###USER###' => $userName,
                                                '###AMOUNT###' => number_format($withdraw_amount, 8, '.', ''),
                                                '###CURRENCY###' => $getCurncy->symbol,
                                                '###PROCESSINGFEE###' => number_format($feeAmount, 8, '.', ''),
                                                '###RETURNAMOUNT###' => number_format($receiveAmount, 8, '.', ''),
                                            ];

                                            Users::where('id', userId())->update(['withdrawotp' => '']);
                                            $send = send_mail(9, $userEmail, 'Withdraw', $mailContnt);

                                            $user_id = Session::get('userId');

                                            user_activity($user_id, 'Withdraw request');

                                            Session::flash('success', 'Withdraw request has been completed successfully.');
                                            return redirect('withdraw');
                                        } else {
                                            Session::flash('error', 'Withdraw request has been failed.');
                                            return redirect('withdraw');
                                        }
                                    } else {
                                        Session::flash('error', 'Fee amount is greater than the withdraw amount.');
                                        return redirect('withdraw');
                                    }
                                } else {
                                    Session::flash('error', 'Kindly check withdraw minimum and maximum amount.');
                                    return redirect('withdraw');
                                }
                            } else {
                                Session::flash('error', 'Insufficient balance.');
                                return redirect('withdraw');
                            }
                        } else {
                            Session::flash('error', 'Invalid Amount.');
                            return redirect('withdraw');
                        }
                    } else {
                        Session::flash('error', 'Invalid currency details.');
                        return redirect('withdraw');
                    }
                } else {
                    Session::flash('error', 'Wrong security pin.');
                    return redirect('withdraw');
                }
            } else {
                Session::flash('error', 'Email withdraw OTP is wrong');
                return redirect('withdraw');
            }
        }
    }


    public function witdraw_details(Request $request)
    {

        $userId = userId();
        $currencyId = $request['currencyId'];

        $result = DB::table('wsGHkkBbywgOkjXg')->select('cuKZJurxYSsFaXNv.withdraw_status', 'cuKZJurxYSsFaXNv.symbol', 'wsGHkkBbywgOkjXg.*')->Join('cuKZJurxYSsFaXNv', 'cuKZJurxYSsFaXNv.id', '=', 'wsGHkkBbywgOkjXg.currency_id')->where('cuKZJurxYSsFaXNv.id', $currencyId)->first();

        if ($result) {

            $userBalance = get_balance($userId, $currencyId);

            $array = array(
                'address_tag' => '',
                'min_amount' => $result->min . ' ' . $result->symbol,
                'max_amount' => $result->max . ' ' . $result->symbol,
                'fee_amount' => $result->fee . ' ' . $result->symbol,
                'user_fee'   => $result->fee,
                'currency'   => $result->symbol,
                'req_limit'  => $result->per_day_limit,
                'balance'    => number_format($userBalance, 8, '.', '') . ' ' . $result->symbol
            );

            $res = ['status' => 1, 'data' => $array, 'page' => 'withdraw'];
            echo json_encode($res);
            die;
        } else {

            $res = ['status' => 0, 'msg' => 'Invalid details.', 'page' => 'withdraw'];

            echo json_encode($res);
            die;
        }
    }

    public function withdrawhistory()
    {
        $data['withdrawList'] = WithdrawReq::where('user_id', userId())->where('type', 1)->orderBy('id', 'DESC')->get();
        $data['currencyList'] = Currency::where('status', 1)->where('withdraw_status', 1)->get();
        $data['title'] = 'Withdraw';
        $data['js_file'] = 'userwithdraw';
        $data['pageTitle'] = 'Withdraw';
        $data['subTitle'] = 'Withdraw';
        return view('user.Setting.withdrawhistory', $data);
    }



    public function userwithdrawhistory(Request $request)
    {
        $userId = userId();
        // Get parameters from the DataTables AJAX request
        $draw = $request['draw'];
        $row = $request['start'];
        $rowperpage = $request['length'];
        $columnIndex = $request['order'][0]['column'];
        $columnName = 'id'; // Column name
        $columnSortOrder = 'desc'; // asc or desc
        $searchValue = $request['search']['value'];

        // Date search values
        $searchByFromdate = $request['searchByFromdate'];
        $searchByTodate = $request['searchByTodate'];

        // Initialize a search query array
        $searchQuery = array();

        // If there is a search value, add it to the search query
        if ($searchValue != '') {
            $searchQuery[] = "(wrhRWuSQVNefeaEO.currency like '%" . $searchValue . "%' or wrhRWuSQVNefeaEO.address like '%" . $searchValue . "%' or wrhRWuSQVNefeaEO.amount like '%" . $searchValue . "%' or wrhRWuSQVNefeaEO.txid like '%" . $searchValue . "%')";
        }

        // Date filter
        if ($searchByFromdate != '' && $searchByTodate != '') {
            $startDate = $searchByFromdate . ' 00:00:00';
            $endDate = $searchByTodate . ' 23:59:59';
            $searchQuery[] = "(wrhRWuSQVNefeaEO.created_at between '" . $startDate . "' and '" . $endDate . "')";
        }

        $WHERE = " WHERE user_id=" . $userId;

        if (count($searchQuery) > 0) {
            $WHERE = " WHERE " . implode(' and ', $searchQuery) . ' and user_id = ' . $userId;
        }

        // Total records count
        $totalRecords = WithdrawReq::where('user_id', $userId)->count();

        // Total records count with filter
        $sel = DB::select("select count(*) as allcount from wrhRWuSQVNefeaEO " . $WHERE);
        $totalRecordwithFilter = $sel[0]->allcount;

        // Fetch data based on filters and sorting
        $empQuery = DB::select("SELECT * FROM wrhRWuSQVNefeaEO $WHERE
                        ORDER BY $columnName DESC
                        LIMIT $row, $rowperpage");

        $data = array();
        $i = 1;
        foreach ($empQuery as $currency => $value) {
            if (property_exists($value, 'decimal')) {
                $decimal = $value->decimal;
            } else {
                $decimal = 2; // Set default decimal places
            }
            if ($value->status == 1) {
                $status = '<span class="label text-success">Approved</span>';
            } elseif ($value->status == 0) {
                $status = '<span class="label text-warning">Pending</span>';
            } elseif ($value->status == 2) {
                $status = '<span class="label text-danger">Rejected</span>';
            }

            $data[] = array(
                'id' => $i,
                "currency" => $value->currency,
                "address" => '<i class="fa fa-copy curPointer copyAdd" title=' . $value->address . '" data-id="' . $value->address . '"> ' . substr($value->address, 0, 8) . '</i>' . '...',
                "txid" => '<i class="fa fa-copy curPointer copyAdd" title=' . $value->txid . '" data-id="' . $value->txid . '"> ' . substr($value->txid, 0, 8) . '</i>' . '...',
                "fee" => number_format($value->fee, $decimal),
                "reciving_amt" => number_format($value->recive_amount, $decimal),
                "amount" => number_format($value->amount, $decimal),
                "status" => $status,
                "date" => date('d, M y h:i A', strtotime($value->created_at)),
            );
            $i++;
        }

        // Prepare the response in JSON format
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        // Send the response as JSON
        return response()->json($response);
    }



}
