<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Withdraw;
use App\Models\Balance;
use Illuminate\Support\Facades\URL;
use DB;
use session;
use Validator;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }




    public function Create_Currency(){

        $data['js_file'] = 'Create_Currency';
        $data['title'] = 'Create Currency';
        return view('admin.currency.create-currency', $data);

       }



       public function add_currency(Request $request){

        if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                'name' => 'required',
                'symbol' => 'required',
                'type' => 'required',
                'status' => 'required',
                'withdraw_status' => 'required',
                'deposit_status' => 'required',
                'investment_status' => 'required',
                'decimal' => 'required|numeric',
            ]);

            $name = $request->input('name');
            $symbol = $request->input('symbol');
            $type = $request->input('type');
            $status = $request->input('status');
            $withdraw_status = $request->input('withdraw_status');
            $deposit_status = $request->input('deposit_status');
            $decimal = $request->input('decimal');
            $investment_status = $request->input('investment_status');


            $currency_id = $request->input('currency_id');

            $lastPrice = self::getUsdPrice($symbol);

            $currencydata = [

                'name' => $name,
                'symbol' => $symbol,
                'type' => $type,
                'status' => $status,
                'usdPrice' => $lastPrice,
                'withdraw_status' => $withdraw_status,
                'deposit_status' => $deposit_status,
                'decimal' => $decimal,
                'investment_status' => $investment_status,
            ];




            $result = Currency::insert($currencydata);

            $CurId = DB::getPdo()->lastInsertId();

            $currencyData = [
            'currency_id' => $CurId,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s')

            ];

            $cur = DB::table('wsGHkkBbywgOkjXg')->insert($currencyData);

            if ($result) {
                    Session::flash('success', 'Currency has been added successfully!');
                    return redirect(env('ADMIN_URL').'/currencyList/');

            }
            else {

                Session::flash('error', 'Currency has been added  failed.');
                return redirect(env('ADMIN_URL').'/currencyList/');
            }
    }


       }


    function getUsdPrice($currSymbol){

        $currSymbol = $currSymbol;
        $binanceApiUrl           = "https://pro-api.coinmarketcap.com/";
        $binanceTickerUrl        = $binanceApiUrl.'v1/cryptocurrency/listings/latest';
        $binanceData             = self::getcurlCoinmarketcapHelper($binanceTickerUrl,$currSymbol);
        $binanceData             = json_decode($binanceData);
        $binanceData             = @$binanceData->data;


        $currencyArray = ['USDT'];
        $updateData = [];
        $updataBatchData     = array();
        if(isset($binanceData)){
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
      }

        return @($updateData) ? @$updateData[0]['usdprice'] : 0;
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


    public function currency_list(){

    $data['js_file'] = 'Currency List';
    $data['title'] = 'Currency List';
    return view('admin.currency.currency-list', $data);

   }


   public function getcurrencylist(Request $request){


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
         if($searchValue != ''){
            $searchQuery[] = "(cuKZJurxYSsFaXNv.name like '%".$searchValue."%' or cuKZJurxYSsFaXNv.symbol like '%".$searchValue."%' or cuKZJurxYSsFaXNv.type like '%".$searchValue."%' or cuKZJurxYSsFaXNv.created_at like '%".$searchValue."%')";
        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(cuKZJurxYSsFaXNv.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = Currency::count();
        // ## Total number of records with filtering
        $sel =  DB::select("select count(*) as allcount from cuKZJurxYSsFaXNv ".$WHERE);

        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;


        $empQuery = DB::select("SELECT * FROM cuKZJurxYSsFaXNv $WHERE
                    ORDER BY $columnName DESC
                    LIMIT $row, $rowperpage");


                                $data = array();
                    $i = 1;
                    foreach ($empQuery as $key => $value) {


                        $statusCheckbox = ($value->status == 1)
    ? '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'currency-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-success"></i></a>'
    : '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'currency-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\')"><i class="ti-unlock text-danger"></i></a>';


    $investmentstatus = ($value->investment_status  == 1)
    ? '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'investment-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-success"></i></a>'
    : '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'investment-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\')"><i class="ti-unlock text-danger"></i></a>';



    $editcur = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/editCurrency/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="Edit Currency" class="fa fa-edit pa-10"></i></a>';




                        $data[] = array(
                            'id' => $i,
                            "name" => $value->name,
                            "symbol" => $value->symbol,
                            "type" => $value->type,
                            "currency_type" => ($value->type == 0) ? 'Fiat' : 'Crypto',
                            "status" => $statusCheckbox,
                            "investment_status" => $investmentstatus,
                            "action" => $editcur,

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




   public function update_currency(Request $request){




    $validatedData = $request->validate([
         'currency_type' => 'required',
         'Withdrawstatus' => 'required',
         'depositstatus' => 'required',
         'currencystatus' => 'required',
         'usdprice'       => 'required|numeric',
         'investment_status' => 'required',
     ], [
         'currency_type.required' => 'Please currency type',
         'Withdrawstatus.required' => 'Please select withdraw status',
         'depositstatus.required' => 'Please select deposit status',
         'currency_status.required' => 'Please select currency status',
         'usdprice' => 'Please enter the USD decimal value',
         'investment_status.required' => 'Please select Investment status'
     ]);

         $currencyId = encrypt_decrypt('decrypt',strip_tags($request['currencyId']));


         $checkCurr = Currency::where('id',$currencyId);



         if($checkCurr->count() > 0){

             $currencyName = strip_tags($request['currency_name']);
             $currency_symbol = $request['currency_symbol'];
             $currency_type = strip_tags($request['currency_type']);
             $investment_status = strip_tags($request['investment_status']);
             $usdprice = strip_tags($request['usdprice']);


             $Withdrawstatus = $request['Withdrawstatus'];
             $depositstatus = $request['depositstatus'];
             $currencystatus = $request['currencystatus'];
             $investment_status = $request['investment_status'];
             $usdprice = $request['usdprice'];


             $lastPrice = self::getUsdPrice($currency_symbol);


             $updateData = [

                 'type' => $currency_type,
                 'withdraw_status' => $Withdrawstatus,
                 'deposit_status' => $depositstatus,
                 'status' => $currencystatus,
                 'usdprice' => $lastPrice,
                 'investment_status' => $investment_status,
             ];







             Currency::where('id',$currencyId)->update($updateData);

                $currencyData = [
                'status' => $currencystatus,
                ];

                $cur = DB::table('wsGHkkBbywgOkjXg')->where('currency_id',$currencyId)->update($currencyData);


             $admin_id = Session::get('adminId');
             admin_activity($admin_id, 'Currency setting Edit');
             Session::flash('success', 'Currency setting update successfully');
             // return redirect(env('ADMIN_URL').'/editCurrency/'.$request['currencyId']);
             return redirect(env('ADMIN_URL').'/currencyList/');


         }else{
              Session::flash('error', 'Invalid currency');
              return redirect(env('ADMIN_URL').'/currencyList');
         }

}




   public function currency_setting()
   {


    $data['currency'] = Currency::orderBy('id', 'DESC')->get();



    $data['js_file'] = 'Currency Setting';

    $data['js_file'] = '';
    $data['title'] = 'Currency Setting';

    return view('admin.currency.currency-setting', $data);

   }


    public function currency_status($id){



        $id = encrypt_decrypt('decrypt',$id);

            $checkCurrency = Currency::where('id',$id);

                if($checkCurrency->count() > 0){
                    $Currency = $checkCurrency->first();

                        $status = ($Currency->status == 1) ? 0 : 1;

                        Currency::where('id',$Currency->id)->update(['status' => $status]);

                            $currencyData = [
                            'status' => $currencystatus,
                            ];

                            $cur = DB::table('wsGHkkBbywgOkjXg')->where('currency_id',$Currency->id)->update($currencyData);

                        $admin_id = Session::get('adminId');
                        admin_activity($admin_id, 'Currency Status');
                        $msg = ($Currency->status == 1) ? 'deactive' : 'active';
                        Session::flash('success', 'Currency status '.$msg.' successfully');
                        return redirect(env('ADMIN_URL').'/currencyList');

                }else{

                }

    }


    public function investment_status($id){

        // echo "hai";
        // die;


        $id = encrypt_decrypt('decrypt',$id);

            $checkCurrency = Currency::where('id',$id);

                if($checkCurrency->count() > 0){
                    $Currency = $checkCurrency->first();

                        $status = ($Currency-> investment_status  == 1) ? 0 : 1;

                        Currency::where('id',$Currency->id)->update(['investment_status' => $status]);

                        $admin_id = Session::get('adminId');
                        admin_activity($admin_id, ' Investment Status ');

                        $msg = ($Currency->investment_status == 1) ? 'deactive' : 'active';
                        Session::flash('success', 'Investment status '.$msg.' successfully');
                        return redirect(env('ADMIN_URL').'/currencyList');

                }else{

                }

    }



    public function withdraw_status($id){
        $id = encrypt_decrypt('decrypt',$id);

        $checkCurrency = Currency::where('id',$id);

            if($checkCurrency->count() > 0){
                $Currency = $checkCurrency->first();

                    $status = ($Currency->withdraw_status == 1) ? 0 : 1;

                    Currency::where('id',$Currency->id)->update(['withdraw_status' => $status]);
                    $admin_id = Session::get('adminId');
                    admin_activity($admin_id, 'Withdraw status');
                    $msg = ($Currency->withdraw_status == 1) ? 'deactive' : 'active';
                    Session::flash('success', 'Withdraw status '.$msg.' successfully');
                    return redirect(env('ADMIN_URL').'/currencySetting');

            }else{

            }

    }





    public function deposit_status($id){
        $id = encrypt_decrypt('decrypt',$id);

            $checkCurrency = Currency::where('id',$id);

                if($checkCurrency->count() > 0){
                    $Currency = $checkCurrency->first();

                        $status = ($Currency->deposit_status == 1) ? 0 : 1;

                        Currency::where('id',$Currency->id)->update(['deposit_status' => $status]);
                        $admin_id = Session::get('adminId');
                        admin_activity($admin_id, 'Deposit Status');

                        $msg = ($Currency->deposit_status == 1) ? 'deactive' : 'active';
                        Session::flash('success', 'Deposit Status '.$msg.' successfully');
                        return redirect(env('ADMIN_URL').'/currencySetting');

                }else{

                }

    }

   public function viewucurrency($id){

    $currencyId = encrypt_decrypt('decrypt',$id);
    $data['currencyDetails'] = Currency::where('id',$currencyId)->first();



    $data['js_file'] = 'Edit currency';
    $data['title'] = 'Edit currency';
    $data["currencyId"] = $id;
    return view('admin.currency.viewucurrency', $data);

   }




   public function internaltransferamountupdate(Request $request){

    $validatedData = $request->validate([
        'Imin' => 'required',
        'Imax' => 'required',
    ],
     [
        'Imin.required' => 'Please Enter internal transfer min amount',
        'Imax.required' => 'Please Enter internal transfer max amount',
    ]);

    $currencyId = encrypt_decrypt('decrypt',strip_tags($request['currencyIdin']));




    $checkCurr = Withdraw::where('id',$currencyId);



    if($checkCurr->count() > 0){

    $Imin = strip_tags($request['Imin']);
    $Imax = strip_tags($request['Imax']);



    $Imin = $request['Imin'];
    $Imax = $request['Imax'];

    $updateData = [

        'Imin' => $Imin,
        'Imax' => $Imax,

    ];



    Withdraw::where('id',$currencyId)->update($updateData);

    $admin_id = Session::get('adminId');
    admin_activity($admin_id, 'Internal Transfer Amount updated');

    Session::flash('success', 'Internal transfer update successfully');
    return redirect(env('ADMIN_URL').'/currencySetting/');


}else{
     Session::flash('error', 'Invalid currency');
     return redirect(env('ADMIN_URL').'/currencySetting');
}


   }



   public function viewucurrency_setting($id)
   {
    $currencyId = encrypt_decrypt('decrypt',$id);

    $data['currencysetting'] = Currency::select('cuKZJurxYSsFaXNv.id','cuKZJurxYSsFaXNv.name','cuKZJurxYSsFaXNv.type', 'cuKZJurxYSsFaXNv.symbol','cuKZJurxYSsFaXNv.usdprice','cuKZJurxYSsFaXNv.withdraw_status','wsGHkkBbywgOkjXg.*')
    ->Join('wsGHkkBbywgOkjXg', 'cuKZJurxYSsFaXNv.id', '=', 'wsGHkkBbywgOkjXg.currency_id')
    ->where('cuKZJurxYSsFaXNv.id',$currencyId)->first();




    $data['js_file'] = 'currency_setting';
    $data['title'] = 'Edit currency';

    return view('admin.currency.currecy-setting-list', $data);

   }



   public function getcurrencysettings(Request $request){

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
         if($searchValue != ''){
            $searchQuery[] = "(cuKZJurxYSsFaXNv.name like '%".$searchValue."%' or cuKZJurxYSsFaXNv.symbol like '%".$searchValue."%' or cuKZJurxYSsFaXNv.withdraw_status like '%".$searchValue."%' or cuKZJurxYSsFaXNv.created_at like '%".$searchValue."%')";
        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(cuKZJurxYSsFaXNv.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = Currency::count();
        // ## Total number of records with filtering
        $sel =  DB::select("select count(*) as allcount from cuKZJurxYSsFaXNv ".$WHERE);

        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;

        // $empQuery = DB::select("select AAlbCeRQCyyKtmzya.*,AnbopVhAvWSumu.name FROM AAlbCeRQCyyKtmzya INNER JOIN AnbopVhAvWSumu ON AAlbCeRQCyyKtmzya.adminId = AnbopVhAvWSumu.id ".$WHERE." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage);




        // $empQuery = DB::select("SELECT * FROM cuKZJurxYSsFaXNv $WHERE
        //                 ORDER BY $columnName $columnSortOrder
        //                 LIMIT $row, $rowperpage");

        $empQuery = DB::select("SELECT * FROM cuKZJurxYSsFaXNv $WHERE
        ORDER BY $columnName DESC
        LIMIT $row, $rowperpage");



                                $data = array();
                    $i = 1;
                    foreach ($empQuery as $key => $value) {


                        $statusCheckbox = ($value->status == 1)
    ? '<a href="javascript:void()" onclick="return confirmcurrencyStatusChange(\'currency-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\')"><i class="ti-unlock text-success"></i></a>'
    : '<a href="javascript:void()" onclick="return confirmcurrencyStatusChange(\'currency-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-danger"></i></a>';



    $withdraw = ($value->withdraw_status == 1)
    ? '<a href="javascript:void()" onclick="return confirmwithdrawstatus(\'withdraw-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\')"><i class="ti-unlock text-success"></i></a>'
    : '<a href="javascript:void()" onclick="return confirmwithdrawstatus(\'withdraw-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-danger"></i></a>';



    $deposit = ($value->deposit_status == 1)
    ? '<a href="javascript:void()" onclick="return confirmdepositstatus(\'deposit-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\')"><i class="ti-unlock text-success"></i></a>'
    : '<a href="javascript:void()" onclick="return confirmdepositstatus(\'deposit-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-danger"></i></a>';



    $editcur = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/editcurrencySetting/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="Edit Currency setting" class="fa fa-edit pa-10"></i></a>';




                        $data[] = array(
                            'id' => $i,
                            "name" => $value->name,
                            "symbol" => $value->symbol,
                            "withdraw" => $withdraw,
                            "deposit" => $deposit,
                            "status" => $statusCheckbox,
                            "action" => $editcur,

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













   public function deposit_setting(Request $request){


    $validator = Validator::make($request->all(),[
        'name' => 'required',
        'symbol' => 'required',
        'type' => 'required',
        'deposit_status' => 'required',
    ], [
        'name.required' => 'Please enter your currency name',
        'symbol.required' => 'Please enter your currency symbol',
        'type.required' => 'Please select currency type',
        'deposit_status.required' => 'Please select deposit status',
    ]);


         $currencyId = encrypt_decrypt('decrypt',strip_tags($request['currencyIdse']));


         $checkCurr = Currency::where('id',$currencyId);
         if($checkCurr->count() > 0){

             $currencyName = strip_tags($request['name']);
             $currency_symbol = strip_tags($request['symbol']);
             $currency_type = strip_tags($request['type']);
             $deposit_status = $request['deposit_status'];


             $updateData = [

                 'type' => $currency_type,
                //  'name' => $currencyName,
                //  'symbol' => $currency_symbol,
                 'deposit_status' => $deposit_status,
             ];




             Currency::where('id',$currencyId)->update($updateData);
             $admin_id = Session::get('adminId');
             admin_activity($admin_id, 'Currency setting update');
             Session::flash('success', 'Currency setting update successfully');
             return redirect(env('ADMIN_URL').'/currencyList'.$request['currencyId']);


         }else{
              Session::flash('error', 'Invalid currency');
              return redirect('currency');
         }


 }



 public function withdrawcurrency_setting(Request $request){


    $validator = Validator::make($request->all(),[
        'per_day_limit' => 'required',
        'min' => 'required',
        'max' => 'required',
        'fee' => 'required',
        'withdraw_status' => 'required',
        'usdprice' => 'required',

    ], [
        'per_day_limit.required' => 'Please enter your currency name',
        'min.required' => 'Please Enter your currency symbol',
        'max.required' => 'Please select currency type',
        'fee.required' => 'Please select deposit status',
    ]);


         $currencyId = encrypt_decrypt('decrypt',strip_tags($request['currencyIdw']));




         $checkCurr = Withdraw::where('id',$currencyId);
         if($checkCurr->count() > 0){

             $per_day_limit = strip_tags($request['per_day_limit']);
             $min = strip_tags($request['min']);
             $max = strip_tags($request['max']);
             $fee = strip_tags($request['fee']);
             $usdprice = strip_tags($request['usdprice']);
             $withdraw_status = strip_tags($request['withdraw_status']);


             $updateData = [

                 'per_day_limit' => $per_day_limit,
                 'min' => $min,
                 'max' => $max,
                 'fee' => $fee,

             ];

             Withdraw::where('id',$currencyId)->update($updateData);


             $checkCurr = Currency::where('id',$currencyId);
             if($checkCurr->count() > 0){

             $updateData = [

                'usdprice' => $usdprice,
                'withdraw_status' => $withdraw_status,

            ];


            Currency::where('id',$currencyId)->update($updateData);

             Session::flash('success', 'Currency setting edit successfully');
             return redirect(env('ADMIN_URL').'/currencySetting'.$request['currencyId']);


         }}
         else{
              Session::flash('error', 'Invalid currency');
              return redirect('currency');
         }


 }









}
