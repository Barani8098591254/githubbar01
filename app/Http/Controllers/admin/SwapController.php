<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Swap;
use Session;
use DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Models\Swaphistory;
class SwapController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }



    public function getActiveCurrency()
    {
        $result = Currency::where('status', 1)->get();

        return $result;
    }





    public function add_swap()
    {
        $data['currencyResult'] = $this->getActiveCurrency();
        $data['js_file'] = 'swap_val';
        $data['title'] = 'Add Swap Pair';

        return view('admin.swap.create-swap', $data);
    }


    public function getPairs($fromCurrency, $toCurrency)
    {
        $result = Swap::where('from_currency', $fromCurrency)
            ->where('to_currency', $toCurrency)
            ->get();
        return $result;
    }

    public function swapstore(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'from_currency' => 'required',
                'to_currency' => 'required',
                'binance_pair' => 'required',
                'min' => 'required|numeric',
                'max' => 'required|numeric',
                'fee' => 'required|numeric',
                'fee_type' => 'required',
                'status' => 'required',
                'spread' => 'required|numeric',
            ]);

            $fromCurrency = $request->input('from_currency');
            $toCurrency = $request->input('to_currency');
            $binancePair = $request->input('binance_pair');
            $min = $request->input('min');
            $max = $request->input('max');
            $fee = $request->input('fee');
            $feeType = $request->input('fee_type');
            $status = $request->input('status');
            $spread = $request->input('spread');

            if ((float)$min >= (float)$max) {
                    Session::flash('errors', 'Max value must be greater than Min value');
                    return redirect()->back();

            }

            if ($fromCurrency == $toCurrency) {
                    Session::flash('errors', 'From currency and To currency must not be the same!');
                    return redirect()->back();
                }

            $alreadyPairs = $this->getPairs($fromCurrency, $toCurrency);


            if ($alreadyPairs->count() > 0) {
                Session::flash('error', 'Pair already exists!');
                    return redirect(env('ADMIN_URL').'/addswap/');

            }

            $pairData = [
                'pair' => $request->input('pair_value'),
                'from_currency' => $fromCurrency,
                'to_currency' => $toCurrency,
                'binance_pair' => $binancePair,
                'status' => $status,
                'min' => $min,
                'max' => $max,
                'fee' => $fee,
                'fee_type' => $feeType,
                'spread' => $spread,
            ];

            // Assuming you have a model named CurrencyModel for adding pairs
            $result = Swap::insert($pairData);


            if ($result) {
                    Session::flash('success', 'Pair has been added successfully!');
                    return redirect(env('ADMIN_URL').'/swaplist/');

            }
            else {

                Session::flash('error', 'Withdraw request has been failed.');
                return redirect(env('ADMIN_URL').'/swaplist/');
            }
    }
}



public function swap_list()
{
    $data['js_file'] = '';
    $data['title'] = 'Swap Pair List';

    return view('admin.swap.swap-list', $data);
}



public function getswaplist(Request $request){



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
            $searchQuery[] = "(SFz7dNlvjXZgyPQyaRf.from_currency like '%".$searchValue."%' or SFz7dNlvjXZgyPQyaRf.to_currency like '%".$searchValue."%' or SFz7dNlvjXZgyPQyaRf.pair like '%".$searchValue."%')";
        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(SFz7dNlvjXZgyPQyaRf.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = Swap::count();
        // ## Total number of records with filtering
        $sel =  DB::select("select count(*) as allcount from SFz7dNlvjXZgyPQyaRf ".$WHERE);

        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;



        $newSortOrder = ($columnSortOrder === 'asc') ? 'desc' : 'asc';

        $empQuery = DB::select("SELECT * FROM SFz7dNlvjXZgyPQyaRf $WHERE
                        ORDER BY $columnName $newSortOrder
                        LIMIT $row, $rowperpage");



// dd($empQuery);
// die;



                                $data = array();
                    $i = 1;
                    foreach ($empQuery as $key => $value) {



                            $swapstatus = ($value->status == 1)
                            ? '<a href="javascript:void()" onclick="return confirmtfaChange(\'updatetfa/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-success"></i></a>'
                            : '<a href="javascript:void()" onclick="return confirmtfaChange(\'updatetfa/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\' disabled)"><i class="ti-lock text-danger"></i></a>';


                            $editswap = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/swapupdate/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="swap Edit" class="fa fa-edit pa-10"></i></a>';



                        $data[] = array(
                            'id' => $i,
                            "pair" => $value->pair,
                            "from_currency" => getfrom_currency($value->from_currency),
                            "to_currency" =>  getto_currency($value->to_currency),
                            "marketprice" => number_format($value->marketprice,get_currency($value->to_currency)->decimal),
                            "swapstatus" => $swapstatus,
                            "date" => date('d, M y h:i A', strtotime($value->created_at)),
                            "action" => $editswap,


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




function getsinglepairs($id){
    $result = Swap::where('id', $id)->first()->toArray();
    return $result;

}




public function swap_update(Request $request,$id){

    $id = encrypt_decrypt('decrypt',$id);
    $data['currencyResult'] = self::getActiveCurrency();
	$data['pairData'] = self::getsinglepairs($id);
    $data['js_file'] = 'swap_val';
    $data['title'] = 'Swap Pair Update';

    return view('admin.swap.edit-swap', $data);


}


public function swap_edit(Request $request){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $validator = Validator::make(request()->all(), [

            'from_currency' => 'required',
                'to_currency' => 'required',
                'min' => 'required|numeric',
                'max' => 'required|numeric',
                'fee' => 'required|numeric',
                'marketprice' => 'required|numeric',
                'fee_type' => 'required',
                'spread' => 'required|numeric',
        ], [
           'from_currency.required' => 'Select the from currency',
           'to_currency.required' => 'Select the from currency',
           'min.required' => 'Please enter your min amount',
           'max.required' => 'Please enter your max amount',
           'fee.required' => 'Please enter your fee',
           'marketprice.required' => 'Please enter your marketprice',
           'fee_type.required' => 'Select your fee type',
           'spread.required' => 'Please enter your spread',

        ]);




        // if ($validator->fails()) {
        //     return redirect()->back();
        // }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        else {
            $min = (float)request('min');
            $max = (float)request('max');
            $fromCurrency = request('from_currency');
            $toCurrency = request('to_currency');

            if ($min >= $max) {
                Session::flash('error', 'Max value must be greater than Min value');
                return redirect()->back();
            }

            if ($fromCurrency === $toCurrency) {
                    Session::flash('error', 'From currency and To currency must not be the same!');
                    return redirect()->back();
            }



        $swapid = encrypt_decrypt('decrypt',strip_tags($request['id']));

        $pairData = [
            'pair' => request('pair'),
            'from_currency' => request('from_currency'),
            'to_currency' => request('to_currency'),
            'binance_pair' => request('binance_pair'),
            'status' => request('status'),
            'min' => $min,
            'max' => $max,
            'fee' => request('fee'),
            'marketprice' => request('marketprice'),
            'fee_type' => request('fee_type'),
            'spread' => request('spread'),
        ];

}

$result =  Swap::where('id',$swapid)->update($pairData);





$admin_id = Session::get('adminId');
admin_activity($admin_id, 'Swap Update');




if ($result) {
        Session::flash('success', 'Pair has been update successfully!');
                return redirect(env('ADMIN_URL').'/swaplist/');

}

else {
    Session::flash('error', 'Pair has been updated failed!');
    return redirect(env('ADMIN_URL').'/swaplist/');

}
}
}



public function updateSwapBinancePrice()
{
    $binanceApiUrls = ['https://api.binance.com/'];
    $binanceApiUrl = $binanceApiUrls[array_rand($binanceApiUrls)];
    $binanceTickerUrl = $binanceApiUrl . 'api/v3/ticker/24hr';
    $binanceData = Http::get($binanceTickerUrl)->json();




    // echo "<pre>";
    // print_r( $binanceData);
    // die;



    $pairData = Swap::where('status', 1)->get();

    if ($pairData->count() > 0) {
        $updateData = [];

        foreach ($pairData as $pair) {
            $apiPairSymbol = $pair->binance_pair;

            $matchingBinanceData = collect($binanceData)->firstWhere('symbol', $apiPairSymbol);

            if ($matchingBinanceData) {
                $lastPrice = $matchingBinanceData['lastPrice'];
                $updateData[] = [
                    'id' => $pair->id, // Assuming 'id' is the primary key
                    'binance_marketprice' => $lastPrice,
                    'marketprice' => $lastPrice,
                ];
            }
        }

        if (!empty($updateData)) {
            foreach ($updateData as $data) {
                Swap::where('id', $data['id'])->update([
                    'binance_marketprice' => $data['binance_marketprice'],
                    'marketprice' => $data['marketprice'],
                ]);
            }
        } else {
            echo "No valid data found !!!!!";
        }
    }
}



public function swaphistory(){

    $data['js_file'] = '';
    $data['title'] = 'Swap History';

    return view('admin.swap.swaphistory', $data);

}






public function getswaphistory(Request $request){
    $draw = $request['draw'];
    $row = $request['start'];
    $rowperpage = $request['length']; // Rows display per page
    $columnIndex = $request['order'][0]['column']; // Column index
    $columnName = 'SWdFNEyNWJvmTur.id'; // Column name
    $columnSortOrder = 'DESC'; //$request['order'][0]['dir']; // asc or desc
    $searchValue = $request['search']['value']; // Search value



     ## Date search value
     $searchByFromdate = $request['searchByFromdate'];
     $searchByTodate = $request['searchByTodate'];

     ## Search Query
         $searchQuery = array();
         if($searchValue != ''){

            $statusVal = '';
            if(strtolower($searchValue) == 'pending'){
                $statusVal = 1;
            }else if(strtolower($searchValue) == 'rejected'){
                $statusVal = 2;
             } else if(strtolower($searchValue) == 'approved'){
                    $statusVal = 3;
            }else{
                $statusVal = 0;
            }

            $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or SWdFNEyNWJvmTur.pair like '%".$searchValue."%' or SWdFNEyNWJvmTur.type like '%".$searchValue."%' or SWdFNEyNWJvmTur.created_at like '%".$searchValue."%' )";

        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(SWdFNEyNWJvmTur.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = Swaphistory::count();
        // ## Total number of records with filtering
        $sel = DB::select("select count(*) as allcount FROM SWdFNEyNWJvmTur INNER JOIN UeAVBvpelsUJpczNv ON SWdFNEyNWJvmTur.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);



        $totalRecordwithFilter = $sel[0]->allcount;



        $empQuery = DB::select("select SWdFNEyNWJvmTur.*,UeAVBvpelsUJpczNv.username FROM SWdFNEyNWJvmTur INNER JOIN UeAVBvpelsUJpczNv ON SWdFNEyNWJvmTur.user_id = UeAVBvpelsUJpczNv.id " . $WHERE . " order by " . $columnName . " DESC limit " . $row . "," . $rowperpage);



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

