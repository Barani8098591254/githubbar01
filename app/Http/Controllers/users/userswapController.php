<?php

namespace App\Http\Controllers\users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Swap;
use App\Models\Swaphistory;

use DB;
use session;

use App\Models\Users;
use App\Models\Currency;
use App\Models\Transaction;



class userswapController extends Controller
{

    public function instantswap()
    {

        $data['currencyList'] = Swap::where('status', 1)->get();
        $data['title'] = 'Instant swap';
        $data['js_file'] = 'instantswap';
        $data['pageTitle'] = 'Instant Swap';
        $data['subTitle'] = 'Instant Swap';
        return view('user.swap.instantswap', $data);
    }

    public function swaphistory()
    {

        $data['title'] = 'Swap History';
        $data['js_file'] = '';
        $data['pageTitle'] = 'Swap History';
        $data['subTitle'] = 'Swap History';
        return view('user.swap.swaphistory', $data);
    }

    public function getapairdata(Request $request) {


        $userId = userId();


        if ($request->isMethod('post')) {
            $postValue = $request->all();

            $PostValue = ($postValue);
            $pair_id = $PostValue['pair_id'];

            $pairData = Swap::where('status', 1)->where('id', $pair_id)->first();

            if ($pairData) {
                $pairFromCurrencyID = $pairData->from_currency;
                $pairToCurrencyID = $pairData->to_currency;

                // Assuming you have a function to get balance.
                $userFromBalance = get_balance($userId, $pairFromCurrencyID);
                $userToBalance = get_balance($userId, $pairToCurrencyID);

                $pairResponse	= array(
                    "pair_id"=>$pairData->id,
                    "pair"=>$pairData->pair,
                    "bmarketpair"=>$pairData->binance_pair,
                    "from_currency"=>$pairData->from_currency,
                    "to_currency"=>$pairData->to_currency,
                    "marketprice"=>$pairData->marketprice,
                    "min"=>$pairData->min,
                    "max"=>$pairData->max,
                    "fee"=>$pairData->fee,
                    "spread"=>$pairData->spread,
                                        );
                    $res = ['status' => 1,'msg' => 'Success','particullarpairData' => $pairResponse,'userFromBalance' => (float)$userFromBalance,'userToBalance' => (float)$userToBalance];
                    echo json_encode($res) ; exit;
                    }else{
                    $res = ['status' => 0,'msg' => 'Invalid Pair','page' => 'instantswap'];
                    echo json_encode($res) ; exit;
                    }
                    }else{
                    $res = ['status' => 0,'msg' => 'Invalid Access','page' => 'instantswap'];
                    echo json_encode($res) ; exit;
                    }
                    }





    function swapbuy(Request $request){
        $user_id = userId();
        $userId = userId();
        $getUserKydDetails = user_details($userId,'kyc_status');


        if(setting()->kyc == 1){

            if($getUserKydDetails != 3 || $getUserKydDetails == ''){
                Session::flash('error', 'Please kindly fill KYC once approved after continue');
                return redirect('profile');
            }
         }




            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $pair_id    =  $request['pair_id'];
               $type       =  $request['type'];
               $fromAmount =  $request['fromAmount'];
               $toAmount   =  $request['toAmount'];
               $marketPrice=  $request['marketPrice'];


               if(empty($pair_id)){
                $msg = 'Kindly selecte the valid pair !!!';
                Session::flash('error', $msg);
                return redirect('instantswap');
               }

                $pairData  = Swap::where('status',1)->where('id',$pair_id)->first();

                    if($pairData){

                        $pairFromCurencyID  = $pairData->from_currency;
                        $pairToCurencyID    = $pairData->to_currency;
                        $pairMarketPrice    = $pairData->marketprice;
                        $pairMin            = $pairData->min;
                        $pairMax            = $pairData->max;
                        $pair               = $pairData->pair;
                        $pairSpread         = $pairData->spread;
                        $pairFee            = $pairData->fee;

                        $explodPair         = explode("_", $pair);
                        $userToBalance      = get_balance($user_id, $pairToCurencyID);
                        $userFromBalance    = get_balance($user_id, $pairFromCurencyID);

                            $pairMarketpriceValue   = (float)$pairMarketPrice * (float)$pairSpread / 100 ;
                            $pairPriceCalculatValue = (float)$pairMarketPrice + (float)$pairMarketpriceValue;

                            $userToAmount       = (float)$fromAmount * (float)$pairPriceCalculatValue;
                            $status             = 1;
                            $fee                = $pairFee;

                                // balance check
                                if($type == 'buy'){
                                    if((float)$userToBalance < (float)$userToAmount){
                                        $msg = 'Insufficiant Balance';
                                        Session::flash('error', $msg);
                                        return redirect('instantswap');

                                    }
                                }else{
                                    if((float)$userFromBalance < (float)$fromAmount){
                                        $msg = 'Insufficiant Balance';
                                        Session::flash('error', $msg);
                                        return redirect('instantswap');
                                    }
                                }

                                // check min and max value
                                if(((float)$userToAmount < (float)$pairMin) ||  ((float)$userToAmount > (float)$pairMax)){
                                    $msg = 'Spend Amount not in Min and Max value range. Kindly check it.';
                                    Session::flash('error', $msg);
                                    return redirect('instantswap');
                                }

                                // get user data
                                $sessionUserData    = user_detailsRow(userId());
                                if($sessionUserData){
                                    $sessionUserDataUserName    = $sessionUserData->username;
                                    $sessionUserDataUserEmail   = encrypt_decrypt('decrypt',$sessionUserData->email);
                                }else{
                                    $msg = 'Invalid User';
                                    Session::flash('error', $msg);
                                    return redirect('instantswap');
                                }

                                // currency balance
                                if($type == 'buy'){

                                    $secondCurrencyBalanceData  = (float)$userToBalance -  (float)$userToAmount;

                                    $feevalue                   = (float)$fromAmount * (float)$fee / 100;
                                    $Receviefromamount          = (float)$fromAmount - (float)$feevalue;
                                    // $firstCurrencyBalanceData    = (float)$userFromBalance + (float)$fromAmount;
                                    $firstCurrencyBalanceData   = (float)$userFromBalance + (float)$Receviefromamount;
                                }else{
                                    // $firstCurrencyBalanceData    = bcsub($userFromBalance, $fromAmount,8);
                                    // $secondCurrencyBalanceData   = bcadd($userToBalance, $userToAmount,8);
                                    $firstCurrencyBalanceData   = (float)$userFromBalance - (float)$fromAmount;

                                    $feevalue                   = (float)$userToAmount * (float)$fee / 100;
                                    $Recevietoamount            = (float)$userToAmount - (float)$feevalue;
                                    // $secondCurrencyBalanceData   = (float)$userToBalance + (float)$userToAmount;
                                    $secondCurrencyBalanceData  = (float)$userToBalance + (float)$Recevietoamount;
                                }

                                $insertSwapData = array(
                                                'pair'              => $pair,
                                                'pair_id'           => $pair_id,
                                                'user_id'           => $user_id,
                                                'from_currency'     => $pairFromCurencyID,
                                                'to_currency'       => $pairToCurencyID,
                                                'from_amount'       => $fromAmount,
                                                'to_amount'         => $userToAmount,
                                                'type'              => $type,
                                                'marketprice'       => $pairMarketPrice,
                                                'calculatemarketprice' => $pairPriceCalculatValue,
                                                'fee'               => $feevalue,
                                                'status'            => $status,
                                                'created_at'        => date('Y-m-d H:i:s'),
                                                'updated_at'        => date('Y-m-d H:i:s'),
                                            );
                                Swaphistory::insert($insertSwapData);
                                $firstBalanceUpdate         = update_balance($user_id,$pairFromCurencyID,$firstCurrencyBalanceData);
                                $secondBalanceUpdate        = update_balance($user_id,$pairToCurencyID,$secondCurrencyBalanceData);
                                $perfeevalue                = (float)$feevalue * 50 / 100;

                                $res = 1;
                                // self::moveDirectReferral(userId(),$perfeevalue,$pairFromCurencyID,$explodPair[0]);

                                $user_id = Session::get('userId');
                                user_activity($user_id, 'buy swap Request has been completed');

                                if($res){
                                    $msg = 'Request has been completed !!!';
                                    Session::flash('success', $msg);
                                    return redirect('instantswap');

                                }else{

                                    // $send   = sendemail($tomail,13,'Self Trade - Crovva Crypto Exchange',$content);
                                    $msg = 'Something went to wrong.Please try again later !!!';
                                    Session::flash('error', $msg);
                                    return redirect('instantswap');
                                }

                    }else{
                        $msg = 'Invalid Pair';
                        Session::flash('error', $msg);
                        return redirect('instantswap');
                    }



            }else{
                $msg = 'Invalid Access';
                Session::flash('error', $msg);
                return redirect('swap');
            }

    }


    function moveDirectReferral($user_id,$feevalue,$CurencyID,$CurrecnySymbol){

        $userData   = Users::where('is_active',1)->where('id',$user_id);

            if($userData->count() > 0){
                $userData = $userData->first();
                $referrerId = $userData->directId;
                $referrerUserData   = Users::where('is_active',1)->where('directId',$referrerId)->first();

                    if($referrerUserData){
                        $referrerId     = $referrerUserData->id;
                        $usdCurrencyId = 2;

                        if((int)$CurencyID == (int)$usdCurrencyId){
                            $referrerUserToBalance      = get_balance($referrerId, $CurencyID);

                            $UserBalanceData            = (float)$referrerUserToBalance + (float)$feevalue;

                        // calculate refferal amount
                            $insertProfitData   = array(
                                                    'userid'            => $referrerId,
                                                    'amount'            => $feevalue,
                                                    'decimal_amount'    => $feevalue,
                                                    'currency'          => $CurrecnySymbol,
                                                    'description'       => "Direct Commission Earned From Instatswap",
                                                    'txid'    => 'DIRCS'.date('ymdhis'),
                                                    'from_id'           => $user_id,
                                                    'type'              => "instant_swap",
                                                    'wallet_status'     => 1,
                                                    'hold_status'       => 1,
                                                    'created_at'        => date('Y-m-d H:i:s'),
                                                );
                             $insertTransaction  = Transaction::insert($insertProfitData);
                             $refferalBalanceUpdate  = update_balance($referrerId,$usdCurrencyId,$UserBalanceData);
                        }else{
                            $currencyData   =  Currency::where('id',$CurencyID)->first();

                            if($currencyData){
                                $currencyUSDPrice = $currencyData->usdprice;
                                if($currencyUSDPrice > 0){
                                    $referrerUserToBalance      = get_balance($referrerId, $usdCurrencyId);
                                    $feevalue                   = (float)$feevalue * (float)$currencyUSDPrice;
                                    $UserBalanceData            = (float)$referrerUserToBalance + (float)$feevalue;

                                    // calculate refferal amount
                                        $insertProfitData   = array(
                                                                'userid'            => $referrerId,
                                                                'amount'            => $feevalue,
                                                                'decimal_amount'    => $feevalue,
                                                                'currency'          => "USD",
                                                                'description'       => "Direct Commission Earned From Instatswap",
                                                                'txid'  => 'DIRCS'.date('ymdhis'),
                                                                'from_id'           => $user_id,
                                                                'type'              => "instant_swap",
                                                                'wallet_status'     => 1,
                                                                'hold_status'       => 1,
                                                                'created_at'        => date('Y-m-d H:i:s'),
                                                            );
                                        $insertTransaction  = Transaction::insert($insertProfitData);
                                        $refferalBalanceUpdate  = update_balance($referrerId,$usdCurrencyId,$UserBalanceData);
                                        return;
                                }else{
                                    $referrerUserToBalance      = get_balance($referrerId, $CurencyID);

                                    $UserBalanceData            = (float)$referrerUserToBalance + (float)$feevalue;

                                // calculate refferal amount
                                    $insertProfitData   = array(
                                                            'userid'            => $referrerId,
                                                            'amount'            => $feevalue,
                                                            'decimal_amount'    => $feevalue,
                                                            'currency'          => $CurrecnySymbol,
                                                            'description'       => "Direct Commission Earned From Instatswap",
                                                            'txid'    => 'DIRCS'.date('ymdhis'),
                                                            'from_id'           => $user_id,
                                                            'type'              => "instant_swap",
                                                            'wallet_status'     => 1,
                                                            'hold_status'       => 1,
                                                            'created_at'        => date('Y-m-d H:i:s'),
                                                        );
                                     $insertTransaction  = Transaction::insert($insertProfitData);
                                     $refferalBalanceUpdate  = update_balance($referrerId,$usdCurrencyId,$UserBalanceData);
                                }
                            }
                        }
                    }
            }
    }


        function swapsell(Request $request){
            $user_id = userId();
            $userId = userId();

        $getUserKydDetails = user_details($userId,'kyc_status');

            // if($getUserKydDetails != 3 || $getUserKydDetails == ''){
            //     Session::flash('error', 'Please kindly fill KYC once approved after continue');
            //     return redirect('profile');
            // }



        if(setting()->kyc == 1){

            if($getUserKydDetails != 3 || $getUserKydDetails == ''){
                Session::flash('error', 'Please kindly fill KYC once approved after continue');
                return redirect('profile');
            }
         }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

               $pair_id    =  $request['pair_id'];
               $type       =  $request['type'];
               $fromAmount =  $request['sellfromAmount'];
               $toAmount   =  $request['selltoAmount'];
               $marketPrice=  $request['marketPrice'];

                if(empty($pair_id)){
                $msg = 'Kindly selecte the valid pair !!!';
                Session::flash('error', $msg);
                return redirect('instantswap');
               }

                $pairData  = Swap::where('status',1)->where('id',$pair_id)->first();

                    if($pairData){

                        $pairFromCurencyID  = $pairData->from_currency;
                        $pairToCurencyID    = $pairData->to_currency;
                        $pairMarketPrice    = $pairData->marketprice;
                        $pairMin            = $pairData->min;
                        $pairMax            = $pairData->max;
                        $pair               = $pairData->pair;
                        $pairSpread         = $pairData->spread;
                        $pairFee            = $pairData->fee;

                        $explodPair         = explode("_", $pair);
                        $userToBalance      = get_balance($user_id, $pairToCurencyID);
                        $userFromBalance    = get_balance($user_id, $pairFromCurencyID);

                            $pairMarketpriceValue   = (float)$pairMarketPrice * (float)$pairSpread / 100 ;
                            $pairPriceCalculatValue = (float)$pairMarketPrice - (float)$pairMarketpriceValue ;
                            $userToAmount           = (float)$fromAmount * (float)$pairPriceCalculatValue;
                            $status                 = 1;
                            $fee                    = $pairFee;

                                // balance check
                                if($type == 'buy'){
                                    if((float)$userToBalance < (float)$userToAmount){
                                        $msg = 'Insufficiant Balance';
                                        Session::flash('error', $msg);
                                        return redirect('instantswap');

                                    }
                                }else{
                                   if((float)$userFromBalance < (float)$fromAmount){
                                        $msg = 'Insufficiant Balance';
                                        Session::flash('error', $msg);
                                        return redirect('instantswap');
                                    }
                                }

                                // check min and max value
                                if(((float)$userToAmount < (float)$pairMin) ||  ((float)$userToAmount > (float)$pairMax)){
                                    $msg = 'Receive Amount not in Min and Max value range. Kindly check it.';
                                    Session::flash('error', $msg);
                                    return redirect('instantswap');
                                }

                                // get user data
                                $sessionUserData    = user_detailsRow(userId());
                                if($sessionUserData){
                                    $sessionUserDataUserName    = $sessionUserData->username;
                                    $sessionUserDataUserEmail   = encrypt_decrypt('decrypt',$sessionUserData->email);
                                }else{
                                    $msg = 'Invalid User';
                                    Session::flash('error', $msg);
                                    return redirect('instantswap');
                                }

                               // currency balance
                                if($type == 'buy'){
                                    // $firstCurrencyBalanceData    = bcadd($userFromBalance, $fromAmount,8);
                                    // $secondCurrencyBalanceData   = bcsub($userToBalance, $userToAmount,8);
                                    $secondCurrencyBalanceData  = (float)$userToBalance -  (float)$userToAmount;

                                    $feevalue                   = (float)$fromAmount * (float)$fee / 100;
                                    $Receviefromamount          = (float)$fromAmount - (float)$fromAmount;
                                    // $firstCurrencyBalanceData    = (float)$userFromBalance + (float)$fromAmount;
                                    $firstCurrencyBalanceData   = (float)$userFromBalance +  (float)$Receviefromamount;
                                }else{
                                    // $firstCurrencyBalanceData    = bcsub($userFromBalance, $fromAmount,8);
                                    // $secondCurrencyBalanceData   = bcadd($userToBalance, $userToAmount,8);
                                    $firstCurrencyBalanceData   = (float)$userFromBalance - (float)$fromAmount;

                                    $feevalue                   = (float)$userToAmount * (float)$fee / 100;
                                    $Recevietoamount            = (float)$userToAmount - (float)$feevalue;
                                    // $secondCurrencyBalanceData   = (float)$userToBalance + (float)$userToAmount;
                                    $secondCurrencyBalanceData  = (float)$userToBalance + (float)$Recevietoamount;
                                }



                                $insertSwapData = array(
                                                'pair'              => $pair,
                                                'pair_id'           => $pair_id,
                                                'user_id'           => $user_id,
                                                'from_currency'     => $pairFromCurencyID,
                                                'to_currency'       => $pairToCurencyID,
                                                'from_amount'       => $fromAmount,
                                                'to_amount'         => $userToAmount,
                                                'type'              => $type,
                                                'marketprice'       => $pairMarketPrice,
                                                'calculatemarketprice' => $pairPriceCalculatValue,
                                                'fee'               => $feevalue,
                                                'status'            => $status,
                                                'created_at'        => date('Y-m-d H:i:s'),
                                                'updated_at'        => date('Y-m-d H:i:s'),
                                            );


                                Swaphistory::insert($insertSwapData);
                                $firstBalanceUpdate         = update_balance($user_id,$pairFromCurencyID,$firstCurrencyBalanceData);
                                    $secondBalanceUpdate        = update_balance($user_id,$pairToCurencyID,$secondCurrencyBalanceData);
                                    $perfeevalue                = (float)$feevalue * 50 / 100;

                                $res = 1;
                                // self::moveDirectReferral(userId(),$perfeevalue,$pairFromCurencyID,$explodPair[0]);

                                $user_id = Session::get('userId');
                                user_activity($user_id, 'sell swap Request has been completed');

                                if($res){
                                    $msg = 'Request has been completed !!!';
                                    Session::flash('success', $msg);
                                    return redirect('instantswap');

                                }else{

                                    // $send   = sendemail($tomail,13,'Self Trade - Crovva Crypto Exchange',$content);
                                    $msg = 'Something went to wrong.Please try again later !!!';
                                    Session::flash('error', $msg);
                                    return redirect('instantswap');
                                }

                    }else{
                        $msg = 'Invalid Pair';
                        Session::flash('error', $msg);
                        return redirect('instantswap');
                    }



            }else{
                $msg = 'Invalid Access';
                Session::flash('error', $msg);
                return redirect('instantswap');
            }

    }





                    public function instant_swaphistory(){
                        $data['title'] = 'Instant Swap History';
                        $data['js_file'] = 'Instant Swap History';
                        $data['pageTitle'] = 'Instant Swap History';
                        $data['subTitle'] = 'Instant Swap History';
                        return view('user.swap.InstantSwapHistory', $data);
                    }







                    public function getInstantSwaphistory(Request $request){

                        $userId = userId();

                        $draw = $request->input('draw');
                        $row = $request->input('start');
                        $rowperpage = $request->input('length');
                        $columnIndex = $request->input('order.0.column');
                        $columnName = $request->input('columns.' . $columnIndex . '.data');
                        $columnSortOrder = $request->input('order.0.dir');
                        $searchValue = $request->input('search.value');

                        // Date search value
                        $searchByFromdate = $request->input('searchByFromdate');
                        $searchByTodate = $request->input('searchByTodate');

                        // Search Query
                        $searchQuery = [];
                        if (!empty($searchValue)) {

                            $searchQuery[] = "(from_currency like '%" . $searchValue . "%' or to_currency like '%" . $searchValue . "%' or pair like '%" . $searchValue . "%' or type like '%" . $searchValue . "%' or username like '%" . $searchValue . "%' or status like '%" . $searchValue . "%')";

                        }


                        // Date filter
                        if (!empty($searchByFromdate) && !empty($searchByTodate)) {
                            $startDate = $searchByFromdate . ' 00:00:00';
                            $endDate = $searchByTodate . ' 23:59:59';
                            $searchQuery[] = "(created_at between '" . $startDate . "' and '" . $endDate . "')";
                        }

                        $WHERE = "";
                        if (!empty($searchQuery)) {
                            $WHERE = " AND " . implode(' and ', $searchQuery);
                        }

                        // Total number of records without filtering
                        $totalRecords = Swaphistory::count();

                        // Total number of records with filtering
                        // $sel = DB::select("select count(*) as allcount from SWdFNEyNWJvmTur WHERE user_id = :user_id $WHERE", [
                        //     'user_id' => $userId,
                        // ]);


                        $sel = DB::select("SELECT COUNT(*) as allcount FROM SWdFNEyNWJvmTur
                    INNER JOIN UeAVBvpelsUJpczNv ON SWdFNEyNWJvmTur.user_id = UeAVBvpelsUJpczNv.id
                    WHERE SWdFNEyNWJvmTur.user_id = :user_id $WHERE", [
    'user_id' => $userId,
]);


                        $totalRecordwithFilter = $sel[0]->allcount;

                        $newSortOrder = ($columnSortOrder === 'asc') ? 'desc' : 'asc';

                        // $sqlQuery = "SELECT * FROM SWdFNEyNWJvmTur
                        // WHERE user_id = :user_id $WHERE
                        // ORDER BY $columnName $newSortOrder
                        // LIMIT :row, :rowperpage";

                        // $empQuery = DB::select($sqlQuery, [
                        //     'user_id' => $userId,
                        //     'row' => $row,
                        //     'rowperpage' => $rowperpage,
                        // ]);



                        $empQuery = "SELECT SWdFNEyNWJvmTur.*, UeAVBvpelsUJpczNv.username
    FROM SWdFNEyNWJvmTur
    JOIN UeAVBvpelsUJpczNv ON SWdFNEyNWJvmTur.user_id = UeAVBvpelsUJpczNv.id
    WHERE SWdFNEyNWJvmTur.user_id = :user_id $WHERE
    ORDER BY $columnName $newSortOrder
    LIMIT :row, :rowperpage";



$empQuery = DB::select($empQuery, [
    'user_id' => $userId,
    'row' => $row,
    'rowperpage' => $rowperpage,
]);



                    $data = [];
                    $i = 1;
                    foreach ($empQuery as $value) {
                        $expolePair = explode("_", $value->pair);

                        if ($value->type == 'buy') {
                            $recevieAmount = number_format($value->from_amount,get_currency($value->from_currency)->decimal) . " " . getfrom_currency($value->from_currency);
                            $spendAmount =  number_format($value->to_amount,get_currency($value->to_currency)->decimal) . " " . getto_currency($value->to_currency);
                            $feeValue = number_format($value->fee,get_currency($value->from_currency)->decimal) . " " . getfrom_currency($value->from_currency);
                        } else {
                            $recevieAmount = number_format($value->to_amount,get_currency($value->to_currency)->decimal) . " " . getto_currency($value->to_currency);
                            $spendAmount = number_format($value->from_amount,get_currency($value->from_currency)->decimal) . " " . getfrom_currency($value->from_currency);
                            $feeValue = number_format($value->fee,get_currency($value->to_currency)->decimal)  . " " . getto_currency($value->to_currency);
                        }



                        $data[] = [
                            'id' => $i,
                            "username" => getUserName($value->user_id),
                            "pair" => $value->pair,
                            "recevieAmount" => $recevieAmount,
                            "spendAmount" => $spendAmount,
                            "fee" => $feeValue,
                            "type" => ($value->type == 'sell') ? '<label class="text-danger"> Sell </label>' : '<label class="text-success"> Buy </label>',
                            "status" => ($value->status == 3) ? '<label class="text-danger"> Cancelled </label>' : '<label class="text-success"> Completed </label>',
                            "date" => date('d, M y h:i A', strtotime($value->created_at)),
                        ];
                        $i++;
                    }





                        // Response
                        $response = [
                            "draw" => intval($draw),
                            "iTotalRecords" => $totalRecords,
                            "iTotalDisplayRecords" => $totalRecordwithFilter,
                            "aaData" => $data,
                        ];

                        return response()->json($response);
                    }






}
