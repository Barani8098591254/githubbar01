<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RedeemHistory;
use App\Models\TransferHistory;
use DB;
use Illuminate\Support\Facades\URL;


class InternalController extends Controller
{


public function internalredeemhistory(){

 $data['js_file'] = '';
 $data['title'] = 'Internal Redeem History';

 return view('admin.internaltransfer.internalredeemhistory', $data);

}

public function getinternalredeemhistory(Request $request)
{
    $draw = $request['draw'];
    $row = $request['start'];
    $rowperpage = $request['length'];
    $columnIndex = $request['order'][0]['column'];
    $columnName = $request['columns'][$columnIndex]['data'];
    $columnSortOrder = $request['order'][0]['dir'];
    $searchValue = $request['search']['value'];

    // Date search value
    $searchByFromdate = $request['searchByFromdate'];
    $searchByTodate = $request['searchByTodate'];

    // Search Query
    $searchQuery = [];

    if ($searchValue != '') {
        $searchQuery[] = "(RedweMSFNdgWlhGJry.symbol like '%" . $searchValue . "%' or RedweMSFNdgWlhGJry.fromUsername like '%" . $searchValue . "%' or RedweMSFNdgWlhGJry.toUsername like '%" . $searchValue . "%')";
    }

    // Date filter
    if ($searchByFromdate != '' && $searchByTodate != '') {
        $startDate = $searchByFromdate . ' 00:00:00';
        $endDate = $searchByTodate . ' 23:59:59';
        $searchQuery[] = "(RedweMSFNdgWlhGJry.created_at between '" . $startDate . "' and '" . $endDate . "')";
    }

    $WHERE = '';
    if (count($searchQuery) > 0) {
        $WHERE = ' WHERE ' . implode(' and ', $searchQuery);
    }

    // Total number of records without filtering
    $totalRecords = RedeemHistory::count();

    // Total number of records with filtering
    $sel = DB::select("select count(*) as allcount from RedweMSFNdgWlhGJry " . $WHERE);

    $totalRecordwithFilter = $sel[0]->allcount;

    $newSortOrder = ($columnSortOrder === 'asc') ? 'desc' : 'asc';

    // $empQuery = DB::select("SELECT RedweMSFNdgWlhGJry.*, UeAVBvpelsUJpczNv.username
    //     FROM RedweMSFNdgWlhGJry
    //     INNER JOIN UeAVBvpelsUJpczNv ON RedweMSFNdgWlhGJry.fromUserid = UeAVBvpelsUJpczNv.id
    //     " . $WHERE . "
    //     ORDER BY " . $columnName . " " . $newSortOrder . "
    //     LIMIT " . $row . "," . $rowperpage);




        $empQuery = DB::select("SELECT RedweMSFNdgWlhGJry.*, UeAVBvpelsUJpczNv.username, cuKZJurxYSsFaXNv.usdprice
        FROM RedweMSFNdgWlhGJry
        INNER JOIN UeAVBvpelsUJpczNv ON RedweMSFNdgWlhGJry.fromUserid = UeAVBvpelsUJpczNv.id
        INNER JOIN cuKZJurxYSsFaXNv ON RedweMSFNdgWlhGJry.currency_id = cuKZJurxYSsFaXNv.id
        " . $WHERE . "
        ORDER BY " . $columnName . " " . $newSortOrder . "
        LIMIT " . $row . "," . $rowperpage);



    $data = [];
    $i = 1;

    foreach ($empQuery as $key => $value) {
        $status = $value->status;
        $userStatusAction = '';

        switch ($status) {
            case 0:
                $userStatusAction = '<span title="Activate" class="label label-warning">Initiated</span>';
                break;
            case 1:
                $userStatusAction = '<span title="Activate" class="label label-success">Completed</span>';
                break;
            case 2:
                $userStatusAction = '<span title="Activate" class="label label-success">Completed</span>';
                break;
            default:
                $userStatusAction = '<span title="Activate" class="label label-default">Unknown</span>';
        }

        $userProfileLink = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/redeemhistory/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="User redeem" class="fa fa-eye pa-10"></i></a>';

        $usdprice = $value->toAmount * $value->usdprice;


        $data[] = [
            'id' => $i,
            "symbol" => $value->symbol,
            "username" => $value->username,
            "toUsername" => $value->toUsername,
            // "toAmount" => $value->toAmount,
            'toAmount' => number_format($value->toAmount, getDecimal($value->symbol)->decimal),
            "redeemCode" => $value->redeemCode,
            "usdprice" => $value->usdprice,
            "status" => $userStatusAction,
            "date" => date('d, M y h:i A', strtotime($value->created_at)),
            "action" => $userProfileLink,


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

    echo json_encode($response);
}





public function redeemhistory($id){

    $userId = encrypt_decrypt('decrypt',$id);


    $data['userredeem']    = Interredeemhistory::where('id',$userId)->first();

    // echo "<pre>";
    // print_r(  $data['userredeem']);
    // die;


    $data['js_file'] = 'Internal Reddem Data';
    $data['title'] = 'Internal Reddem Data';

    return view('admin.internaltransfer.viewredeem', $data);

   }



public function internalhistory(){

    $data['js_file'] = '';
    $data['title'] = 'Internal Redeem History';

    return view('admin.internaltransfer.internaltransferhistory', $data);

   }





   public function internaltransferhistory(){

    $data['js_file'] = '';
    $data['title'] = 'Internal Transfer History';

    return view('admin.internaltransfer.internaltransferhistory', $data);

   }






   public function getinternaltransferhistory(Request $request){


    $draw = $request['draw'];
    $row = $request['start'];
    $rowperpage = $request['length'];
    $columnIndex = $request['order'][0]['column'];
    $columnName = $request['columns'][$columnIndex]['data'];
    $columnSortOrder = $request['order'][0]['dir'];
    $searchValue = $request['search']['value'];

    // Date search value
    $searchByFromdate = $request['searchByFromdate'];
    $searchByTodate = $request['searchByTodate'];

    // Search Query
    $searchQuery = [];

    if ($searchValue != '') {
        $searchQuery[] = "(TrsnopjaXHTrYdCXory.symbol like '%" . $searchValue . "%' or TrsnopjaXHTrYdCXory.fromUsername like '%" . $searchValue . "%' or TrsnopjaXHTrYdCXory.toUsername like '%" . $searchValue . "%')";
    }

    // Date filter
    if ($searchByFromdate != '' && $searchByTodate != '') {
        $startDate = $searchByFromdate . ' 00:00:00';
        $endDate = $searchByTodate . ' 23:59:59';
        $searchQuery[] = "(TrsnopjaXHTrYdCXory.created_at between '" . $startDate . "' and '" . $endDate . "')";
    }

    $WHERE = '';
    if (count($searchQuery) > 0) {
        $WHERE = ' WHERE ' . implode(' and ', $searchQuery);
    }

    // Total number of records without filtering
    $totalRecords = RedeemHistory::count();

    // Total number of records with filtering
    $sel = DB::select("select count(*) as allcount from TrsnopjaXHTrYdCXory " . $WHERE);

    $totalRecordwithFilter = $sel[0]->allcount;

    $newSortOrder = ($columnSortOrder === 'asc') ? 'desc' : 'asc';

    // $empQuery = DB::select("SELECT TrsnopjaXHTrYdCXory.*, UeAVBvpelsUJpczNv.username
    //     FROM TrsnopjaXHTrYdCXory
    //     INNER JOIN UeAVBvpelsUJpczNv ON TrsnopjaXHTrYdCXory.fromUserid = UeAVBvpelsUJpczNv.id
    //     " . $WHERE . "
    //     ORDER BY " . $columnName . " " . $newSortOrder . "
    //     LIMIT " . $row . "," . $rowperpage);



        $empQuery = DB::select("SELECT TrsnopjaXHTrYdCXory.*, UeAVBvpelsUJpczNv.username, cuKZJurxYSsFaXNv.usdprice
        FROM TrsnopjaXHTrYdCXory
        INNER JOIN UeAVBvpelsUJpczNv ON TrsnopjaXHTrYdCXory.fromUserid = UeAVBvpelsUJpczNv.id
        INNER JOIN cuKZJurxYSsFaXNv ON TrsnopjaXHTrYdCXory.currency_id = cuKZJurxYSsFaXNv.id
        " . $WHERE . "
        ORDER BY " . $columnName . " " . $newSortOrder . "
        LIMIT " . $row . "," . $rowperpage);





    $data = [];
    $i = 1;

    foreach ($empQuery as $key => $value) {
        $status = $value->status;
        $userStatusAction = '';

        switch ($status) {
            case 1:
                $userStatusAction = '<span title="Activate" class="label label-warning">Initiated</span>';
                break;
            case 2:
                $userStatusAction = '<span title="Activate" class="label label-success">completed</span>';
                break;
            case 3:
                $userStatusAction = '<span title="Activate" class="label label-danger">Unknown</span>';
                break;
            default:
                $userStatusAction = '<span title="Activate" class="label label-default">Unknown</span>';
        }

        $userProfileLink = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/redeemhistory/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="User redeem" class="fa fa-eye pa-10"></i></a>';

        $usdprice = $value->toAmount * $value->usdprice;





        $data[] = [
            'id' => $i,
            "symbol" => $value->symbol,
            "username" => $value->username,
            "toUsername" => $value->toUsername,
            // "toAmount" => $value->toAmount,

            'toAmount' => number_format($value->toAmount, getDecimal($value->symbol)->decimal),


            "redeemCode" => $value->redeemCode,
            "status" => $userStatusAction,

            "usdprice" => number_format(($usdprice),2),



            "date" => date('d, M y h:i A', strtotime($value->created_at)),
            "action" => $userProfileLink,
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

    echo json_encode($response);

}
}
