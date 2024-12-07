<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use DataTables;
use DB;
use Session;

use App\Models\Deposit;



use Illuminate\Support\Facades\URL;


class DepositController extends Controller
{
    
    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }



    public function deposit_History(Request $request)
    {

     $data['js_file'] = 'Deposit History';
     $data['title'] = 'Deposit History';

     return view('admin.deposit.deposit-history', $data);

    }





    public function getdepositHistorydata(Request $request){


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



                $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or deXxaZzBolrXMQLG.amount like '%".$searchValue."%' or deXxaZzBolrXMQLG.address like '%".$searchValue."%' or deXxaZzBolrXMQLG.txid like '%".$searchValue."%'or deXxaZzBolrXMQLG.created_at like '%".$searchValue."%')";
            }


             // Date filter
             if($searchByFromdate != '' && $searchByTodate != ''){
                 $startDate = $searchByFromdate.' 00:00:00';
                 $endDate = $searchByTodate.' 23:59:59';
                  $searchQuery[] = "(deXxaZzBolrXMQLG.created_at between '".$startDate."' and '".$endDate."')";
             }

             $WHERE = "";
             if(count($searchQuery) > 0){
                  $WHERE = " WHERE ".implode(' and ',$searchQuery);
             }


            // ## Total number of records without filtering
            $totalRecords = Deposit::count();
            // ## Total number of records with filtering
            $sel = DB::select("select count(*) as allcount FROM deXxaZzBolrXMQLG INNER JOIN UeAVBvpelsUJpczNv ON deXxaZzBolrXMQLG.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);

            $totalRecordwithFilter = $sel[0]->allcount;

            // $empQuery = DB::select("select deXxaZzBolrXMQLG.*,UeAVBvpelsUJpczNv.username FROM deXxaZzBolrXMQLG INNER JOIN UeAVBvpelsUJpczNv ON deXxaZzBolrXMQLG.user_id = UeAVBvpelsUJpczNv.id ".$WHERE." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage);


    $empQuery = DB::select("select deXxaZzBolrXMQLG.*, UeAVBvpelsUJpczNv.username FROM deXxaZzBolrXMQLG INNER JOIN UeAVBvpelsUJpczNv ON deXxaZzBolrXMQLG.user_id = UeAVBvpelsUJpczNv.id " . $WHERE . " order by " . $columnName . " DESC limit " . $row . "," . $rowperpage);


    $data = array();
    $i = 1;
    foreach ($empQuery as $key => $value) {

        $data[] = array(
            'id' => $i,
            "username" => $value->username,
            "amount" => number_format($value->amount,8),
            "currency" => $value->currency,
            'address' => '<i class="fa fa-copy curPointer copy_tx" data-tx="' . htmlspecialchars($value->txid) . '"></i> ' . substr($value->address, 0, 5) . '...' . substr($value->address, -4),
            'txid' => '<i class="fa fa-copy curPointer copy_tx" data-tx="' . htmlspecialchars($value->txid) . '"></i> ' . substr($value->txid, 0, 5) . '...' . substr($value->txid, -4),
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


