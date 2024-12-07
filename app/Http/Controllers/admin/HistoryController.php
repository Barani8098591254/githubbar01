<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Inverstment;
use App\Models\Users;
use DB;
use session;
use Illuminate\Support\Facades\URL;
use App\Models\WithdrawReq;


class HistoryController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

    public function level_commission()
    {

     $data['js_file'] = 'Level Commission ';
     $data['title'] = 'Level Commission';

     return view('admin.history.level-commission-history', $data);

    }



    public function getlevelCommission(Request $request)
    {



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

            $searchQuery[] = "(troRjkOEBcftDOlf.currency like '%".$searchValue."%' or troRjkOEBcftDOlf.amount like '%".$searchValue."%' or troRjkOEBcftDOlf.txid like '%".$searchValue."%' or troRjkOEBcftDOlf.created_at like '%".$searchValue."%' or troRjkOEBcftDOlf.type like '%".$searchValue."%' or UeAVBvpelsUJpczNv.username like '%".$searchValue."%')";



        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(troRjkOEBcftDOlf.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = Transaction::count();
        // ## Total number of records with filtering
        // $sel =  DB::select("select count(*) as allcount from wrhRWuSQVNefeaEO ".$WHERE);



        // $sel = DB::select("select count(*) as allcount FROM troRjkOEBcftDOlf INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);

        $sel = DB::select("SELECT COUNT(*) AS allcount FROM troRjkOEBcftDOlf
INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id
WHERE troRjkOEBcftDOlf.type = 'level_commission'");


        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;




        $empQuery = DB::select("select troRjkOEBcftDOlf.*,UeAVBvpelsUJpczNv.username FROM troRjkOEBcftDOlf INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id ".$WHERE." order by ".$columnName." DESC limit ".$row.",".$rowperpage);

        $empQuery = DB::select("SELECT troRjkOEBcftDOlf.*, UeAVBvpelsUJpczNv.username FROM troRjkOEBcftDOlf
        INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id
        ".$WHERE." AND troRjkOEBcftDOlf.type = 'level_commission'
        ORDER BY ".$columnName." DESC LIMIT ".$row.",".$rowperpage);



        $data = array();
        $i = 1;
        foreach ($empQuery as $key => $value) {
            $type_text = '';
            if ($value->type == 'level_commission') {
                $type_text = 'Level Commission';
            } elseif ($value->type == 'admin_commission') {
                $type_text = 'Admin Commission';
            } elseif ($value->type == 'board_commission') {
                $type_text = 'Board Commission';
            } elseif ($value->type == 'board_subscribe') {
                $type_text = 'Board Subscribe';
            }
                elseif ($value->type == 'roi') {
                    $type_text = 'ROI Commission';
            }


            $wallet_status = ($value->wallet_status == 0)
            ? '<td class=" text-center"><span class="label label-danger">Not Moved</span></td>'
            : '<td class=" text-center"><span class="label label-success">Moved</span></td>';




            $data[] = array(
                'id' => $i,
                'username' => $value->username,
                'from_username' => getadminName($value->from_id),

                // 'equivalent_amt' => $value->equivalent_amt,

                'equivalent_amt' => number_format($value->equivalent_amt, getDecimal($value->currency)->decimal),

                'currency' => $value->currency,
                // 'amount' => $value->amount,
                'amount' => number_format($value->amount,getDecimal($value->currency)->decimal),
                'txid' => $value->txid,
                'wallet_status' => $wallet_status,

                'description' => $value->description,
                'date' => date('d, M y h:i A', strtotime($value->created_at)),
                'type_text' => $type_text,
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




    public function directCommission()
    {

     $data['js_file'] = '';
     $data['title'] = 'Direct Commission';

     return view('admin.history.direct-commission-history', $data);

    }



    public function getdirectCommission(Request $request)
    {



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

            $searchQuery[] = "(troRjkOEBcftDOlf.currency like '%".$searchValue."%' or troRjkOEBcftDOlf.amount like '%".$searchValue."%' or troRjkOEBcftDOlf.txid like '%".$searchValue."%' or troRjkOEBcftDOlf.created_at like '%".$searchValue."%' or troRjkOEBcftDOlf.type like '%".$searchValue."%' or UeAVBvpelsUJpczNv.username like '%".$searchValue."%')";




        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(troRjkOEBcftDOlf.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = Transaction::count();
        // ## Total number of records with filtering
        // $sel =  DB::select("select count(*) as allcount from wrhRWuSQVNefeaEO ".$WHERE);



        // $sel = DB::select("select count(*) as allcount FROM troRjkOEBcftDOlf INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);


        $sel = DB::select("SELECT COUNT(*) AS allcount FROM troRjkOEBcftDOlf
INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id
WHERE troRjkOEBcftDOlf.type = 'direct_commission'");


        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;



        $empQuery = DB::select("SELECT troRjkOEBcftDOlf.*, UeAVBvpelsUJpczNv.username FROM troRjkOEBcftDOlf
        INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id
        ".$WHERE." AND troRjkOEBcftDOlf.type = 'direct_commission'
        ORDER BY ".$columnName." DESC LIMIT ".$row.",".$rowperpage);



        $data = array();
        $i = 1;
        foreach ($empQuery as $key => $value) {
            $type_text = '';
            if ($value->type == 'level_commission') {
                $type_text = 'Level Commission';
            } elseif ($value->type == 'admin_commission') {
                $type_text = 'Admin Commission';
            } elseif ($value->type == 'board_commission') {
                $type_text = 'Board Commission';
            } elseif ($value->type == 'board_subscribe') {
                $type_text = 'Board Subscribe';
            }
                elseif ($value->type == 'roi') {
                    $type_text = 'ROI Commission';
            }


            $wallet_status = ($value->wallet_status == 0)
            ? '<td class=" text-center"><span class="label label-danger">Not Moved</span></td>'
            : '<td class=" text-center"><span class="label label-success">Moved</span></td>';





            $data[] = array(
                'id' => $i,
                'username' => $value->username,
                'from_username' => getadminName($value->from_id),


                'currency' => $value->currency,
                'equivalent_amt' => number_format($value->equivalent_amt, getDecimal($value->currency)->decimal),
                'amount' => number_format($value->amount,getDecimal($value->currency)->decimal),
                'txid' => $value->txid,
                'description' => $value->description,
                'wallet_status' => $wallet_status,

                'date' => date('d, M y h:i A', strtotime($value->created_at)),
                'type_text' => $type_text, // Add the 'type_text' column
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



    public function roiCommission()
    {

     $data['js_file'] = '';
     $data['title'] = 'ROI Commission';

     return view('admin.history.roi-commission-history', $data);

    }

    public function getroiCommission(Request $request)
    {



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

            $searchQuery[] = "(troRjkOEBcftDOlf.currency like '%".$searchValue."%' or troRjkOEBcftDOlf.amount like '%".$searchValue."%' or troRjkOEBcftDOlf.txid like '%".$searchValue."%' or troRjkOEBcftDOlf.created_at like '%".$searchValue."%' or troRjkOEBcftDOlf.type like '%".$searchValue."%' or UeAVBvpelsUJpczNv.username like '%".$searchValue."%')";



        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(troRjkOEBcftDOlf.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = Transaction::count();
        // ## Total number of records with filtering
        // $sel =  DB::select("select count(*) as allcount from wrhRWuSQVNefeaEO ".$WHERE);



        // $sel = DB::select("select count(*) as allcount FROM troRjkOEBcftDOlf INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);



        $sel = DB::select("SELECT COUNT(*) AS allcount FROM troRjkOEBcftDOlf
INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id
WHERE troRjkOEBcftDOlf.type = 'daily_interest'");


        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;


        $empQuery = DB::select("select troRjkOEBcftDOlf.*,UeAVBvpelsUJpczNv.username FROM troRjkOEBcftDOlf INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id ".$WHERE." order by ".$columnName." DESC limit ".$row.",".$rowperpage);

        $empQuery = DB::select("SELECT troRjkOEBcftDOlf.*, UeAVBvpelsUJpczNv.username FROM troRjkOEBcftDOlf
        INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id
        ".$WHERE." AND troRjkOEBcftDOlf.type = 'daily_interest'
        ORDER BY ".$columnName." DESC LIMIT ".$row.",".$rowperpage);



        $data = array();
        $i = 1;
        foreach ($empQuery as $key => $value) {
            $type_text = '';
            if ($value->type == 'level_commission') {
                $type_text = 'Level Commission';
            } elseif ($value->type == 'admin_commission') {
                $type_text = 'Admin Commission';
            } elseif ($value->type == 'board_commission') {
                $type_text = 'Board Commission';
            } elseif ($value->type == 'board_subscribe') {
                $type_text = 'Board Subscribe';
            }
                elseif ($value->type == 'daily_interest') {
                    $type_text = 'ROI Commission';
            }


            $wallet_status = ($value->wallet_status == 0)
            ? '<td class=" text-center"><span class="label label-danger">Not Moved</span></td>'
            : '<td class=" text-center"><span class="label label-success">Moved</span></td>';



            $data[] = array(
                'id' => $i,
                'username' => $value->username,
                'from_username' => getadminName($value->from_id), // Call the getuserName function for from_id
                'equivalent_amt' => number_format($value->equivalent_amt, getDecimal($value->currency)->decimal),
                'currency' => $value->currency,
                'amount' => number_format($value->amount,getDecimal($value->currency)->decimal),
                'txid' => $value->txid,
                'description' => $value->description,
                'wallet_status' => $wallet_status,
                'date' => date('d, M y h:i A', strtotime($value->created_at)),
                'type_text' => $type_text, // Add the 'type_text' column
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






    public function withdraw_view(){

        // $data['withdraw'] = DB::table('UeAVBvpelsUJpczNv')
        // ->join('wrhRWuSQVNefeaEO', 'UeAVBvpelsUJpczNv.id', '=', 'wrhRWuSQVNefeaEO.user_id')
        // ->select('UeAVBvpelsUJpczNv.*', 'wrhRWuSQVNefeaEO.currency', 'wrhRWuSQVNefeaEO.currency', 'wrhRWuSQVNefeaEO.address',  'wrhRWuSQVNefeaEO.reason', 'wrhRWuSQVNefeaEO.amount', 'wrhRWuSQVNefeaEO.recive_amount', 'wrhRWuSQVNefeaEO.fee', 'wrhRWuSQVNefeaEO.txid', 'wrhRWuSQVNefeaEO.status', 'wrhRWuSQVNefeaEO.created_at',  )
        // ->get();
     $data['js_file'] = 'withdraw_History';
     $data['title'] = 'Withdraw History';

     return view('admin.withdraw.view-withdraw', $data);

    }


    public function getwithdrawdata(Request $request){


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
            // $searchQuery[] = "(users.username like '%".$searchValue."%' or withdraw_request.currency like '%".$searchValue."%' or withdraw_request.address like '%".$searchValue."%' or withdraw_request.created_at like '%".$searchValue."%')";
            // $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or wrhRWuSQVNefeaEO.currency like '%".$searchValue."%' or wrhRWuSQVNefeaEO.address like '%".$searchValue."%' or wrhRWuSQVNefeaEO.created_at like '%".$searchValue."%')";

            $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or wrhRWuSQVNefeaEO.currency like '%".$searchValue."%' or wrhRWuSQVNefeaEO.address like '%".$searchValue."%' or wrhRWuSQVNefeaEO.created_at like '%".$searchValue."%' or wrhRWuSQVNefeaEO.recive_amount like '%".$searchValue."%' or wrhRWuSQVNefeaEO.status like '%".$searchValue."%')";



        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(wrhRWuSQVNefeaEO.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = WithdrawReq::count();
        // ## Total number of records with filtering
        // $sel =  DB::select("select count(*) as allcount from wrhRWuSQVNefeaEO ".$WHERE);


        $sel = DB::select("select count(*) as allcount FROM wrhRWuSQVNefeaEO INNER JOIN UeAVBvpelsUJpczNv ON wrhRWuSQVNefeaEO.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);



        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;




        // $empQuery = DB::select("select wrhRWuSQVNefeaEO.*,UeAVBvpelsUJpczNv.username FROM wrhRWuSQVNefeaEO INNER JOIN UeAVBvpelsUJpczNv ON wrhRWuSQVNefeaEO.user_id = UeAVBvpelsUJpczNv.id ".$WHERE." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage);


        // $empQuery = DB::select("select wrhRWuSQVNefeaEO.*, UeAVBvpelsUJpczNv.username FROM wrhRWuSQVNefeaEO INNER JOIN UeAVBvpelsUJpczNv ON wrhRWuSQVNefeaEO.user_id = UeAVBvpelsUJpczNv.id " . $WHERE . " order by " . $columnName . " DESC limit " . $row . "," . $rowperpage);


        $empQuery = DB::select("SELECT wrhRWuSQVNefeaEO.*, UeAVBvpelsUJpczNv.username
                        FROM wrhRWuSQVNefeaEO
                        INNER JOIN UeAVBvpelsUJpczNv ON wrhRWuSQVNefeaEO.user_id = UeAVBvpelsUJpczNv.id " . $WHERE .
                        " ORDER BY " . $columnName . " DESC
                        LIMIT " . $row . "," . $rowperpage);


                        $data = array();
                        $i = 1;
                        foreach ($empQuery as $key => $value) {
                            $statusLabel = "";
                            if ($value->status == 1) {
                                $statusLabel = '<span class="label label-success">Approved</span>';
                            } elseif ($value->status == 0) {
                                $statusLabel = '<span class="label label-warning">Pending</span>';
                            } else {
                                $statusLabel = '<span class="label label-danger">Rejected</span>';
                            }

                            $actionColumn = '';
                            if ($value->status == 0) {
                                // $actionColumn = '<a href="javascript:void(0)" class="label label-success approved" data-id="' . encrypt_decrypt('encrypt', $value->id) .  '" data-toggle="modal" data-target="#responsive-modal"><i title="Approved" class="fa fa-check"></i></a> &nbsp &nbsp <a href="javascript:void(0)" class="label label-danger rejected" data-id="' . encrypt_decrypt('encrypt', $value->id) . '" data-toggle="modal" data-target="#responsive1-modal"><i title="Rejected" class="fa fa-times"></i></a>';

                                $actionColumn = '<a href="javascript:void(0)" class="label label-success approved" data-id="' . encrypt_decrypt('encrypt', $value->id) .  '" data-userid="' . encrypt_decrypt('encrypt', $value->user_id) .  '" data-toggle="modal" data-target="#responsive-modal"><i title="Approved" class="fa fa-check"></i></a> &nbsp &nbsp <a href="javascript:void(0)" class="label label-danger rejected" data-id="' . encrypt_decrypt('encrypt', $value->id) . '" data-userid="' . encrypt_decrypt('encrypt', $value->user_id) . '" data-toggle="modal" data-target="#responsive1-modal"><i title="Rejected" class="fa fa-times"></i></a>';


                            } elseif ($value->status == 2) {
                                // $actionColumn = '<a href="javascript:void(0)" class="reason" data-id="' . encrypt_decrypt('encrypt', $value->id) . '" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fa fa-eye pa-10"></i></a>';


                                $actionColumn = '<a href="javascript:void(0)" class="reason" data-id="' . encrypt_decrypt('encrypt', $value->id) . '" data-reasion="'.$value->reason.'" data-userid="' . encrypt_decrypt('encrypt', $value->user_id) . '" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fa fa-eye pa-10"></i></a>';


                            }
                            else{
                                $actionColumn = '--';
                            }



                            $data[] = array(
                                'id' => $i,
                                "name"=>$value->username,
                                // "currency" => getcurrecnyname($value->currency),
                                "currency" => $value->currency,
                                // "address" => $value->address,
                                "address" => '<i class="fa fa-copy curpoint copyaddress" title="' . $value->address . '" data-id="' . $value->address . '"> ' . $value->address . '</i>',

                                // "amount" => $value->amount,
                                'amount' => number_format($value->amount, getDecimal($value->currency)->decimal),
                                "fee" => $value->fee,
                                "recive_amount" => $value->recive_amount,
                                "txId" => '<i class="fa fa-copy curPointer copyAdd" title=' . $value->txid . '" data-id="' . $value->txid . '"> ' . substr($value->txid, 0, 8) . '</i>' . '...',
                                "date" => date('d, M y h:i A', strtotime($value->created_at)),
                                "status" => $statusLabel, // Add the "status" column
                                "action" => $actionColumn, // Add the "action" column

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









    function approved_withdraw(Request $request){

        $user_id = $request->input('userId');
        $userId = encrypt_decrypt('decrypt',$user_id);

        // echo $userId;
        // die;


        $validatedData = $request->validate([
            'txId' => 'required',
            'withdrawId' => 'required',
        ], [
            'txId.required' => 'Please enter a transaction id',
        ]);

        $WithdrawId = encrypt_decrypt('decrypt', strip_tags($request['withdrawId']));


                // echo $userId;


        $checkWithdraw = WithdrawReq::where('id', $WithdrawId)->where('status', 0);

        if ($checkWithdraw->count() > 0) {
            $checkTxid = WithdrawReq::select('txid')->where('txid', trim(strip_tags($request['txId'])))->where('status', '!=', 2)->count();

            if ($checkTxid == 0) {
                $data = array('txid' => trim($request['txId']), 'status' => 1, 'updated_at' => date('Y-m-d H:i:s'));
                WithdrawReq::where('id', $checkWithdraw->first()->id)->update($data);



                $user_email = getuserEmail($userId);
                $username = getuserName($userId);


                $mailContent =  $data['txid'];

                $send = send_mail(12, strtolower($user_email), 'Withdraw approved', [
                    '###USER###' => $username,
                    '###TYPE###' => $mailContent,
                ]);



                $admin_id = Session::get('adminId');
                admin_activity($admin_id, 'Withdraw Approved');


                Session::flash('success', 'Withdraw request approved successfully.');
                return redirect()->back()->with('success', 'Withdraw request approved successfully');
            } else {
                Session::flash('error', 'Transaction id already exist !!');
                return redirect()->back()->with('error', 'Transaction id already exists !!');
            }
        } else {
            Session::flash('error', 'Invalid withdraw');
            return redirect()->back()->with('error', 'Invalid withdraw');
        }
    }





  function rejected_withdraw(Request $request){


    $user_id = $request->input('userId');
    $userId = encrypt_decrypt('decrypt',$user_id);

    // echo $userId;
    // die;


        $validatedData = $request->validate([
              'withdrawId' => 'required',
              'reason' => 'required',
          ], [
              'reason.required' => 'Please enter withdraw rejected reason',
          ]);


          $WithdrawId = encrypt_decrypt('decrypt',strip_tags($request['withdrawId']));

              $checkWithdraw = WithdrawReq::where('id',$WithdrawId)->where('status',0);

                  if($checkWithdraw->count() > 0){
                      $withdrawData = $checkWithdraw->first();

                      $getBalance     = get_balance($withdrawData->user_id, $withdrawData->currency_id);
                      $subtractAmnt   = $withdrawData->amount;
                      $updateBalance  = $getBalance + $subtractAmnt;
                      $updateBalance  = update_balance($withdrawData->user_id, $withdrawData->currency_id, $updateBalance);


                      $data = array('reason' => $request['reason'], 'status' => 2, 'recject_by' => 1,'updated_at' => date('Y-m-d H:i:s'));

                      WithdrawReq::where('id',$withdrawData->id)->update($data);



                $user_email = getuserEmail($userId);
                $username = getuserName($userId);


                $mailContent =  $data['reason'];

    $send = send_mail(13, strtolower($user_email), 'Withdraw Rejected', [
        '###USER###' => $username,
        '###TYPE###' => $mailContent,
    ]);



    $admin_id = Session::get('adminId');
    admin_activity($admin_id, 'Withdraw Rejected');



                       Session::flash('success', 'Withdraw request rejected successfully.');
                       return redirect()->back()->with('success', 'Withdraw request rejected successfully');
                  }else{
                      Session::flash('error', 'Invalid withdraw');
                      return redirect()->back()->with('error', 'Invalid withdraw');

                  }

  }




  public function withdrawpending(){


    $data['js_file'] = 'withdraw_History';
    $data['title'] = 'withdraw Pending';

 return view('admin.dashboard.pending-withdraw', $data);

}




  public function getwithdrawpending(Request $request){


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
            // $searchQuery[] = "(users.username like '%".$searchValue."%' or withdraw_request.currency like '%".$searchValue."%' or withdraw_request.address like '%".$searchValue."%' or withdraw_request.created_at like '%".$searchValue."%')";
            // $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or wrhRWuSQVNefeaEO.currency like '%".$searchValue."%' or wrhRWuSQVNefeaEO.address like '%".$searchValue."%' or wrhRWuSQVNefeaEO.created_at like '%".$searchValue."%')";

            $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or wrhRWuSQVNefeaEO.currency like '%".$searchValue."%' or wrhRWuSQVNefeaEO.address like '%".$searchValue."%' or wrhRWuSQVNefeaEO.created_at like '%".$searchValue."%' or wrhRWuSQVNefeaEO.recive_amount like '%".$searchValue."%' or wrhRWuSQVNefeaEO.status like '%".$searchValue."%')";



        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(wrhRWuSQVNefeaEO.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = WithdrawReq::count();
        // ## Total number of records with filtering
        // $sel =  DB::select("select count(*) as allcount from wrhRWuSQVNefeaEO ".$WHERE);


        $sel = DB::select("select count(*) as allcount FROM wrhRWuSQVNefeaEO INNER JOIN UeAVBvpelsUJpczNv ON wrhRWuSQVNefeaEO.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);



        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;




        // $empQuery = DB::select("select wrhRWuSQVNefeaEO.*,UeAVBvpelsUJpczNv.username FROM wrhRWuSQVNefeaEO INNER JOIN UeAVBvpelsUJpczNv ON wrhRWuSQVNefeaEO.user_id = UeAVBvpelsUJpczNv.id ".$WHERE." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage);


        // $empQuery = DB::select("select wrhRWuSQVNefeaEO.*, UeAVBvpelsUJpczNv.username FROM wrhRWuSQVNefeaEO INNER JOIN UeAVBvpelsUJpczNv ON wrhRWuSQVNefeaEO.user_id = UeAVBvpelsUJpczNv.id " . $WHERE . " order by " . $columnName . " DESC limit " . $row . "," . $rowperpage);


                        $empQuery = DB::select("SELECT wrhRWuSQVNefeaEO.*, UeAVBvpelsUJpczNv.username FROM wrhRWuSQVNefeaEO
                        INNER JOIN UeAVBvpelsUJpczNv ON wrhRWuSQVNefeaEO.user_id = UeAVBvpelsUJpczNv.id
                        ".$WHERE." AND wrhRWuSQVNefeaEO.status = 0
                        ORDER BY ".$columnName." DESC LIMIT ".$row.",".$rowperpage);





                        $data = array();
                        $i = 1;
                        foreach ($empQuery as $key => $value) {
                            $statusLabel = "";
                            if ($value->status == 1) {
                                $statusLabel = '<span class="label label-success">Approved</span>';
                            } elseif ($value->status == 0) {
                                $statusLabel = '<span class="label label-warning">Pending</span>';
                            } else {
                                $statusLabel = '<span class="label label-danger">Rejected</span>';
                            }

                            $actionColumn = '';
                            if ($value->status == 0) {
                                // $actionColumn = '<a href="javascript:void(0)" class="label label-success approved" data-id="' . encrypt_decrypt('encrypt', $value->id) .  '" data-toggle="modal" data-target="#responsive-modal"><i title="Approved" class="fa fa-check"></i></a> &nbsp &nbsp <a href="javascript:void(0)" class="label label-danger rejected" data-id="' . encrypt_decrypt('encrypt', $value->id) . '" data-toggle="modal" data-target="#responsive1-modal"><i title="Rejected" class="fa fa-times"></i></a>';

                                $actionColumn = '<a href="javascript:void(0)" class="label label-success approved" data-id="' . encrypt_decrypt('encrypt', $value->id) .  '" data-userid="' . encrypt_decrypt('encrypt', $value->user_id) .  '" data-toggle="modal" data-target="#responsive-modal"><i title="Approved" class="fa fa-check"></i></a> &nbsp &nbsp <a href="javascript:void(0)" class="label label-danger rejected" data-id="' . encrypt_decrypt('encrypt', $value->id) . '" data-userid="' . encrypt_decrypt('encrypt', $value->user_id) . '" data-toggle="modal" data-target="#responsive1-modal"><i title="Rejected" class="fa fa-times"></i></a>';


                            } elseif ($value->status == 2) {
                                // $actionColumn = '<a href="javascript:void(0)" class="reason" data-id="' . encrypt_decrypt('encrypt', $value->id) . '" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fa fa-eye pa-10"></i></a>';


                                $actionColumn = '<a href="javascript:void(0)" class="reason" data-id="' . encrypt_decrypt('encrypt', $value->id) . '" data-reasion="'.$value->reason.'" data-userid="' . encrypt_decrypt('encrypt', $value->user_id) . '" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"><i class="fa fa-eye pa-10"></i></a>';


                            }
                            else{
                                $actionColumn = '--';
                            }



                            $data[] = array(
                                'id' => $i,
                                "name"=>$value->username,
                                // "currency" => getcurrecnyname($value->currency),
                                "currency" => $value->currency,
                                "address" => '<i class="fa fa-copy curpoint copyaddress" title="' . $value->address . '" data-id="' . $value->address . '"> ' . $value->address . '</i>',

                                // "amount" => $value->amount,
                                'amount' => number_format($value->amount,getDecimal($value->currency)->decimal),
                                "fee" => $value->fee,
                                "recive_amount" => $value->recive_amount,
                                "txId" => '<i class="fa fa-copy curPointer copyAdd" title=' . $value->txid . '" data-id="' . $value->txid . '"> ' . substr($value->txid, 0, 8) . '</i>' . '...',
                                "date" => date('d, M y h:i A', strtotime($value->created_at)),
                                "status" => $statusLabel, // Add the "status" column
                                "action" => $actionColumn, // Add the "action" column

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






  public function roi(){

   $data['js_file'] = 'ROI History';
   $data['title'] = 'ROI History';

   return view('admin.history.roi-history', $data);

  }




  public function pairCommission(){

    $data['js_file'] = 'Pair_History';
    $data['title'] = 'Pair History';

    return view('admin.history.pair-commission-history', $data);
  }





  public function getpaircommission(Request $request){



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

            $searchQuery[] = "(troRjkOEBcftDOlf.currency like '%".$searchValue."%' or troRjkOEBcftDOlf.amount like '%".$searchValue."%' or troRjkOEBcftDOlf.txid like '%".$searchValue."%' or troRjkOEBcftDOlf.created_at like '%".$searchValue."%' or troRjkOEBcftDOlf.type like '%".$searchValue."%' or UeAVBvpelsUJpczNv.username like '%".$searchValue."%')";



        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(troRjkOEBcftDOlf.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = Transaction::count();
        // ## Total number of records with filtering
        // $sel =  DB::select("select count(*) as allcount from wrhRWuSQVNefeaEO ".$WHERE);



        // $sel = DB::select("select count(*) as allcount FROM troRjkOEBcftDOlf INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);



        $sel = DB::select("SELECT COUNT(*) AS allcount FROM troRjkOEBcftDOlf
INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id
WHERE troRjkOEBcftDOlf.type = 'pair_commission'");


        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;


        $empQuery = DB::select("select troRjkOEBcftDOlf.*,UeAVBvpelsUJpczNv.username FROM troRjkOEBcftDOlf INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id ".$WHERE." order by ".$columnName." DESC limit ".$row.",".$rowperpage);

        $empQuery = DB::select("SELECT troRjkOEBcftDOlf.*, UeAVBvpelsUJpczNv.username FROM troRjkOEBcftDOlf
        INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id
        ".$WHERE." AND troRjkOEBcftDOlf.type = 'pair_commission'
        ORDER BY ".$columnName." DESC LIMIT ".$row.",".$rowperpage);



        $data = array();
        $i = 1;
        foreach ($empQuery as $key => $value) {
            $type_text = '';
            if ($value->type == 'level_commission') {
                $type_text = 'Level Commission';
            } elseif ($value->type == 'admin_commission') {
                $type_text = 'Admin Commission';
            } elseif ($value->type == 'board_commission') {
                $type_text = 'Board Commission';
            } elseif ($value->type == 'board_subscribe') {
                $type_text = 'Board Subscribe';
            }
                elseif ($value->type == 'daily_interest') {
                    $type_text = 'ROI Commission';
            }


            $wallet_status = ($value->wallet_status == 0)
            ? '<td class=" text-center"><span class="label label-danger">Not Moved</span></td>'
            : '<td class=" text-center"><span class="label label-success">Moved</span></td>';



            $data[] = array(
                'id' => $i,
                'username' => $value->username,
                'from_username' => getadminName($value->from_id), // Call the getuserName function for from_id
                // 'equivalent_amt' => number_format($value->equivalent_amt, getDecimal($value->currency)->decimal),
                'currency' => $value->currency,
                // 'amount' => number_format($value->amount),
                'amount' => number_format($value->amount,getDecimal($value->currency)->decimal),

                'txid' => $value->txid,
                'description' => $value->description,
                'wallet_status' => $wallet_status,
                'date' => date('d, M y h:i A', strtotime($value->created_at)),
                'type_text' => $type_text, // Add the 'type_text' column
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








public function investment(){


 $data['js_file'] = '';
 $data['title'] = 'Investment History';

 return view('admin.investment.investment-view', $data);

}


public function getinvestment(Request $request){


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
        // $searchQuery[] = "(users.username like '%".$searchValue."%' or withdraw_request.currency like '%".$searchValue."%' or withdraw_request.address like '%".$searchValue."%' or withdraw_request.created_at like '%".$searchValue."%')";
        // $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or wrhRWuSQVNefeaEO.currency like '%".$searchValue."%' or wrhRWuSQVNefeaEO.address like '%".$searchValue."%' or wrhRWuSQVNefeaEO.created_at like '%".$searchValue."%')";

        $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or inEYqLwqRvCYkkYw.currency like '%".$searchValue."%' or inEYqLwqRvCYkkYw.plan_amount like '%".$searchValue."%' or inEYqLwqRvCYkkYw.created_at like '%".$searchValue."%' or inEYqLwqRvCYkkYw.plan_id like '%".$searchValue."%' or inEYqLwqRvCYkkYw.status like '%".$searchValue."%')";



    }


     // Date filter
     if($searchByFromdate != '' && $searchByTodate != ''){
         $startDate = $searchByFromdate.' 00:00:00';
         $endDate = $searchByTodate.' 23:59:59';
          $searchQuery[] = "(inEYqLwqRvCYkkYw.created_at between '".$startDate."' and '".$endDate."')";
     }

     $WHERE = "";
     if(count($searchQuery) > 0){
          $WHERE = " WHERE ".implode(' and ',$searchQuery);
     }


    // ## Total number of records without filtering
    $totalRecords = Inverstment::count();
    // ## Total number of records with filtering
    // $sel =  DB::select("select count(*) as allcount from wrhRWuSQVNefeaEO ".$WHERE);


    $sel = DB::select("select count(*) as allcount FROM inEYqLwqRvCYkkYw INNER JOIN UeAVBvpelsUJpczNv ON inEYqLwqRvCYkkYw.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);



    // $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $sel[0]->allcount;


    $orderByClause = $columnName . " DESC";

    $empQuery = DB::select("select inEYqLwqRvCYkkYw.*,UeAVBvpelsUJpczNv.username FROM inEYqLwqRvCYkkYw INNER JOIN UeAVBvpelsUJpczNv ON inEYqLwqRvCYkkYw.user_id = UeAVBvpelsUJpczNv.id " . $WHERE . " order by " . $orderByClause . " limit " . $row . "," . $rowperpage);


                    $data = array();
                    $i = 1;
                    foreach ($empQuery as $key => $value) {

                        $verifyLabel = ($value->status == '1')
                        ? '<span title="Activate" class="label label-success">Active</span>'
                        : '<span title="Deactivate" class="label label-danger">cancel</span>';


                        $editcur = '';
                        if ($value->status == 1) {
                            // $actionColumn = '<a href="javascript:void()" onclick="return confirmtwithdrawChange(\'cancelinvestment/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="label label-success"></i></a>';


                            $actionColumn = '<a class="label label-danger" href="javascript:void()" onclick="return confirmtwithdrawChange(\'cancelinvestment/' . encrypt_decrypt('encrypt',$value->id) .  '\', \'Cancel\')"><i title="Rejected" class="fa fa-times"></i></a>';


                        } elseif ($value->status == 2) {
                            $actionColumn = '----';


                        }
                        else{
                            $actionColumn = '--';
                        }







                        $data[] = array(
                            'id' => $i,
                            "username"=>$value->username,
                            // "plan_amount" => $value->plan_amount,
                            'plan_amount' => number_format($value->plan_amount,getDecimal($value->currency)->decimal),
                            "plan_id" => getplanname($value->plan_id),
                            "currency" => $value->currency,
                            "equivalentAmt" => $value->equivalentAmt,
                            "status" => $value->status,
                            "date" => date('d, M y h:i A', strtotime($value->created_at)),
                            "matured_date" => date('d, M y h:i A', strtotime($value->matured_date)),
                            "status" => $verifyLabel,
                             "cancel" => $actionColumn

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



public function cancel_investment(Request $request, $id) {


    $queryString = encrypt_decrypt('decrypt', $id);

    if ($queryString) {
        $planData = Inverstment::where('id', $queryString);

        if ($planData->count() > 0) {
            $planData = $planData->first();
            $user_id = $planData->user_id;
            $userEmail = getuserEmail($planData->user_id);
            $userName = getuserName($planData->user_id);

            $update = Inverstment::where('id', $queryString)
                ->update(['cancel_date' => now(), 'status' => 2]);

            if ($update) {
                $description = 'Principal amount returned';
                $txnId = 'PAR' . now()->format('ymdhis');
                $processingFee = $planData->plan_amount * 5 / 100;
                $finalAmount = $planData->plan_amount - $processingFee;

                $data = [
                    'user_id' => $user_id, // Assuming userId is correct
                    'amount' => $finalAmount,
                    'plan_id' => $planData->id,
                    'currency' => $planData->currency,
                    'description' => $description,
                    'txid' => $txnId,
                    'from_id' => 0,
                    'type' => 'principle_return',
                    'wallet_status' => 1,
                    'hold_status' => 1,
                    'created_at' => now(),
                ];

                $insert = Transaction::insert($data); // Assuming Transaction model exists

                if ($insert) {
                    $currencyData = get_currencySymbol($planData->currency); // Replace with your function
                    $currencyId = $currencyData;
                    $beforeBalance = get_balance($user_id, $currencyId); // Replace with your function
                    $updatedAmount = $beforeBalance + $finalAmount;
                    $updateBalance = update_balance($user_id, $currencyId, $updatedAmount); // Replace with your function
                }

                $planInfo = unserialize($planData->plan_info);

                $mailContent = [
                    '###USER###' => $userName,
                    '###PLAN###' => $planInfo['name'],
                    '###AMOUNT###' => $planData->plan_amount,
                    '###RETURNAMOUNT###' => $finalAmount,
                    '###CURRENCY###' => $planData->currency,
                    '###PROCESSINGFEE###' => '5%',
                ];

                $send = send_mail(16, $userEmail, 'Investment Cancelled', $mailContent); // Replace with your mail function

                Session::flash('success', 'Investment Cancelled Successfully.');
                return redirect(env('ADMIN_URL') . '/investment');
            } else {
                Session::flash('error', 'Invalid associate trade details.');
                return redirect(env('ADMIN_URL') . '/investment');
            }
        } else {
            Session::flash('error', 'Invalid associate trade details.');
            return redirect(env('ADMIN_URL') . '/investment');
        }
    } else {
        Session::flash('error', 'Invalid associate trade details.');
        return redirect(env('ADMIN_URL') . '/investment');
    }
}





}
