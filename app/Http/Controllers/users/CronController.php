<?php

namespace App\Http\Controllers\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inverstment;
use App\Models\Transaction;
use App\Models\Users;
use App\Models\Board;
use App\Models\LevelCommission;
use DB;
use Illuminate\Support\Facades\Http;


class CronController extends Controller{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

    public function dailyRoi(){

     	$totalRows = 0;

        if($totalRows == 0) {
			$currentDate = date('Y-m-d');
            $result = self::roi_earnings($currentDate);

            echo $result; exit;

        } else {

            echo 'already today roi updated'; exit;
        }

    }


    function roi_earnings($currentDate){
    	$totalRows = 0;

        if($totalRows == 0) {

            $investmentData = self::getInvestmentData();

            if(count($investmentData) > 0) {

            foreach($investmentData as $key => $investment) {

                $todayRoiData   = self::getTodayRoi($investment['plan_id']);

    			if($todayRoiData != ''){

                    $userId     = $investment['user_id'];
                    $amount     = $investment['plan_amount'];
                    $planID     = $investment['plan_id'];
                    $currency   = $investment['currency'];
                    $roi        = $todayRoiData->roi_commission;
					$investment_id = $investment['id'];
                    $roiExist   = self::roiExist($userId,$currentDate,$investment_id);
					$commission = $amount * $roi / 100;

                    if($roiExist == 0) {

                        $commission = $amount * $roi / 100;


                        $description = 'ROI Earned';
                        $txnId = 'ROI'.date('ymdhis');

                        $data = array(
                            'user_id'        => $userId,
                            'amount'        => $commission,
                            'plan_id'       => $planID,
                            'currency'      => $currency,
                            'description'   => $description,
                            'txid'          => $txnId,
                            'equivalent_amt' => $commission / getDecimal($currency)->usdprice,
                            'from_id'       => 0,
                            'type'          => 'daily_interest',
        					'wallet_status' => 0,
                            'hold_status'   => 1,
                            'created_at'    => date($currentDate.' H:i:s'),
							'investment_id'=>  $investment_id,
                        );

                       Transaction::insert($data);

                    }

                    self::levelCommission($userId, $planID, 0, $commission, $userId,$investment_id,$currentDate,$currency);
                	}
                }

                // $this->db->insert('roi_entry', array('execute_date' => date('Y-m-d H:i:s')));

                return 'Update Successfully';

            } else {

                return 'No more active plans';
            }

        } else {

            return 'Already Earned';
        }

    }


    function levelCommission($userId,$planID,$level,$planAmount,$fromUserId,$investment_id,$currentDate,$currency){

 

    	$getUserData = self::get_user_details('id', $userId, array('referrerId'));


        if($getUserData) {

            $referrerId = $getUserData->referrerId;

            $getRefUserData = self::get_user_details('referralId', $referrerId, array('id'));

        

            
            if($getRefUserData) {

                $level++;


                $commissionUserID    = $getRefUserData->id;


                $levelCommissionData = self::get_level_commission($planID, $level);
                $levelCommission     = $levelCommissionData->commission;
                echo $level;


                $userCommissionAmnt  = $planAmount * $levelCommission / 100;

                if($userCommissionAmnt > 0) {

                    /*echo 'Level '.$level.' === '.$userId.' ==== '.$commissionUserID.' === '.$userCommissionAmnt.' === '. $planAmount. ' === '. $levelCommission; echo '<br>';*/

                    $transCount  = Transaction::count();
                    $planExist   = self::checkActivePlan($commissionUserID);
                    $holdStatus  = ($planExist > 0) ? 1 : 1;
                    $description = 'Commission for unit '.$level;
                    $txnId       = 'UNT'.date('ymdhis').$transCount;

					$checkLevelCommision = Transaction::where('user_id',$commissionUserID)->where('investment_id',$investment_id)->whereDate('created_at',$currentDate)->where('description',$description)->where('type','level_commission')->count();

						if($checkLevelCommision == 0){
							$data = array(
								'user_id'        => $commissionUserID,
								'amount'        => $userCommissionAmnt,
								'plan_id'       => $planID,
								'currency'      => $currency,
								'description'   => $description,
								'txid'          => $txnId,
								'from_id'       => $fromUserId,
                                'equivalent_amt' => $userCommissionAmnt / getDecimal($currency)->usdprice,
								'type'          => 'level_commission',
								'wallet_status' => 0,
								'hold_status'   => $holdStatus,
								'created_at'    => date($currentDate.' H:i:s'),
								'investment_id'=>  $investment_id,
							);



                     		Transaction::insert($data);

						}

                }

                $getCount = LevelCommission::where('plan_id',$planID)->count();
                if($level < $getCount) {

                    self::levelCommission($commissionUserID,$planID,$level,$planAmount,$fromUserId,$investment_id,$currentDate,$currency);
                }
            }
        }

    }

    function updateTRX(){

        // $this->db->insert('cron',['text' => 'TRX--->deposit','date_time' => date('Y-m-h H:i:s')]);

        $currency_symbol = 'TRX';
        $admin_address ="";

        $get_users = DB::table('AdAeoXPAFVfEWIEg')->where('address',$currency_symbol)->get();

        foreach ($get_users as $key => $user_details) {

            $user_address =  $user_details->address;


            $get_trans = file_get_contents('https://api.trongrid.io/v1/accounts/'.trim($user_address).'/transactions');

            $transaction = json_decode($get_trans,true);

            $trns = $transaction['data'];

                foreach ($trns as $key => $value) {

                    $type = $value['raw_data']['contract'][0]['type'];

                    if($type == 'TransferContract'){

                    $owner_add = $value['raw_data']['contract'][0]['parameter']['value']['to_address'];

                    if(strtolower($owner_add) == strtolower($user_details->hex)){

                    $to_address = $user_address;
                    $txid       =  $value['txID'];
                    $blockNumber = $value['blockNumber'];
                    $block_Number = $blockNumber;
                    $crypto_balance     = $user_coin_balance = str_replace(',', '', number_format($value['raw_data']['contract'][0]['parameter']['value']['amount']/1000000,8));


                    if(($crypto_balance > 0) && $to_address && $txid){

                        $userId = self::getUserByAddr($currency_symbol, trim($to_address));

                            if($userId != ''){

                                $txnExists = self::checktxnid($txid, $userId);

                                if ($txnExists == 'true') {



                                    $depositData = array(
                                        'amount'     => $crypto_balance,
                                        'address'    => $to_address,
                                        'currency'   => $currency_symbol,
                                        // 'payment_method' => $currency_symbol . " Payment",
                                        'txid'       => $txid,
                                        'status' => 'Completed',
                                        'user_id' => $userId,
                                        'type' => 'crypto',
                                        'block_confirm' => '',
                                        'created_at' => date('Y-m-d H:i:s')
                                    );



                                    $$last_id = DB::insert('deXxaZzBolrXMQLG', $depositData);


                                    if($last_id){

                                           // $get_curr = get_currency_id($currency_symbol);
                                           // $currencyId = $get_curr['id'];
                                           // $balance = get_balance($userId,$currencyId);
                                           // $updateBal = $balance + $crypto_balance;
                                           // update_balance($userId,$currencyId,number_format($updateBal,8));


                                    }else{

                                        echo 'no update';
                                    }


                                }else{
                                    echo 'Already exist';
                                }

                            }else{
                                echo 'No user';
                            }
                     }

                     }else{

                        echo 'Admin Address inside';
                     }

                    }
                }

        }



    }


   function getUserByAddr($currency,$address){

        $result = DB::table('AdAeoXPAFVfEWIEg')->where('currency',$currency)->where('address',$address)->first();

        if($result){
            return $result->user_id;
        }else{
            return '';
        }
    }

        //To check transaction id already exists
    function checktxnid($btctxid, $userid) {
        $tx_id = DB::table('deXxaZzBolrXMQLG')->where('user_id',$userid)->where('txid',$btctxid)->count();
        return ($tx_id == 0) ? 'true' : 'false';
    }

  





    // get investment
    function getInvestmentData(){

	    $investmentsData = Inverstment::where('status',1)->get()->toArray();

        if(count($investmentsData) > 0) {
            return $investmentsData;
        } else {
            return array();
        }
    }

    // getTodayRoi
    function getTodayRoi($id =""){

		$planData = DB::table('PnACeUagDYOKDcYL')->select('roi_commission')->where('status',1)->where('id',$id)->orderBy('id', 'desc');

        if($planData->count() > 0) {
            return $planData->first();
        } else {
            return '';
        }

    }

    function roiExist($userId,$currentDates,$investment_id){

    	$totalCount = Transaction::where('user_id',$userId)->where('investment_id',$investment_id)->where('type','daily_interest')->whereDate('created_at',$currentDates)->count();
    	return $totalCount;
    }

    function get_user_details($field_name,$value,$array=null){

    	$select = (is_array($array) && count($array) > 0) ? implode(',', $array) : '*';

    	$count = Users::select($select)->where($field_name,$value);

        if($count->count() > 0){
            return @$count->first();
        }else{
            return 0;
        }

    }

    function get_level_commission($planId, $level){
    	$result = DB::table('LftDOlfkBbywgObD')->where('plan_id',$planId)->where('level',$level)->first();
        return $result;
    }

    function checkActivePlan($userId){
    	$count = Inverstment::where('user_id',$userId)->where('status',1)->count();
        return $count;
    }



    function binaryTree(){
        echo '<pre>';
        $user = Users::select('id','username','referralId','referrerId')->get()->toArray();
            $getReffer = [];
            foreach ($user as $key => $value) {

                $referralId = $value['referralId'];
                $referrerId = $value['referrerId'];


                $getReffer[$referrerId][$key] = ($referralId == $referrerId) ? $referralId : $referralId;
            }

            print_r($getReffer);
            die;

    }


    function truncateTables(){

        DB::table('AdAeoXPAFVfEWIEg')->truncate();
        DB::table('cOnJQWNPYMdPpRho')->truncate();
        DB::table('deXxaZzBolrXMQLG')->truncate();
        DB::table('inEYqLwqRvCYkkYw')->truncate();
        DB::table('troRjkOEBcftDOlf')->truncate();
        DB::table('UatMuXaJtDhDLqIe')->truncate();
        DB::table('UatMuXaJtDhDLqIe')->truncate();
        DB::table('ukyOfUauwGyniOUh')->truncate();
        DB::table('wrhRWuSQVNefeaEO')->truncate();
        DB::table('SWdFNEyNWJvmTur')->truncate();
        DB::table('AAlbCeRQCyyKtmzya')->truncate();
        DB::table('AAlbCeRQCyyKtmzya')->truncate();
        DB::table('UbfhFOJiWHBQdzNY')->truncate();
        DB::table('RedweMSFNdgWlhGJry')->truncate();
        DB::table('TrsnopjaXHTrYdCXory')->truncate();

        echo 'success';
    }



    public function getCryptoData(){
        $currSymbol = 'ETH';
        $binanceApiUrl           = "https://pro-api.coinmarketcap.com/";
        $binanceTickerUrl        = $binanceApiUrl.'v1/cryptocurrency/listings/latest';
        $binanceData             = self::getcurlCoinmarketcapHelper($binanceTickerUrl,$currSymbol);
        $binanceData             = json_decode($binanceData);
        $binanceData             = $binanceData->data;


        $currencyArray = ['USDT'];
        $updataBatchData     = array();
            foreach ($binanceData as $value) {
                $apiCurrencySymbol     = $value->symbol;
                    if (in_array($apiCurrencySymbol, $currencyArray)){
                        $usdPrice     = $value->quote->$currSymbol->price;
                        $updateData[] = array(
                                            'symbol' => $apiCurrencySymbol,
                                            'usdprice'=>  number_format($usdPrice,8),
                                        );
                        // array_push($updataBatchData,$updateData);
                    }
        }

        echo '<pre>';
        print_r($updateData);
        die;



        echo '<pre>';
        print_r($binanceData);
        die;


    }





    function getcurlCoinmarketcapHelper($url,$currSymbol){

        $parameters = [
            // 'start' => '1',
            // 'limit' => '5000',
            'convert' => $currSymbol,
          ];

          $headers = [
            'Accepts: application/json',
            'X-CMC_PRO_API_KEY: fff68bea-aa7d-4623-843a-a2a2a613a196'
          ];

          $qs         = http_build_query($parameters); // query string encode the parameters
          $request    = "{$url}?{$qs}"; // create the request URL

          $curl       = curl_init(); // Get cURL resource

          // Set cURL options
              curl_setopt_array($curl, array(
                CURLOPT_URL => $request,            // set the request URL
                CURLOPT_HTTPHEADER => $headers,     // set the headers
                CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
              ));

          $response   = curl_exec($curl); // Send the request, save the response
          curl_close($curl); // Close request
          // $response   = json_decode($response);
          return $response;

    }





    function createBinaryMLMBoard()
    {
        // Fetch existing data
        $directExists = Board::select('user_id', 'directId', 'placement_id', 'direct_count', 'board')->get();
        $users = Users::select('id', 'referrerId', 'directId', 'uplineCount','level_no')->get();

        // Calculate total uplineCount for the first 6 users
        $totalUplineCount = Users::where('uplineCount', 2)->take(6)->sum('uplineCount');

        // Set board based on total uplineCount
        $boardLevel = ($totalUplineCount >= 8) ? 2 : 1;

        foreach ($users as $index => $user) {
            // Set the board value based on the index
            $newBoardLevel = ($index < 6) ? 1 : $boardLevel;

            // Create a new user
            $newUser = [
                'user_id' => $user->id,
                'placement_id' => $user->directId,
                'directId' => $user->directId,
                'board' => $newBoardLevel,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert the new user
            Board::create($newUser);
        }

        die;
    }






//     $boardLevel = $referrerData ? $referrerData->board : 0;

//     // Count the number of users at the current level
//     $usersAtCurrentLevel = DB::table('BoUSxHTrYdJvmTurER')
//         ->where('placement_id', $directId)
//         ->where('board', $boardLevel)
//         ->count();




//     // Insert the new user into the binary tree structure with the calculated board level
//     $newUser = [
//         'user_id' => $userId,
//         'placement_id' => $directId,
//         'directId' => $directId,
//         'board' => $usersAtCurrentLevel >= 6 ? $boardLevel + 1 : $boardLevel,
//         'created_at' => now(),
//         'updated_at' => now(),
//     ];



//     $insertUser = DB::table('BoUSxHTrYdJvmTurER')->insert($newUser);

//     if ($insertUser) {
//         // Update the board for existing users in the tree
//         $this->updateBoard($userId, $directId);

//         return 'User created successfully. Board Level: ' . $newUser['board'];
//     } else {
//         return 'Failed to create user.';
//     }
// } else {
//     return 'DirectId not found.';
// }









// function generateRandomUsername()
// {
//     $length = rand(5, 10); // Set the desired length of the username
//     $characters = 'abcdefghijklmnopqrstuvwxyz';
//     $username = '';

//     for ($i = 0; $i < $length; $i++) {
//         $username .= $characters[rand(0, strlen($characters) - 1)];
//     }

//     return $username;
// }





// function autoFillAndStoreData($count = 100)
// {
//     $startReferralId = 3712; // Change this to the starting value of your referralId

//     for ($j = 0; $j < 2; $j++) { // Outer loop for the 2x2 matrix
//         for ($i = 0; $i < $count; $i++) { // Inner loop for each row
//             $referralId = 'REF017458' . ($startReferralId + $i);
//             $referrerDirectId = 'REF017458371' . ($i + 1);

//             // Use the same $referralId and $referrerDirectId for each iteration
//             $data = [
//                 'username' => generateRandomUsername(),
//                 'email' => encrypt_decrypt('encrypt', 'user' . (($j * $count * 2) + $i) . '@example.com'),
//                 'password' => 'ZjJya3dwQ0ZQRkRYVU0yejN0bVNLUT09', // You may want to generate a random password
//                 'mobile_no' => '123456789' . rand(1000, 9999), // Generate a random 4-digit number
//                 'referralId' => $referralId,
//                 'referrerId' => $referrerDirectId,
//                 'directId' => 'REF0174583711',
//                 'is_active' => 1,
//                 'is_verify' => 1,
//                 'level_no' => 1,
//                 'mlmType' => 1,
//                 'uplineCount' => ($i + 1),


//             ];


//             // echo "<pre>";
//             // print_r( $data);
//             // die;

//             $insert = Users::create($data);



//             if ($insert) {
//                 echo "Success";
//             } else {
//                 echo "Fail";
//             }
//         }
//     }
// }

// // Execute the entire process
// autoFillAndStoreData(6);












}
