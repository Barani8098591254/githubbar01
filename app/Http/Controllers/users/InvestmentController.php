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
use Validator;
use DB;
use Redirect;
use App\Models\Inverstment;
use App\Models\Transaction;
use App\Models\Plan;
use PragmaRX\Google2FAQRCode\Google2FA;


class InvestmentController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }


    public function Investment(Request $request)
    {

        $data['js_file'] = '';
        $data['title'] = 'Investment';
        $data['pageTitle'] = 'Investment';
        $data['subTitle'] = 'Investment';
        $data['currency'] = Currency::select('id', 'name', 'symbol', 'type', 'status')->where('status', 1)->where('investment_status', 1)->get();

        $data['availableCurrencies'] = self::getPaymentCurrencies();

        // $data['activePlans'] = self::getActivePlans(1);

        $data['planList'] = Plan::where('status', 1)->get();


        return view('user.Investment.makeInvestment', $data);
    }




    function confirmInvestment($planId)
    {



        $userId = userId();



        $data['checkPlan'] = Plan::where('id', encrypt_decrypt('decrypt', $planId))->first();

        $data['currency'] = Currency::select('id', 'name', 'symbol', 'investment_status')->where('status', 1)->where('investment_status', 1)->get();

        // $data['currencyData'] = Currency::where("status", 1)->where("id", $currency_id)->value("usdprice");

        $data['currId'] = $data['checkPlan']->currency_id;




        $data['getBalance'] = get_balance($userId,$data['currId']);
        // $currencyId = $data['checkPlan']->currency_id;



        $amount = $data['checkPlan']->price;




        // $userbalance = get_balance($userId, $currencyId);




        if ($amount) {
            // $data['balance'] = $userbalance;
            $data['js_file'] = '';
            $data['title'] = 'Confirm your trade';
            $data['pageTitle'] = 'Confirm your trade';
            $data['subTitle'] = 'Confirm your trade';
            $data['planId'] = $planId;



            return view('user.Investment.confirmInvestment', $data);
        } else {
            Session::flash('error', 'You have insufficient balance for investment plan.');
            return redirect('Investment');
        }
    }


    public function getplanprice(Request $request, $planIds)
    {



        $data['checkPlan'] = Plan::select('id')->where('id', encrypt_decrypt('decrypt', $planIds))->first();


        $currency_id = $request->input("currency_id");


        $userId = userId();

        $data['currencyData'] = Currency::where("status", 1)->where("id", $currency_id)->first();


        $data['planData'] = Plan::where("status", 1)->where("id", encrypt_decrypt('decrypt', $planIds))->value("price");

        $product = $data['currencyData']->usdprice * $data['planData'];

        $data['product'] = $product;



        $res = [
            "status" => 1,
            "msg" => "Success",
            "planprice" => bcadd($product, 0, $data['currencyData']->decimal),
            "currency_id" => $currency_id
        ];



        echo json_encode($res);
        exit();
    }











    public function getPaymentCurrencies()
    {
        $result = Currency::select('id', 'name', 'symbol', 'type')->where('investment_status', 1)->where('status', 1)->get()->toArray();
        return $result;
    }

    public function getActivePlans($currencyId)
    {
        $result = Plan::where('status', 1)->where('currency_id', $currencyId)->get()->toArray();
        return $result;
    }



    public function makeInvestment(Request $request)

    {
        $userId = session('user_id');

        if ($request->input('submit')) {
            echo 'no11';
            die;

            $validator = Validator::make($request->all(), [
                'planId' => 'required',
                'currency' => 'required',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                Session::flash('errors', $errors->all());
                echo 'no';
                die;
                // return redirect('confirmInvestment/'); redirect back
            } else {
                echo 'test';
                die;
            }
        }
    }



    public function submitInvestment(Request $request)
    {

        if ($request->input('submit')) {

            $planId = $request->input('planId');

            $currency_Id = $request->input('currency_id');



            $totalplanprice = $request->input('price');

            $userId = userId();

            $userData = Users::where('id', $userId)->first();

            if ($userData) {

                $userName = $userData->username;
                $isActive = $userData->is_active;
                $kycStatus = $userData->kyc_status;
                $userEmail = encrypt_decrypt('decrypt', $userData->email);
                $referrerId = $userData->directId;


                $planExist = self::checkPlan($planId);



                if ($isActive == 1) {

                    if (setting()->kyc == 1) {

                        if ($kycStatus != 3) {
                            Session::flash('error', 'Your KYC is not yet verified.');
                            return redirect('Investment');
                        }
                    }


                    if ($planExist) {


                        $planData = $planExist;


                        $currencyData = get_currency($currency_Id);



                        if ($currencyData) {
                            $curncy = $currencyData->symbol;


                            $userBalance = get_balance($userId, $currency_Id);




                            $planAmount = $totalplanprice;



                            $planInfo = [
                                'plan_id' => $planData->id,
                                'name' => $planData->name,
                                'price' => $planAmount,
                                'direct_commission' => $planData->direct_commission,
                                'roi_commission' => $planData->roi_commission,
                                'cancel_fee' => $planData->cancel_fee,
                                'days' => $planData->days,
                            ];




                            if ($planData->days == 0) {
                                $res = ['status' => 0, 'msg' => 'Your Plan days are not activated.'];
                                return response()->json($res);
                            } else {



                                if ($userBalance >= $planAmount) {
                                    // if ($userBalance || $planAmount) {

                                    $matured_date = now()->addDays($planData->days);


                                    $investmentData = [
                                        'user_id' => $userId,
                                        'plan_id' => $planId,
                                        'plan_amount' => $totalplanprice,
                                        'currency' => $curncy,
                                        'status' => 0,
                                        'equivalentAmt' => ($planAmount) / ($currencyData->usdprice),
                                        // 'matured_date' => date('Y-m-d', strtotime('+1000 days')),
                                        // 'matured_date' => $matured_date->format('Y-m-d'), // Format the date
                                        'matured_date' => $matured_date->format('Y-m-d H:i:s'),
                                        'cancel_date' => '',
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'plan_info' => serialize($planInfo)
                                    ];


                                    // echo"<pre>";print_r($investmentData);die;




                                    $investment = self::createInvestment($investmentData);




                                    if ($investment) {



                                        $balanceAmount = $userBalance - $totalplanprice;

                                  

                                        $updateBalance = update_balance($userId, $currency_Id, $balanceAmount);

                                        if ($updateBalance) {
                                            self::activeInvestment($investment);

                                            if ($referrerId) {
                                                $referrerData = Users::where('referralId', $referrerId)->first();

                                                if ($referrerData) {
                                                    $referUserID = $referrerData->id;
                                                    $directCommission = $planData->direct_commission;
                                                    $planExist = self::checkActivePlan($referUserID);

                                                    if ($planExist >= 0) {
                                                        $commission = $totalplanprice * $directCommission / 100;
                                                        $holdStatus = ($planExist > 0) ? 1 : 2;
                                                        $description = 'Direct Commission Earned '.$planData->name;
                                                        $txnId = 'DIRC' . date('ymdhis');

                                                        $data = [
                                                            'user_id' => $referUserID,
                                                            'plan_id' => $planId,
                                                            'amount' => $commission,
                                                            'currency' => $curncy,
                                                            'description' => $description,
                                                            'txid' => $txnId,
                                                            // 'equivalent_amt' => $commission / $totalplanprice,
                                                            'equivalent_amt' => $commission /  getDecimal($curncy)->usdprice,

                                                            'from_id' => $userId,
                                                            'type' => 'direct_commission',
                                                            'wallet_status' => 0,
                                                            'hold_status' => $holdStatus,
                                                            'created_at' => date('Y-m-d H:i:s')
                                                        ];

                                                        $commission = self::directCommission($data);
                                                    }
                                                }
                                            }
                                            $mailContent = [
                                                '###USER###' => $userName,
                                                '###PLAN###' => $planData['name'],
                                                '###AMOUNT###' => $planData['price'],
                                                '###CURRENCY###' => $curncy
                                            ];

                                            // Assuming you have a function to send emails
                                            $send = send_mail(11, $userEmail, 'MLM', $mailContent);

                                            $user_id = Session::get('userId');
                                            user_activity($user_id, 'Your plan has been activated');

                                            if ($send) {
                                                // Session::flash('success', 'Your plan has been activated');
                                                // return redirect('Investment');


                                                $res = ['status' => 1, 'msg' => 'Your plan has been activated'];
                                                return response()->json($res);
                                            } else {
                                                $res = ['status' => 0, 'msg' => 'YEmail send failed'];
                                                return response()->json($res);
                                            }
                                        } else {

                                            $res = ['status' => 0, 'msg' => 'Balance updation failed. Your plan is not activated.'];
                                            return response()->json($res);
                                        }
                                    } else {


                                        $res = ['status' => 0, 'msg' => 'Your associate trade request has failed.'];
                                        return response()->json($res);
                                    }
                                } else {


                                    $res = ['status' => 0, 'msg' => 'You have insufficient balance for associate trade'];
                                    return response()->json($res);
                                }
                            }
                        } else {


                            $res = ['status' => 0, 'msg' => 'Invalid Currency Details.'];
                            return response()->json($res);
                        }
                    } else {


                        $res = ['status' => 0, 'msg' => 'Invalid Plan Details..'];
                        return response()->json($res);
                    }
                } else {


                    $res = ['status' => 0, 'msg' => 'Your account is not yet activated.'];
                    return response()->json($res);
                }
            } else {


                $res = ['status' => 0, 'msg' => 'Invalid user.'];
                return response()->json($res);
            }
        } else {

            $res = ['status' => 0, 'msg' => 'Invalid associate trade details.'];
            return response()->json($res);
        }
    }

    public function checkPlan($id)
    {
        $result = Plan::where('id', $id)->where('status', 1)->first();

        return $result;
    }

    public function createInvestment($data)
    {
        $inserted = Inverstment::insert($data);

        // if ($inserted) {
        // Transaction::where('user_id', $data['user_id'])->where('hold_status', 2)->update(['hold_status' => 1,'unhold_date' => date('Y-m-d H:i:s')]);
        // }

        return DB::getPdo()->lastInsertId();
    }


    public function activeInvestment($planId)
    {
        $updated = DB::table('inEYqLwqRvCYkkYw')->where('id', $planId)->update(['status' => 1]);

        return true;
    }

    public function checkActivePlan($referUserID)
    {
        $count = Inverstment::where('user_id', $referUserID)->where('status', 1)->count();
        return $count;
    }

    public function directCommission($data)
    {
        $inserted = Transaction::insert($data);

        return true;
    }



    public function investmenthistory()
    {

        $data['js_file'] = '';
        $data['title'] = 'Investment History';
        $data['pageTitle'] = 'Investment History';
        $data['subTitle'] = 'Investment History';

        return view('user.Investment.investment-history', $data);
    }



    public function getinvestmentdata(Request $request)
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

            $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%" . $searchValue . "%' or inEYqLwqRvCYkkYw.currency like '%" . $searchValue . "%' or inEYqLwqRvCYkkYw.plan_amount like '%" . $searchValue . "%' or inEYqLwqRvCYkkYw.created_at like '%" . $searchValue . "%' or inEYqLwqRvCYkkYw.plan_id like '%" . $searchValue . "%' or inEYqLwqRvCYkkYw.status like '%" . $searchValue . "%')";
        }


        // Date filter
        if ($searchByFromdate != '' && $searchByTodate != '') {
            $startDate = $searchByFromdate . ' 00:00:00';
            $endDate = $searchByTodate . ' 23:59:59';
            $searchQuery[] = "(inEYqLwqRvCYkkYw.created_at between '" . $startDate . "' and '" . $endDate . "')";
        }


        $WHERE = " WHERE user_id=" . $userId;

        if (count($searchQuery) > 0) {
            $WHERE = " WHERE " . implode(' and ', $searchQuery) . ' and user_id = ' . $userId;
        }


        // ## Total number of records without filtering
        $totalRecords = Inverstment::where('user_id', $userId)->count();

        $sel = DB::select("select count(*) as allcount FROM inEYqLwqRvCYkkYw INNER JOIN UeAVBvpelsUJpczNv ON inEYqLwqRvCYkkYw.user_id = UeAVBvpelsUJpczNv.id " . $WHERE);

        $totalRecordwithFilter = $sel[0]->allcount;


        $empQuery = DB::select("SELECT inEYqLwqRvCYkkYw.*, UeAVBvpelsUJpczNv.username FROM inEYqLwqRvCYkkYw INNER JOIN UeAVBvpelsUJpczNv ON inEYqLwqRvCYkkYw.user_id = UeAVBvpelsUJpczNv.id " . $WHERE . " AND UeAVBvpelsUJpczNv.id = :userId ORDER BY " . $columnName . " DESC LIMIT " . $row . "," . $rowperpage, ['userId' => $userId]);


        $data = array();
        $i = 1;
        foreach ($empQuery as $key => $value) {

            $verifyLabel = ($value->status == '1')
                ? '<span class="label text-success">Active </span>'
                : '<span class="label text-danger">Cancelled </span>';

            if ($value->status == 1) {
                $action = '<a class="btn btn-danger btn-sm" href="' . URL::to('cancelInvestment/' . encrypt_decrypt('encrypt', $value->id)) . '"> Cancel </a>';
            } else {
                $action = '--';
            }


            $data[] = array(
                'id' => $i,
                // "username" => $value->username,
                'plan_amount' => number_format($value->plan_amount, getDecimal($value->currency)->decimal),
                "plan_id" => getplanname($value->plan_id),
                "currency" => $value->currency,
                "status" => $verifyLabel,
                // 'equivalentAmt' => number_format($value->equivalentAmt, getDecimal($value->currency)->decimal),

                "equivalentAmt" => number_format($value->equivalentAmt, 2),


                "date" => date('d, M y h:i A', strtotime($value->matured_date)),
                "matured_date" => date('d, M y h:i A', strtotime($value->created_at)),
                "action" => $action



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




    public function cancelInvestment($id = "")
    {
        $queryString = encrypt_decrypt('decrypt', $id);
        $userId = userId();

        if ($queryString) {
            $planData = Inverstment::join('PnACeUagDYOKDcYL', 'PnACeUagDYOKDcYL.id', '=', 'inEYqLwqRvCYkkYw.plan_id')->select('inEYqLwqRvCYkkYw.*', 'PnACeUagDYOKDcYL.name', 'PnACeUagDYOKDcYL.roi_commission', 'PnACeUagDYOKDcYL.cancel_fee')->where('inEYqLwqRvCYkkYw.id', $queryString);
            // ->whereDate('matured_date' ,'<=',date('Y-m-d'))

            if ($planData->count() > 0) {
                $data['checkPlan'] = $planData->first();
                $data['js_file'] = '';
                $data['title'] = 'Cancel Investment';
                $data['pageTitle'] = 'Cancel Investment';
                $data['subTitle'] = 'Cancel Investment';

                return view('user.Investment.cancelInvestment', $data);
            } else {
                Session::flash('error', 'Invalid investment trade.');
                return redirect('Investment');
            }
        } else {
            $this->session->set_flashdata('errors', 'Invalid investment details.');
            redirect(base_url('myInvestments'), 'refresh');
        }
    }

    public function submitCancelInvestment(Request $request)
    {

        $queryString = $request['planId'];
        $userId = userId();


        if ($queryString) {

            $planData = Inverstment::where('id', $queryString);
            if ($planData->count() > 0) {
                $planData = $planData->first();
                $userEmail = getuserEmail($userId);
                $userName = getuserName($userId);

                $update = Inverstment::where('id', $queryString)->update(['cancel_date' => date('Y-m-d H:i:s'), 'status' => 2]);

                if ($update) {

                    $description = 'Priciple amount returned';
                    $txnId = 'PAR' . date('ymdhis');

                    $processingFee = $planData->plan_amount * 5 / 100;


                    $finalAmount = $planData->plan_amount - $processingFee;

                    $data = array(
                        'user_id' => userId(),
                        'amount' => $finalAmount,
                        'plan_id' => $planData->id,
                        'currency' => $planData->currency,
                        'description' => $description,
                        'txid' => $txnId,
                        'from_id' => 0,
                        'type' => 'principle_return',
                        'wallet_status' => 1,
                        'hold_status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                    );


                    $insert = Transaction::insert($data);

                    if ($insert) {
                        $currencyData = get_currencySymbol($planData->currency);
                        $currencyId = $currencyData;
                        $beforeBalance = get_balance($userId, $currencyId);
                        $updatedAmount = $beforeBalance + $finalAmount;
                        $updateBalance = update_balance($userId, $currencyId, $updatedAmount);
                    }

                    $planInfo = unserialize($planData->plan_info);

                    $mailContnt = [
                        '###USER###' => $userName,
                        '###PLAN###' => $planInfo['name'],
                        '###AMOUNT###' => $planData['plan_amount'],
                        '###RETURNAMOUNT###' => $finalAmount,
                        '###CURRENCY###' => $planData['currency'],
                        '###PROCESSINGFEE###' => '5%',
                    ];

                    $send = send_mail(16, $userEmail, 'Investment Cancelled', $mailContnt);

                    // Session::flash('success', 'Investment Cancelled Successfully.');
                    // return redirect('Investment');

                    $res = ['status' => 1, 'msg' => 'Investment Cancelled Successfully'];
                    return response()->json($res);
                } else {
                    // Session::flash('error', 'Invalid associate trade details.');
                    // return redirect('Investment');

                    $res = ['status' => 0, 'msg' => 'Invalid associate trade details.'];
                    return response()->json($res);
                }
            } else {
                // Session::flash('error', 'Invalid associate trade details.');
                // return redirect('Investment');

                $res = ['status' => 0, 'msg' => 'Invalid associate trade details.'];
                return response()->json($res);
            }
        } else {
            // Session::flash('error', 'Invalid associate trade details.');
            // return redirect('Investment');


            $res = ['status' => 0, 'msg' => 'Invalid associate trade details.'];
            return response()->json($res);
        }
    }


    function getPlanDetails(Request $request)
    {

        $currencyId = $request['currencyId'];
        $activePlans = self::getActivePlans($currencyId);
        echo '<div class="row">';
        $colors = ['plan-color-1', 'plan-color-2', 'plan-color-3', 'plan-color-5', 'plan-color-6', 'plan-color-7', 'plan-color-8'];
        // echo count($activePlans);
        // die;


        if (count($activePlans) > 0) {
            foreach ($activePlans as $index => $plan) {
                $colorClass = $colors[$index % count($colors)];
                $url = URL::to('/') . '/confirmInvestment/' . encrypt_decrypt('encrypt', $plan['id']);
                echo '<div class="col-md-6 col-lg-3">
 <div class="plan-item ' . $colorClass . '">
 <h4 class="plan-title">' . $plan['name'] . '</h4>
 <h6 class="plan-price">' . number_format($plan['price'], 2) . ' ' . get_currency($plan['currency_id'])->symbol . '</h6>

 <div class="plan-item-list">
 <div class="plan-item-list">
 <ul>
 <li>Today ROI ' . $plan['roi_commission'] . ' %</li>
 <li>Monthly ROI 5% to upto 15%</li>
 </ul>
 </div>
 <a href="' . $url . '" class="plan-btn">Invest Now</a>
 </div>
 </div>
 </div>

 ';
            }
        } else {
            echo '<h5 class="mt-5 text-center">No More Active Plans.</h5>';
        }

        echo '</div></div>';
    }
}
