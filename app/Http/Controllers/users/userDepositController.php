<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Inverstment;
use DB;

class userDepositController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }


    public function levelcommison(Request $request)
    {

        $data['js_file'] = '';
        $data['title'] = 'LevelCommison';
        $data['pageTitle'] = 'LevelCommison';
        $data['subTitle'] = 'LevelCommison';

        return view('user.levelcommison.level', $data);
    }



    public function userlevelcommison(Request $request)
    {
        $userId = userId();
        $draw = $request->input('draw');
        $row = $request->input('start');
        $rowperpage = $request->input('length');
        $columnName = $request->input('columns')[$request->input('order.0.column')]['data'];
        $columnSortOrder = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');

        $searchQuery = [];

        if (!empty($searchValue)) {
            $searchQuery[] = "troRjkOEBcftDOlf.description LIKE '%" . $searchValue . "%' OR UeAVBvpelsUJpczNv.username LIKE '%" . $searchValue . "%' OR troRjkOEBcftDOlf.currency LIKE '%" . $searchValue . "%' OR troRjkOEBcftDOlf.amount LIKE '%" . $searchValue . "%' OR troRjkOEBcftDOlf.type LIKE '%" . $searchValue . "%'";
        }

        $startDate = $request->input('searchByFromdate');
        $endDate = $request->input('searchByTodate');

        if (!empty($startDate) && !empty($endDate)) {
            $searchQuery[] = "troRjkOEBcftDOlf.created_at BETWEEN '" . $startDate . " 00:00:00' AND '" . $endDate . " 23:59:59'";
        }

        $whereClause = "user_id = " . $userId;

        if (!empty($searchQuery)) {
            $whereClause .= " AND (" . implode(' OR ', $searchQuery) . ")";
        }

        $totalRecords = Transaction::where('user_id', $userId)->count();
        $sql = "
        SELECT troRjkOEBcftDOlf.*, UeAVBvpelsUJpczNv.username
        FROM troRjkOEBcftDOlf
        INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id
        WHERE troRjkOEBcftDOlf.type = 'level_commission' AND UeAVBvpelsUJpczNv.id = {$userId}
        AND {$whereClause}
        ORDER BY {$columnName} DESC
        LIMIT {$row}, {$rowperpage}";


        $empQuery = DB::select($sql);

        $data = [];
        $i = 1;

        foreach ($empQuery as $key => $value) {
            $walletstatus = ($value->wallet_status == '1')
                ? '<span class="label text-success">Moved</span>'
                : '<span class="label text-danger">Not Moved</span>';

            $data[] = [
                'id' => $i,
                'from_id' => getuserName($value->from_id),
                'currency' => $value->currency,
                'amount' => number_format($value->amount, getDecimal($value->currency)->decimal),
                'equivalent_amt' => number_format($value->equivalent_amt, 2),
                // 'equivalent_amt' => number_format($value->equivalent_amt, getDecimal($value->currency)->decimal),

                'type' => $value->type,
                'description' => $value->description,
                'wallet_status' => $walletstatus,
                'date' => date('d, M y h:i A', strtotime($value->created_at)),
            ];
            $i++;
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];

        return response()->json($response);
    }





    public function directcommisson(Request $request)
    {
        $data['js_file'] = '';
        $data['title'] = 'Directcommisson';
        $data['pageTitle'] = 'Directcommisson';
        $data['subTitle'] = 'Directcommisson';

        return view('user.levelcommison.board', $data);
    }


    public function userboardcommisson(Request $request)
    {
        $userId = userId();
        $draw = $request->input('draw');
        $row = $request->input('start');
        $rowperpage = $request->input('length');
        $columnName = $request->input('columns')[$request->input('order.0.column')]['data'];
        $columnSortOrder = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');

        $searchQuery = [];

        if (!empty($searchValue)) {
            $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%" . $searchValue . "%' or troRjkOEBcftDOlf.currency like '%" . $searchValue . "%' or troRjkOEBcftDOlf.amount like '%" . $searchValue . "%' or troRjkOEBcftDOlf.from_id like '%" . $searchValue . "%' or troRjkOEBcftDOlf.description like '%" . $searchValue . "%')";
        }

        $startDate = $request->input('searchByFromdate');
        $endDate = $request->input('searchByTodate');

        if (!empty($startDate) && !empty($endDate)) {
            $searchQuery[] = "troRjkOEBcftDOlf.created_at BETWEEN '" . $startDate . " 00:00:00' AND '" . $endDate . " 23:59:59'";
        }

        $whereClause = "user_id = " . $userId;

        if (!empty($searchQuery)) {
            $whereClause .= " AND (" . implode(' OR ', $searchQuery) . ")";
        }

        $totalRecords = Transaction::where('user_id', $userId)->count();

        $sql = "
                    SELECT troRjkOEBcftDOlf.*, UeAVBvpelsUJpczNv.username
                    FROM troRjkOEBcftDOlf
                    INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id
                    WHERE troRjkOEBcftDOlf.type = 'direct_commission' AND UeAVBvpelsUJpczNv.id = {$userId}
                    AND {$whereClause}
                    ORDER BY {$columnName} DESC
                    LIMIT {$row}, {$rowperpage}";

        $empQuery = DB::select($sql);

        $data = [];
        $i = 1;

        foreach ($empQuery as $key => $value) {
            $walletstatus = ($value->wallet_status == '1')
                ? '<span class="label text-success">Moved</span>'
                : '<span class="label text-danger">Not Moved</span>';

            $data[] = [
                'id' => $i,
                'from_id' => getuserName($value->from_id),
                'currency' => $value->currency,
                'amount' => number_format($value->amount, getDecimal($value->currency)->decimal),
                'type' => $value->type,
                'description' => $value->description,
                'wallet_status' => $walletstatus,
                // 'equivalent_amt' => $value->equivalent_amt,
                'equivalent_amt' => number_format($value->equivalent_amt, getDecimal($value->currency)->decimal),



                'date' => date('d, M y h:i A', strtotime($value->created_at)),
            ];
            $i++;
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];

        return response()->json($response);
    }







    public function roicommisson(Request $request)
    {


        $data['js_file'] = '';
        $data['title'] = 'Roi Commisson';
        $data['pageTitle'] = 'Roi Commisson';
        $data['subTitle'] = 'Roi Commisson';

        return view('user.levelcommison.roi', $data);
    }





    public function getroicommisson(Request $request)
    {
        $userId = userId();
        $draw = $request->input('draw');
        $row = $request->input('start');
        $rowperpage = $request->input('length');
        $columnName = $request->input('columns')[$request->input('order.0.column')]['data'];
        $columnSortOrder = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');

        $searchQuery = [];

        if (!empty($searchValue)) {
            $searchQuery[] = "(troRjkOEBcftDOlf.description like '%" . $searchValue . "%' or UeAVBvpelsUJpczNv.username like '%" . $searchValue . "%' or troRjkOEBcftDOlf.currency like '%" . $searchValue . "%' or troRjkOEBcftDOlf.amount like '%" . $searchValue . "%' or troRjkOEBcftDOlf.wallet_status like '%" . $searchValue . "%' or troRjkOEBcftDOlf.description like '%" . $searchValue . "%')";
        }

        $startDate = $request->input('searchByFromdate');
        $endDate = $request->input('searchByTodate');

        if (!empty($startDate) && !empty($endDate)) {
            $searchQuery[] = "troRjkOEBcftDOlf.created_at BETWEEN '" . $startDate . " 00:00:00' AND '" . $endDate . " 23:59:59'";
        }

        $whereClause = "user_id = " . $userId;


        if (!empty($searchQuery)) {
            $whereClause .= " AND (" . implode(' OR ', $searchQuery) . ")";
        }

        $totalRecords = Transaction::where('user_id', $userId)->count();

        $sql = "
                        SELECT troRjkOEBcftDOlf.*, UeAVBvpelsUJpczNv.username
                        FROM troRjkOEBcftDOlf
                        INNER JOIN UeAVBvpelsUJpczNv ON troRjkOEBcftDOlf.user_id = UeAVBvpelsUJpczNv.id
                        WHERE troRjkOEBcftDOlf.type = 'daily_interest' AND UeAVBvpelsUJpczNv.id = {$userId}
                        AND {$whereClause}
                        ORDER BY {$columnName} DESC, created_at DESC
                        LIMIT {$row}, {$rowperpage}";


        $empQuery = DB::select($sql);

        $data = [];
        $i = 1;

        foreach ($empQuery as $key => $value) {
            $walletstatus = ($value->wallet_status == '1')
                ? '<span class="label text-success">Moved</span>'
                : '<span class="label text-danger">Not Moved</span>';

            $data[] = [
                'id' => $i,
                'currency' => $value->currency,
                'amount' => number_format($value->amount, getDecimal($value->currency)->decimal),
                // 'equamt' => number_format($value->equivalent_amt, getDecimal($value->currency)->decimal),

                "equamt" => number_format($value->equivalent_amt,2),


                'description' => $value->description,
                'wallet_status' => $walletstatus,
                'date' => date('d, M y h:i A', strtotime($value->created_at)),
            ];
            $i++;
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];

        return response()->json($response);
    }




    public function userinvestment(Request $request)
    {


        $data['js_file'] = '';
        $data['title'] = 'Investment Plan';

        return view('user.levelcommison.investment', $data);
    }




    public function getuserinvestment(Request $request)
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
            $searchQuery[] = "(troRjkOEBcftDOlf.created_at between '" . $startDate . "' and '" . $endDate . "')";
        }

        $WHERE = "";
        if (count($searchQuery) > 0) {
            $WHERE = " WHERE " . implode(' and ', $searchQuery);
        }


        // ## Total number of records without filtering
        $totalRecords = Inverstment::count();

        // ## Total number of records with filtering
        $sel = DB::select("select count(*) as allcount FROM inEYqLwqRvCYkkYw INNER JOIN UeAVBvpelsUJpczNv ON inEYqLwqRvCYkkYw.user_id = UeAVBvpelsUJpczNv.id " . $WHERE);



        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;


        $empQuery = DB::select("select inEYqLwqRvCYkkYw.*,UeAVBvpelsUJpczNv.username FROM inEYqLwqRvCYkkYw INNER JOIN UeAVBvpelsUJpczNv ON inEYqLwqRvCYkkYw.user_id = UeAVBvpelsUJpczNv.id " . $WHERE . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage);




        $empQuery = DB::select("SELECT inEYqLwqRvCYkkYw.*, UeAVBvpelsUJpczNv.username
                        FROM inEYqLwqRvCYkkYw
                        INNER JOIN UeAVBvpelsUJpczNv
                        ON inEYqLwqRvCYkkYw.user_id = UeAVBvpelsUJpczNv.id
                        WHERE user_id = " . $userId . "
                        ORDER BY " . $columnName . " " . $columnSortOrder . "
                        LIMIT " . $row . "," . $rowperpage);




        $data = array();
        $i = 1;
        foreach ($empQuery as $key => $value) {
            $data[] = array(
                'id' => $i,
                "username" => $value->username,
                "plan_amount" => $value->plan_amount,
                "currency" => $value->currency,
                "date" => date('d, M y h:i A', strtotime($value->created_at)),
                "matured_date" => $value->matured_date,
                "status" => $value->status,



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
