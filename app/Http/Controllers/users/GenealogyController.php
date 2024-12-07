<?php

namespace App\Http\Controllers\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use DB;
use Session;

class GenealogyController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

    public function genealogy()
    {


        $user_id = session('userId');
        $_SESSION['getTreedata'] = '';
        $_SESSION['userTreeData'] = '';



		self::treeDetails($user_id, 0, '');
        $data['treeData'] = $_SESSION['userTreeData'];



        $data['title'] = 'Genealogy';
        $data['js_file'] = '';
        $data['pageTitle'] = 'genealogy';
        $data['subTitle'] = 'genealogy';
        return view('user/genealogy/genealogy', $data);
    }



public function treeDetails($userId, $level)
{

    $i = 0;
    $userData = Users::find($userId);


    if ($userData) {
        $username = $userData->username;
        $referralId = $userData->referralId;
        $referrerId = $userData->referrerId;

        $uplineData = Users::select('username')->where('referralId', $referrerId)->first();


        $uplineName = $uplineData ? $uplineData->username : '';


        if(userId() == $userId)
        $uplineName = '';

        $_SESSION['userTreeData'].= "['".$username."', '".$uplineName."', '".$referralId."'],";


        $result = Users::where('referrerId', $referralId)->get()->toArray();



        $_SESSION['getTreedata'].= $userId.",";



        if($result) {
            foreach($result as $key => $row) {
                $level ++;
                $referID = $row['id'];
                self::treeDetails($referID, $level);
            }
        }

    }
}

   public function downline(){



        $data['js_file'] = 'downline';
        $data['title'] = 'Downline';
        $data['pageTitle'] = 'My Downline';
        $data['subTitle'] = 'Downline';
        return view("user.Affiliate.downline",$data);
    }


     // $user_id = session('userId');

     //    $_SESSION['userTreeData'] = '';
     //     $_SESSION['getTreedata'] = '';
     //    self::treeDetails($user_id, 0, '');
     //    $data['treeData'] = $_SESSION['getTreedata'];
     //    $res = explode(",",$data['treeData']);
     //    $arrayFilter = array_filter($res);


    // myDownline
    public function myDownline(Request $request){
        $userId = userId();
        $draw = $request->input('draw');
        $row = $request->input('start');
        $rowperpage = $request->input('length');
        $columnIndex = $request->input('order.0.column');
        $columnName = 'id'; // You should specify the actual column name
        $columnSortOrder = 'desc'; // Specify sorting order (asc or desc)
        $searchValue = $request->input('search.value');

        // Date search values
        $searchByFromdate = $request->input('searchByFromdate');
        $searchByTodate = $request->input('searchByTodate');

        // Initialize a search query array
        $searchQuery = [];

        // If there is a search value, add it to the search query
        if (!empty($searchValue)) {
            $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%" . $searchValue . "%' or UeAVBvpelsUJpczNv.referralId like '%" . $searchValue . "%')";
        }

        // Date filter
        if (!empty($searchByFromdate) && !empty($searchByTodate)) {
            $startDate = $searchByFromdate . ' 00:00:00';
            $endDate = $searchByTodate . ' 23:59:59';
            $searchQuery[] = "(UeAVBvpelsUJpczNv.created_at between '" . $startDate . "' and '" . $endDate . "')";
        }

        // Define the WHERE clause
        $_SESSION['userTreeData'] = '';
        $_SESSION['getTreedata'] = '';
        self::treeDetails($userId, 0, '');
        $data['treeData'] = $_SESSION['getTreedata'];
        $res = explode(",", $data['treeData']);
        $arrayFilter = array_filter($res);
        $implode = implode(",", $arrayFilter);

        $referralId = $arrayFilter;
        $active = $userId;

        // Initialize the WHERE clause
        $WHERES = "id != " . $active;

        // If there are additional search conditions, add them to the WHERE clause
        if (!empty($searchQuery)) {
            $WHERES .= " AND " . implode(" and ", $searchQuery);
        }

        // Construct the final SQL query
        $sqlQuery = "SELECT * FROM UeAVBvpelsUJpczNv WHERE id IN ($implode)";

        if (!empty($WHERES)) {
            $sqlQuery .= " AND $WHERES";
        }

        $sqlQuery .= " ORDER BY $columnName $columnSortOrder LIMIT $row, $rowperpage";

        // Get the filtered record count directly from the query
        $totalRecords = count(DB::select($sqlQuery));

        $empQuery = DB::select($sqlQuery);

        $data = [];
        $i = $row + 1;

        foreach ($empQuery as $key => $value) {
            $status = ($value->is_active == 1) ? '<span class="label text-success">Active </span>' : '<span class="label text-danger">Deactive </span>';

            $data[] = [
                'id' => $i,
                "userId" => getuserName($value->id),
                'referralId' => $value->referralId,
                'level' => $value->level_no,
                'status' => $status, // Use the calculated $status here
                "date" => date('d, M y h:i A', strtotime($value->created_at)),
            ];
            $i++;
        }

        // Prepare the response
        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords, // Use the same count for filtered records
            "aaData" => $data
        ];

        return response()->json($response);
    }



}
