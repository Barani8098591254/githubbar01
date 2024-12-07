<?php

namespace App\Http\Controllers\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\WithdrawReq;
use App\Models\Users;
use App\Models\Inverstment;
use App\Models\Transaction;
use App\Models\Plan;
use App\Models\Currency;
use Session;


class DashboardController extends Controller
{


    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

    public function dashboard(){


        $data['totaldeposit'] = Deposit::where('user_id', userId())->count();
        $data['totalWithdrawReq'] = WithdrawReq::where('user_id', userId())->count();
        $data['WithdraPending'] = WithdrawReq::where('status', 1)->where('user_id',userId())->count();
        $userData   = Users::select('referralId')->where('id',userId())->first();
        $data['totalUsers'] = Users::where('referrerId',$userData->referralId)->count();

        $userData   = Deposit::count();

        $data['total_investment'] = Inverstment::where('user_id',userId())->where('status',1)->sum('equivalentAmt');
        $data['today_investment'] = Inverstment::whereDate('created_at',date('Y-m-d'))->where('user_id',userId())->where('status',1)->sum('equivalentAmt');
        $data['lastInverstment'] = Inverstment::select('plan_amount','created_at','equivalentAmt')->where('user_id',userId())->orderBy('id','DESC')->first();


        // roi
        $data['roi_scheduled'] = Transaction::where('type','daily_interest')->where('wallet_status',1)->where('user_id',userId())->sum('equivalent_amt');
        $data['roi_unscheduled'] = Transaction::where('type','daily_interest')->where('wallet_status',0)->where('user_id',userId())->sum('equivalent_amt');
        $data['today_roi'] = Plan::select('roi_commission')->where('status',1)->first()->roi_commission;
        $data['today_roi_total'] = Transaction::where('type','daily_interest')->whereDate('created_at',date('Y-m-d'))->where('user_id',userId())->sum('equivalent_amt');

        // level commison
        $data['level_scheduled'] = Transaction::where('type','level_commission')->where('wallet_status',1)->where('user_id',userId())->sum('equivalent_amt');

        $data['level_unscheduled'] = Transaction::where('type','level_commission')->where('wallet_status',0)->where('user_id',userId())->sum('equivalent_amt');

        // $data['level_scheduled'] = Transaction::where('type','level_commission')->whereDate('created_at',date('Y-m-d'))->where('user_id',userId())->sum('amount');

        // direct commison
        $data['direct_scheduled'] = Transaction::where('type','direct_commission')->where('wallet_status',1)->where('user_id',userId())->sum('equivalent_amt');
        $data['direct_unscheduled'] = Transaction::where('type','direct_commission')->where('wallet_status',0)->where('user_id',userId())->sum('equivalent_amt');
        $data['today_direct_total'] = Transaction::where('type','direct_commission')->whereDate('created_at',date('Y-m-d'))->where('user_id',userId())->sum('equivalent_amt');



        // $data['pair_scheduled'] = Transaction::where('type','pair_commission')->where('wallet_status',1)->where('user_id',userId())->sum('equivalent_amt');

        // $data['pair_unscheduled'] = Transaction::where('type','pair_commission')->where('wallet_status',0)->where('user_id',userId())->sum('equivalent_amt');



        $data['walletStatus'] = 1;
        $data['title'] = 'Dashboard';
        $data['js_file'] = '';
        $data['pageTitle'] = 'Dashboard';
        $data['subTitle'] = 'Dashboard';
        return view('user/Dashboard/dashboard', $data);
    }



function moveToWallet($type) {

        $queryString = $type;



        $userId = userId();



        if($queryString) {

            $queryString = encrypt_decrypt('decrypt',$queryString);

            $getCurrency = Currency::select('symbol','id')->get();

                if($getCurrency){

                    foreach ($getCurrency as $key => $value) {

                        $currencyId     = $value->id;

                        $currencySymbol = $value->symbol;





                          $amount = Transaction::where('type', $queryString)
                                    ->where('wallet_status', 0)
                                    // ->where('currency',$currencySymbol)
                                    ->where('user_id', userId())
                                    ->sum('equivalent_amt');




                          if($amount > 0){

                                $currency =  $currencySymbol;

                                $currencyData   = get_currencySymbol($currency);

                                 $currencyId     = $currencyData;

                                 $beforeBalance  = get_balance($userId, $currencyId);

                                 $updatedAmount  = $beforeBalance + $amount;

                                 $updateBalance  = update_balance($userId, $currencyId, $updatedAmount);



                                 if($updateBalance) {

                                    Transaction::where('type',$queryString)->where('wallet_status',0)->where('user_id',userId())->update(['wallet_status' => 1]);

                                }

                          }

                    }

                    Session::flash('success', 'Balance moved to wallet.');
                    return redirect('dashboard');
                }else{
                    echo 'No more currency';
                }

                die;

            // $Inverstment = Inverstment::select('currency')->where('user_id',$userId)->get()->toArray();

            // foreach ($Inverstment as $key => $value) {

            //     echo $currency = $value['currency'];

            // }

            foreach ($Inverstment as $key => $value) {


                $amount = Transaction::where('type', $queryString)
                    ->where('wallet_status', 0)
                    ->where('currency',$value['currency'])
                    ->where('user_id', userId())
                    ->sum('amount');

                echo "Amount for " . $value['currency'] . ": " . $amount . "<br>";


                if($amount > 0){

                    $currency =  $value['currency'];


                    $currencyData   = get_currencySymbol($currency);

                     $currencyId     = $currencyData;

                     $beforeBalance  = get_balance($userId, $currencyId);

                     $updatedAmount  = $beforeBalance + $amount;

                     $updateBalance  = update_balance($userId, $currencyId, $updatedAmount);



                     if($updateBalance) {
                        Transaction::where('type',$queryString)->where('wallet_status',0)->where('user_id',userId())->update(['wallet_status' => 1]);

                        Session::flash('success', 'Balance moved to wallet.');
                        return redirect('dashboard');
                    }

                    else {
                        Session::flash('error', 'Balance not updated.');
                        return redirect('dashboard');

                    }
                }

                else{
                    Session::flash('error', 'Insufficient fund.');
                    return redirect('dashboard');
                }
            }

            }

        else {
            Session::flash('error', 'Your request has been failed.');
            return redirect('dashboard');

        }

    }


//     function moveToWallet($type) {

//         $queryString = $type;
//         $userId = userId();

//         if($queryString) {

//             $queryString = encrypt_decrypt('decrypt',$queryString);


//             $investmentCurrencies = Inverstment::where('user_id', $userId)
//             ->select('currency','id')
//             ->get()
//             ->pluck('currency','id')
//             ->toArray();



//             $transactions = Transaction::where('type', $queryString)
//             ->where('wallet_status', 0)
//             ->where('user_id', $userId)
//             ->whereIn('currency', $investmentCurrencies)
//             ->get(['amount', 'currency']);





//         foreach ($transactions as $transaction) {
//             $currency = $transaction->currency;

//         }


// echo "<pre>";
// print_r( $currency);
// die;


// $amount = [];




// foreach ($transactions as $transaction) {
//     $amount[$transaction->currency] = $transaction->amount;
// }





// // Calculate the total amount
// $totalAmount = array_sum($amount);





// if ($totalAmount > 0) {



//     $currencyData = get_currencySymbol($currency);




//     $currencyId = $currencyData;





//     $beforeBalance = get_balance($userId, $currencyId);



//     $updatedAmount = $beforeBalance + $totalAmount;

//                     $updateBalance  = update_balance($userId, $currencyId, $updatedAmount);

//                     $user_id = Session::get('userId');
//                     user_activity($user_id, 'Balance moved to wallet');

//                     if($updateBalance) {
//                         Transaction::where('type',$queryString)->where('wallet_status',0)->where('user_id',userId())->update(['wallet_status' => 1]);
//                         Session::flash('success', 'Balance moved to wallet.');
//                         return redirect('dashboard');
//                     }else {
//                         Session::flash('error', 'Balance not updated.');
//                         return redirect('dashboard');

//                     }
//                 }else{
//                     Session::flash('error', 'Insufficient fund.');
//                     return redirect('dashboard');
//                 }
//         } else {
//             Session::flash('error', 'Your request has been failed.');
//             return redirect('dashboard');

//         }

//     }



}
