<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\kyc;
use App\Models\Currency;
use App\Models\UserAddress;
use DB;
use Session;

use Illuminate\Support\Facades\URL;



class AdminuserController extends Controller
{


    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

   public function users_list(){

    // $data['users'] = Users::select('id', 'username', 'email', 'mobile_no', 'referralId', 'referrerId', 'is_active','is_verify')->get();

    $data['js_file'] = 'admin';
    $data['title'] = 'User List';

    return view('admin.user.user-list', $data);
}



public function getuserslist(Request $request){


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
            $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or UeAVBvpelsUJpczNv.email like '%".encrypt_decrypt('encrypt',$searchValue)."%' or UeAVBvpelsUJpczNv.created_at like '%".$searchValue."%' or UeAVBvpelsUJpczNv.mobile_no like '%".$searchValue."%')";
        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(UeAVBvpelsUJpczNv.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = Users::count();
        // ## Total number of records with filtering
        $sel =  DB::select("select count(*) as allcount from UeAVBvpelsUJpczNv ".$WHERE);

        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;

        // $empQuery = DB::select("select AAlbCeRQCyyKtmzya.*,AnbopVhAvWSumu.name FROM AAlbCeRQCyyKtmzya INNER JOIN AnbopVhAvWSumu ON AAlbCeRQCyyKtmzya.adminId = AnbopVhAvWSumu.id ".$WHERE." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage);
        // $empQuery = DB::select("SELECT * FROM UeAVBvpelsUJpczNv $WHERE
        //                 ORDER BY $columnName $columnSortOrder
        //                 LIMIT $row, $rowperpage");


        $newSortOrder = ($columnSortOrder === 'asc') ? 'desc' : 'asc';
        $empQuery = DB::select("SELECT * FROM UeAVBvpelsUJpczNv $WHERE
                        ORDER BY $columnName $newSortOrder
                        LIMIT $row, $rowperpage");


                                $data = array();
                    $i = 1;
                    foreach ($empQuery as $key => $value) {
                        $verifyLabel = ($value->is_verify == '1')
                            ? '<span title="Activate" class="label label-success">Activated</span>'
                            : '<span title="Deactivate" class="label label-danger">Deactivated</span>';


                            $userStatusAction = ($value->is_active == 1)
                            ? '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'user-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-success"></i></a>'
                            : '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'user-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\')"><i class="ti-lock text-danger"></i></a>';


                            $usertfa = ($value->tfaStatus == 1)
                            ? '<a href="javascript:void()" onclick="return confirmtfaChange(\'updatetfa/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-success"></i></a>'
                            : '<a href="javascript:void()" onclick="return confirmtfaChange(\'updatetfa/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\' disabled)"><i class="ti-lock text-danger"></i></a>';


                            $userwithdrawstatus = ($value->withdraw_status == 1)
                            ? '<a href="javascript:void()" onclick="return confirmtwithdrawChange(\'updatewithdraw/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-success"></i></a>'
                            : '<a href="javascript:void()" onclick="return confirmtwithdrawChange(\'updatewithdraw/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\')"><i class="ti-lock text-danger"></i></a>';





                            $userProfileLink = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/Profile/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="User Profile" class="fa fa-eye pa-10"></i></a>';



                            $userTree = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/genealogy/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="User genealogy" class="fa fa-tree pa-10"></i></a>';



                            $resendLink = ($value->is_verify == '0')
                            ? '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/resend/' . $value->id . '" class=""><i title="Resend" class="fa fa-repeat pa-10"></i></a>'
                            : '';




                        $data[] = array(
                            'id' => $key + 1,
                            "username" => $value->username,
                            "email" => encrypt_decrypt('decrypt', $value->email),
                            "mobile_no" => $value->mobile_no,
                            "is_verify" => $verifyLabel,
                            "is_active" => $userStatusAction,
                            "tfaStatus" => $usertfa,
                            "withdraw_status" => $userwithdrawstatus,
                            "date" => date('d, M y h:i A', strtotime($value->created_at)),
                            "action" => $userProfileLink. ' ' . $userTree. ' '. $resendLink,


                        );
                        $i++;
                        // $i = $key + 1;

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





public function user_status($id){

    $userCheck = Users::where('id',encrypt_decrypt('decrypt',$id));

    if($userCheck->count() > 0){
        $user = $userCheck->first();

        if($user->is_verify == 0){
             return back()->with("error", "User Account Not Activated");
        }

        $status = ($user->is_active == 1) ? 0 : 1;
         Users::where('id',$user->id)->update(['is_active' => $status]);

        if($status == 1){
            return back()->with("success", "User status active successfully");
        }else{
            return back()->with("success", "User status deactive successfully");

        }
    }else{
            return back()->with("error", "Invalid Users");
    }

}




public function updatetfa(Request $request, $id)
{

    $userId = encrypt_decrypt('decrypt', $id);

    $user = Users::find($userId);



    if ($user) {
        $user->update([
            'tfaStatus' => !$user->tfaStatus,
            'randcode' => null,
        ]);

        session()->flash('success', 'TFA status updated successfully');
        return redirect()->back();

    } else {
        session()->flash('error', 'User not found.');
        return redirect()->back();

    }
}





public function updatewithdraw($id){

    $userCheck = Users::where('id',encrypt_decrypt('decrypt',$id));

    if($userCheck->count() > 0){
        $user = $userCheck->first();

        if($user->is_verify == 0){
             return back()->with("error", "User Account Not Activated");
        }

        $status = ($user->withdraw_status == 1) ? 0 : 1;
         Users::where('id',$user->id)->update(['withdraw_status' => $status]);

        if($status == 1){
            return back()->with("success", "Withdraw status has update successfullt");
        }else{
            return back()->with("success", "Withdraw  status deactive successfully");

        }
    }else{
            return back()->with("error", "Invalid Users");
    }

}




    public function resendMail($id) {
         $resendid =  $id;
        $user = DB::table('UeAVBvpelsUJpczNv')->select('is_verify','email', 'username', 'id', 'activationCode', 'is_active', 'lastSentTime')->where('id', $resendid)->where('is_verify', 0)->first();

        if (!$user) {
         session()->flash('error', 'User invalid!');
         return redirect()->back();
         }

         $activation_code = $user->is_verify;
         if ($activation_code == 1) {
         session()->flash('error', 'User has already been verified!');
         return redirect()->back();
        }

        $username = $user->username;
        $resendid = $user->id;
        $email = encrypt_decrypt('decrypt',$user->email);
        $activation_code = $user->activationCode;
        $lastSentTime = $user->lastSentTime;

        $lowTime = strtotime($lastSentTime) + (3 * 60);
        $currentTime = time();

         if ($currentTime < $lowTime) {
         $remainingTime = $lowTime - $currentTime;
         $remainingTimes = gmdate("i:s", $remainingTime);

         Session::flash('error', 'Already mail sent. Please wait and Tty again after ' . $remainingTimes . ' minutes');
         return redirect()->back();
         }

        $link = url('accountActivate') . '/' . $activation_code;

        $send = send_mail(1, strtolower($email), 'Registration', [
        '###USER###' => $username,
       '###LINK###' => $link,
       '###registerverify_link###' => $link
      ]);
       if ($send) {
        DB::table('UeAVBvpelsUJpczNv')->where('id', $resendid)->update(['lastSentTime' => date('Y-m-d H:i:s')]);
        session()->flash('success', 'User resend activation mail sent successfully!');
         return redirect()->back();
        } else {
        session()->flash('error', 'Failed to send activation email. please try again later.');
        return redirect()->back();
        }


    }






   public function getuserActivity(Request $request){
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
            $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or UatMuXaJtDhDLqIe.activity like '%".$searchValue."%' or UatMuXaJtDhDLqIe.created_at like '%".$searchValue."%' or UatMuXaJtDhDLqIe.ip like '%".$searchValue."%')";
        }

         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(UatMuXaJtDhDLqIe.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = Adminactivity::count();
        // ## Total number of records with filtering
        $sel =  DB::select("select count(*) as allcount from AAlbCeRQCyyKtmzya ".$WHERE);



        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;

        // $empQuery = DB::select("select AAlbCeRQCyyKtmzya.*,AnbopVhAvWSumu.name FROM AAlbCeRQCyyKtmzya INNER JOIN AnbopVhAvWSumu ON AAlbCeRQCyyKtmzya.adminId = AnbopVhAvWSumu.id ".$WHERE." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage);



        $newSortOrder = ($columnSortOrder === 'asc') ? 'desc' : 'asc';

$empQuery = DB::select("SELECT AAlbCeRQCyyKtmzya.*, AnbopVhAvWSumu.name FROM AAlbCeRQCyyKtmzya INNER JOIN AnbopVhAvWSumu ON AAlbCeRQCyyKtmzya.adminId = AnbopVhAvWSumu.id $WHERE
                        ORDER BY $columnName $newSortOrder
                        LIMIT $row, $rowperpage");

            $data = array();
            $i = 1;
            foreach ($empQuery as $key => $value) {
                $data[] = array(
                    'id' => $i,
                    "username"=>$value->name,
                    "activity"=>$value->activity,
                    "ip"=>$value->ip,
                    "browser"=>$value->browser,
                    "os"=>$value->os,
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





    public function activeuser(){


        $data['js_file'] = 'admin';
        $data['title'] = 'Active User List';

        return view('admin.dashboard.active-user-list', $data);
    }



public function getActiveuser(Request $request){

    $draw = $request['draw'];
    $row = $request['start'];
    $rowperpage = $request['length']; // Rows displayed per page
    $columnIndex = $request['order'][0]['column']; // Column index
    $columnName = $request['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $request['order'][0]['dir']; // Sorting order: asc or desc
    $searchValue = $request['search']['value']; // Search value

    // Date search value
    $searchByFromdate = $request['searchByFromdate'];
    $searchByTodate = $request['searchByTodate'];

    // Search Query
    $searchQuery = [];
    if ($searchValue != '') {
        $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%" . $searchValue . "%' or UeAVBvpelsUJpczNv.email like '%" . encrypt_decrypt('encrypt', $searchValue) . "%' or UeAVBvpelsUJpczNv.created_at like '%" . $searchValue . "%' or UeAVBvpelsUJpczNv.mobile_no like '%" . $searchValue . "%')";
    }

    // Date filter
    if ($searchByFromdate != '' && $searchByTodate != '') {
        $startDate = $searchByFromdate . ' 00:00:00';
        $endDate = $searchByTodate . ' 23:59:59';
        $searchQuery[] = "(UeAVBvpelsUJpczNv.created_at between '" . $startDate . "' and '" . $endDate . "')";
    }

    $WHERE = "";
    if (count($searchQuery) > 0) {
        $WHERE = " AND " . implode(' and ', $searchQuery);
    }

    // Total number of records without filtering
    $totalRecords = Users::count();

    // Total number of records with filtering
    $sqlQuery = "SELECT COUNT(*) AS allcount FROM UeAVBvpelsUJpczNv WHERE is_active = 1 $WHERE";

    $sel = DB::select($sqlQuery);

    $totalRecordwithFilter = $sel[0]->allcount;

    // Build the SQL query with a proper ORDER BY clause
    $sqlQuery = "SELECT UeAVBvpelsUJpczNv.* FROM UeAVBvpelsUJpczNv WHERE is_active = 1 $WHERE";
    if (!empty($columnName)) {
        $sqlQuery .= " ORDER BY $columnName $columnSortOrder";
    }
    $sqlQuery .= " LIMIT $rowperpage OFFSET $row";

    $empQuery = DB::select($sqlQuery);


    // dd( $empQuery );die;


                    $data = array();
                    $i = 1;
                    foreach ($empQuery as $key => $value) {
                        $verifyLabel = ($value->is_verify == '1')
                            ? '<span title="Activate" class="label label-success">Activated</span>'
                            : '<span title="Deactivate" class="label label-danger">Deactivated</span>';


                            $userStatusAction = ($value->is_active == 1)
                            ? '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'user-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-success"></i></a>'
                            : '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'user-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\')"><i class="ti-lock text-danger"></i></a>';


                            $usertfa = ($value->tfaStatus == 1)
                            ? '<a href="javascript:void()" onclick="return confirmtfaChange(\'updatetfa/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-success"></i></a>'
                            : '<a href="javascript:void()" onclick="return confirmtfaChange(\'updatetfa/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\' disabled)"><i class="ti-lock text-danger"></i></a>';



                            $userProfileLink = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/Profile/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="User Profile" class="fa fa-eye pa-10"></i></a>';

                            $userTree = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/genealogy/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="User genealogy" class="fa fa-tree pa-10"></i></a>';

                            $resendLink = ($value->is_verify == '0')
                            ? '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/resend/' . $value->id . '" class=""><i title="Resend" class="fa fa-repeat pa-10"></i></a>'
                            : '';


                        $data[] = array(
                            'id' => $i,
                            "username" => $value->username,
                            "email" => encrypt_decrypt('decrypt', $value->email),
                            "mobile_no" => $value->mobile_no,
                            "is_verify" => $verifyLabel,
                            "is_active" => $userStatusAction,
                            "tfaStatus" => $usertfa,
                            "date" => date('d, M y h:i A', strtotime($value->created_at)),
                            "action" => $userProfileLink. ' ' . $userTree. ' '. $resendLink,


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






public function inactiveuser(){


    $data['js_file'] = 'admin';
    $data['title'] = 'Inactive User List';

    return view('admin.dashboard.inactive-user-list', $data);
}





public function getinactiveuser(Request $request) {

    $draw = $request['draw'];
    $row = $request['start'];
    $rowperpage = $request['length']; // Rows displayed per page
    $columnIndex = $request['order'][0]['column']; // Column index
    $columnName = $request['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $request['order'][0]['dir']; // Sorting order: asc or desc
    $searchValue = $request['search']['value']; // Search value

    // Date search value
    $searchByFromdate = $request['searchByFromdate'];
    $searchByTodate = $request['searchByTodate'];

    // Search Query
    $searchQuery = [];
    if ($searchValue != '') {
        $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%" . $searchValue . "%' or UeAVBvpelsUJpczNv.email like '%" . encrypt_decrypt('encrypt', $searchValue) . "%' or UeAVBvpelsUJpczNv.created_at like '%" . $searchValue . "%' or UeAVBvpelsUJpczNv.mobile_no like '%" . $searchValue . "%')";
    }

    // Date filter
    if ($searchByFromdate != '' && $searchByTodate != '') {
        $startDate = $searchByFromdate . ' 00:00:00';
        $endDate = $searchByTodate . ' 23:59:59';
        $searchQuery[] = "(UeAVBvpelsUJpczNv.created_at between '" . $startDate . "' and '" . $endDate . "')";
    }

    $WHERE = "";
    if (count($searchQuery) > 0) {
        $WHERE = " AND " . implode(' and ', $searchQuery);
    }

    // Total number of records without filtering
    $totalRecords = Users::count();

    // Total number of records with filtering
    $sqlQuery = "SELECT COUNT(*) AS allcount FROM UeAVBvpelsUJpczNv WHERE is_active = 0 $WHERE";

    $sel = DB::select($sqlQuery);

    $totalRecordwithFilter = $sel[0]->allcount;

    // Build the SQL query with a proper ORDER BY clause
    $sqlQuery = "SELECT UeAVBvpelsUJpczNv.* FROM UeAVBvpelsUJpczNv WHERE is_active = 0 $WHERE";
    if (!empty($columnName)) {
        $sqlQuery .= " ORDER BY $columnName $columnSortOrder";
    }
    $sqlQuery .= " LIMIT $rowperpage OFFSET $row";

    $empQuery = DB::select($sqlQuery);


    // dd( $empQuery );die;


                    $data = array();
                    $i = 1;
                    foreach ($empQuery as $key => $value) {
                        $verifyLabel = ($value->is_verify == '1')
                            ? '<span title="Activate" class="label label-success">Activated</span>'
                            : '<span title="Deactivate" class="label label-danger">Deactivated</span>';


                            $userStatusAction = ($value->is_active == 1)
                            ? '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'user-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-success"></i></a>'
                            : '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'user-status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\')"><i class="ti-lock text-danger"></i></a>';


                            $usertfa = ($value->tfaStatus == 1)
                            ? '<a href="javascript:void()" onclick="return confirmtfaChange(\'updatetfa/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-success"></i></a>'
                            : '<a href="javascript:void()" onclick="return confirmtfaChange(\'updatetfa/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\' disabled)"><i class="ti-lock text-danger"></i></a>';



                            $userProfileLink = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/Profile/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="User Profile" class="fa fa-eye pa-10"></i></a>';

                            $userTree = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/genealogy/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="User genealogy" class="fa fa-tree pa-10"></i></a>';

                            $resendLink = ($value->is_verify == '0')
                            ? '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/resend/' . $value->id . '" class=""><i title="Resend" class="fa fa-repeat pa-10"></i></a>'
                            : '';


                        $data[] = array(
                            'id' => $i,
                            "username" => $value->username,
                            "email" => encrypt_decrypt('decrypt', $value->email),
                            "mobile_no" => $value->mobile_no,
                            "is_verify" => $verifyLabel,
                            "is_active" => $userStatusAction,
                            "tfaStatus" => $usertfa,
                            "date" => date('d, M y h:i A', strtotime($value->created_at)),
                            "action" => $userProfileLink. ' ' . $userTree. ' '. $resendLink,


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




   public function view_user($userId){

    $userId = encrypt_decrypt('decrypt',$userId);
    $data['userDetails']    = Users::where('id',$userId)->first();
    $data['userBalance']    = Currency::orderBy('id','DESC')->get();

    $data['userAddress']    = UserAddress::where('user_id',$userId)->orderBy('id','DESC')->get();

    $data['userReferral']   = Users::where('referrerId',$data['userDetails']->referralId)->get();

    $_SESSION['adminTreeData'] = '';
    $_SESSION['getTreedata'] = '';
    self::treeDetails($userId, 0, '');
    $data['treeData'] = $_SESSION['getTreedata'];
    $res = explode(",", $data['treeData']);
    $arrayFilter = array_filter($res);
    $implode = implode(",", $arrayFilter);

    $referralId = $arrayFilter;
    $active = $userId;

       $sqlQuery = "SELECT * FROM UeAVBvpelsUJpczNv WHERE id IN ($implode)";
       $WHERES = "id != " . $active;
        if (!empty($WHERES)) {
            $sqlQuery .= " AND $WHERES";
        }

     $empQuery = DB::select($sqlQuery);



    $data['downline'] = $empQuery;

    $data['userId'] = $userId;
    $data['js_file'] = 'User Profile';
    $data['title'] = 'User Profile';

    return view('admin.user.view-user', $data);

   }



   public function view_kyc(){

    $data['js_file'] = 'View Kyc';
    $data['title'] = 'View Kyc';

    return view('admin.user.view_kyc', $data);

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

        $_SESSION['adminTreeData'].= "['".$username."', '".$uplineName."', '".$referralId."'],";

        // die;


        $result = Users::where('referrerId', $referralId)->get()->toArray();

        // echo "<pre>";
        // print_r($result);


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




   public function genealogy($id = 0)
   {
       $id = encrypt_decrypt('decrypt', $id);
        $_SESSION['getTreedata'] = '';
        $_SESSION['adminTreeData'] = '';
		self::treeDetails($id, 0, '');
       	$data['treeData'] = $_SESSION['adminTreeData'];

       $data['title'] = 'User Tree Chart';
       $data['js_file'] = '';

       return view('admin.user.genealogy_view', $data);
   }














}






















