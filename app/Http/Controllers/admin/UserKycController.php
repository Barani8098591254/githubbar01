<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\kyc;
use DB;
use Session;
use Illuminate\Support\Facades\URL;

class UserKycController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }


    public function kyc(){

        $data['js_file'] = 'kyc_data';
        $data['title'] = 'User kyc';
        return view('admin.user.user-kyc', $data);

       }




       public function getUserkycData(Request $request){
        $draw = $request['draw'];
        $row = $request['start'];
        $rowperpage = $request['length']; // Rows display per page
        $columnIndex = $request['order'][0]['column']; // Column index
        $columnName = 'ukyOfUauwGyniOUh.id'; // Column name
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

                // $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or UeAVBvpelsUJpczNv.email like '%".encrypt_decrypt('encrypt',$searchValue)."%' or UeAVBvpelsUJpczNv.kyc_status like '%".$statusVal."%')";
                $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or UeAVBvpelsUJpczNv.email like '%".encrypt_decrypt('encrypt',$searchValue)."%')";

            }


             // Date filter
             if($searchByFromdate != '' && $searchByTodate != ''){
                 $startDate = $searchByFromdate.' 00:00:00';
                 $endDate = $searchByTodate.' 23:59:59';
                  $searchQuery[] = "(ukyOfUauwGyniOUh.created_at between '".$startDate."' and '".$endDate."')";
             }

             $WHERE = "";
             if(count($searchQuery) > 0){
                  $WHERE = " WHERE ".implode(' and ',$searchQuery);
             }


            // ## Total number of records without filtering
            $totalRecords = kyc::count();
            // ## Total number of records with filtering
            $sel = DB::select("select count(*) as allcount FROM ukyOfUauwGyniOUh INNER JOIN UeAVBvpelsUJpczNv ON ukyOfUauwGyniOUh.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);



            $totalRecordwithFilter = $sel[0]->allcount;

            // $empQuery = DB::select("select ukyOfUauwGyniOUh.*,UeAVBvpelsUJpczNv.username, UeAVBvpelsUJpczNv.email, UeAVBvpelsUJpczNv.kyc_status FROM ukyOfUauwGyniOUh INNER JOIN UeAVBvpelsUJpczNv ON ukyOfUauwGyniOUh.user_id = UeAVBvpelsUJpczNv.id ".$WHERE." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage);


            $empQuery = DB::select("select ukyOfUauwGyniOUh.*,UeAVBvpelsUJpczNv.username, UeAVBvpelsUJpczNv.email, UeAVBvpelsUJpczNv.kyc_status FROM ukyOfUauwGyniOUh INNER JOIN UeAVBvpelsUJpczNv ON ukyOfUauwGyniOUh.user_id = UeAVBvpelsUJpczNv.id " . $WHERE . " order by " . $columnName . " DESC limit " . $row . "," . $rowperpage);



    $data = array();
    $i = 1;
    foreach ($empQuery as $key => $value) {
        // Determine the status label based on kyc_status
        if ($value->kyc_status == 3) {
            $kycStatusLabel = '<span class="label label-success">Approved</span>';
        } elseif ($value->kyc_status == 2) {
            $kycStatusLabel = '<span class="label label-danger">Rejected</span>';
        } elseif ($value->kyc_status == 1) {
            $kycStatusLabel = '<span class="label label-primary">Pending</span>';
        } else {
            $kycStatusLabel = '<span class="label label-warning">Not yet uploaded</span>';
        }

        // Define the action link based on $value->kyc_status
        if ($value->kyc_status == 3) {
            $actionLink = '<a href="' . URL::to('/').'/'. env('ADMIN_URL') . '/editKyc/' . encrypt_decrypt('encrypt', $value->user_id) . '" class=""><i title="View KYC" class="fa fa-eye"></i></a>';

        }

        else {
            $actionLink = '<a href="' . URL::to('/').'/' . env('ADMIN_URL') . '/editKyc/' . encrypt_decrypt('encrypt', $value->user_id) . '" class=""><i title="Edit KYC" class="fa fa-pencil"></i></a>';


        }

        $data[] = array(
            'id' => $i,
            "username" => $value->username,
            "email" => encrypt_decrypt('decrypt', $value->email),
            "kyc_status" => $kycStatusLabel,
            "date" => date('d, M y h:i A', strtotime($value->created_at)),
            "action" => $actionLink,
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





       public function edit_kyc($user_id){

        $userid = encrypt_decrypt('decrypt',$user_id);
        $data['kyclist'] = DB::table('ukyOfUauwGyniOUh')->select('UeAVBvpelsUJpczNv.username','UeAVBvpelsUJpczNv.email', 'UeAVBvpelsUJpczNv.kyc_status','ukyOfUauwGyniOUh.*')
        ->join('UeAVBvpelsUJpczNv', 'ukyOfUauwGyniOUh.user_id', '=', 'UeAVBvpelsUJpczNv.id')->where('user_id',$userid)
        ->orderBy('UeAVBvpelsUJpczNv.id', 'DESC')
        ->first();
        $data['js_file'] = 'kyc_data';
        $data['title'] = 'Edit KYC';
        return view('admin.user.view_kyc', $data);
     }



     public function approvedKyc($type,$userId){
        $userId = encrypt_decrypt('decrypt',$userId);
            $checkUser  = kyc::where('user_id',$userId);
                if($checkUser->count() > 0){
                    $userKyc = $checkUser->first();
                       $reason = '';
                       if($type == 'front') {
                            $array = array('fStatus' => 3, 'fReason' => $reason);
                            $proof_type = 'Proof Front';

                        }
                        else if($type == 'back') {
                            $array = array('bStatus' => 3, 'back_reject_reason' => $reason);
                            $proof_type = 'Proof back';

                        }
                        else if($type == 'selfi') {
                            $array = array('sStatus' => 3, 'selfie_reject_reason' => $reason);
                            $proof_type = 'Selfie';

                        } else {
                            $array = array();
                            $proof_type = '';
                        }

                        $update = kyc::where('user_id',$userKyc->user_id)->update($array);
                        if($update){
                            $user_email = getuserEmail($userId);
                            $username = getuserName($userId);

                            $send = send_mail(14,$user_email,'KYC Approved',['###USER###' => $username,'###TYPE###' => $proof_type,'###STATUS###' => 'Approved','###SITENAME###' => 'MLM','###COPY###' => 'Copyright © 2023 MLm All rights reserved.']);

                            $array = array('user_id'=>$userId, 'fStatus'=>3, 'bStatus'=>3, 'sStatus'=>3);
                            $rows = kyc::where('user_id',$userId)->where('fStatus',3)->where('bStatus',3)->where('sStatus',3)->count();


                            if($rows > 0) {
                                Users::where('id',$userId)->update(array('kyc_status' => 3));
                            }

                            $admin_id = Session::get('adminId');
                            admin_activity($admin_id, 'KYC Approved');


                             Session::flash('success', 'KYC has been approved successfully!');
                            //  return redirect('editKyc/'.encrypt_decrypt('encrypt',$userId));
                             return redirect(env('ADMIN_URL') .'/'. 'editKyc/' . encrypt_decrypt('encrypt', $userId));

                        }else{
                            Session::flash('error', 'KYC documents update failed!');
                            //  return redirect('editKyc/'.encrypt_decrypt('encrypt',$userId));
                             return redirect(env('ADMIN_URL') .'/'. 'editKyc/' . encrypt_decrypt('encrypt', $userId));

                        }
                }else{
                     Session::flash('error', 'Invalid User  !!');
                     return redirect('kyc');
                }
     }





     public function rejectKycSubmit(Request $request){
        $validatedData = $request->validate([
            'type' => 'required',
            'user_id' => 'required',
            'reason' => 'required',
        ], [
            'reason.required' => 'Please Enter The Proof Rejected Reason'
        ]);

            $reject_type = $request['type'];
            $reason = $request['reason'];
            $userId = encrypt_decrypt('decrypt',$request['user_id']);

            $checkUser  = kyc::where('user_id',$userId);

                if($checkUser->count() > 0){

                    $userKyc = $checkUser->first();

                    if($reject_type == 'front') {
                            $array = array('fStatus' => 2, 'fReason' => $reason);
                            $proof_type = 'Proof Front';
                        }
                        else if($reject_type == 'back') {
                            $array = array('bStatus' => 2, 'back_reject_reason' => $reason);
                            $proof_type = 'Proof Back';
                        }
                         else if($reject_type == 'selfi') {
                            $array = array('sStatus' => 2, 'selfie_reject_reason' => $reason);
                            $proof_type = 'Selfie';
                        }
                        else {
                            $proof_type = '';
                            $array = array();
                        }



                    $update = kyc::where('user_id',$userId)->update($array);
                     if($update){
                            $user_email = getuserEmail($userId);
                            $username = getuserName($userId);

                            $send = send_mail(7,$user_email,'KYC Rejected',['###USER###' => $username,'###TYPE###' => $proof_type,'###STATUS###' => 'Rejected','###REASON###' => $reason,'###SITENAME###' => 'MLM','###COPY###' => 'Copyright © 2023 MLM All rights reserved.']);
                            Users::where('id',$userId)->update(array('kyc_status' => 2));

                            $admin_id = Session::get('adminId');
                            admin_activity($admin_id, 'KYC Rejected');

                            Session::flash('success', 'KYC has been rejected successfully!');
                            return redirect(env('ADMIN_URL') .'/'. 'editKyc/' . encrypt_decrypt('encrypt', $userId));
                        }else{
                        Session::flash('error', 'KYC documents update failed!');
                        return redirect(env('ADMIN_URL') .'/'. 'editKyc/' . encrypt_decrypt('encrypt', $userId));
                    }

                }else{
                    Session::flash('error', 'Invalid User  !!');
                    return redirect('user-kyc-list');
                }

    }






public function activekyc(){

    $data['js_file'] = '';
    $data['title'] = 'User Approved kyc';
    return view('admin.dashboard.activekyc', $data);

}







public function getactivekyc(Request $request){
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

            // $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or UeAVBvpelsUJpczNv.email like '%".encrypt_decrypt('encrypt',$searchValue)."%' or UeAVBvpelsUJpczNv.kyc_status like '%".$statusVal."%')";
            $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or UeAVBvpelsUJpczNv.email like '%".encrypt_decrypt('encrypt',$searchValue)."%')";

        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(ukyOfUauwGyniOUh.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = kyc::count();
        // ## Total number of records with filtering
        $sel = DB::select("select count(*) as allcount FROM ukyOfUauwGyniOUh INNER JOIN UeAVBvpelsUJpczNv ON ukyOfUauwGyniOUh.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);



        $totalRecordwithFilter = $sel[0]->allcount;


        $empQuery = DB::select("SELECT ukyOfUauwGyniOUh.*, UeAVBvpelsUJpczNv.username, UeAVBvpelsUJpczNv.email, UeAVBvpelsUJpczNv.kyc_status FROM ukyOfUauwGyniOUh
        INNER JOIN UeAVBvpelsUJpczNv ON ukyOfUauwGyniOUh.user_id = UeAVBvpelsUJpczNv.id
        ".$WHERE." AND UeAVBvpelsUJpczNv.kyc_status = 3
        ORDER BY ".$columnName." DESC LIMIT ".$row.",".$rowperpage);



// dd($empQuery);die;

$data = array();
$i = 1;
foreach ($empQuery as $key => $value) {
    // Determine the status label based on kyc_status
    if ($value->kyc_status == 3) {
        $kycStatusLabel = '<span class="label label-success">Approved</span>';
    } elseif ($value->kyc_status == 2) {
        $kycStatusLabel = '<span class="label label-danger">Rejected</span>';
    } elseif ($value->kyc_status == 1) {
        $kycStatusLabel = '<span class="label label-primary">Pending</span>';
    } else {
        $kycStatusLabel = '<span class="label label-warning">Not yet uploaded</span>';
    }

    // Define the action link based on $value->kyc_status
    if ($value->kyc_status == 3) {
        $actionLink = '<a href="' . URL::to('/').'/'. env('ADMIN_URL') . '/editKyc/' . encrypt_decrypt('encrypt', $value->user_id) . '" class=""><i title="View KYC" class="fa fa-eye"></i></a>';

    }

    else {
        $actionLink = '<a href="' . URL::to('/').'/' . env('ADMIN_URL') . '/editKyc/' . encrypt_decrypt('encrypt', $value->user_id) . '" class=""><i title="Edit KYC" class="fa fa-pencil"></i></a>';


    }

    $data[] = array(
        'id' => $i,
        "username" => $value->username,
        "email" => encrypt_decrypt('decrypt', $value->email),
        "kyc_status" => $kycStatusLabel,
        "date" => date('d, M y h:i A', strtotime($value->created_at)),
        "action" => $actionLink,
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



public function rejctkyc(){

    $data['js_file'] = '';
    $data['title'] = 'User Rejected kyc';
    return view('admin.dashboard.inactivekyc', $data);

}




public function getrejctkyc(Request $request){
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

            // $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or UeAVBvpelsUJpczNv.email like '%".encrypt_decrypt('encrypt',$searchValue)."%' or UeAVBvpelsUJpczNv.kyc_status like '%".$statusVal."%')";
            $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or UeAVBvpelsUJpczNv.email like '%".encrypt_decrypt('encrypt',$searchValue)."%')";

        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(ukyOfUauwGyniOUh.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = kyc::count();
        // ## Total number of records with filtering
        $sel = DB::select("select count(*) as allcount FROM ukyOfUauwGyniOUh INNER JOIN UeAVBvpelsUJpczNv ON ukyOfUauwGyniOUh.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);



        $totalRecordwithFilter = $sel[0]->allcount;


        $empQuery = DB::select("SELECT ukyOfUauwGyniOUh.*, UeAVBvpelsUJpczNv.username, UeAVBvpelsUJpczNv.email, UeAVBvpelsUJpczNv.kyc_status FROM ukyOfUauwGyniOUh
        INNER JOIN UeAVBvpelsUJpczNv ON ukyOfUauwGyniOUh.user_id = UeAVBvpelsUJpczNv.id
        ".$WHERE." AND UeAVBvpelsUJpczNv.kyc_status = 2
        ORDER BY ".$columnName." DESC LIMIT ".$row.",".$rowperpage);




// dd($empQuery);die;

$data = array();
$i = 1;
foreach ($empQuery as $key => $value) {
    // Determine the status label based on kyc_status
    if ($value->kyc_status == 3) {
        $kycStatusLabel = '<span class="label label-success">Approved</span>';
    } elseif ($value->kyc_status == 2) {
        $kycStatusLabel = '<span class="label label-danger">Rejected</span>';
    } elseif ($value->kyc_status == 1) {
        $kycStatusLabel = '<span class="label label-primary">Pending</span>';
    } else {
        $kycStatusLabel = '<span class="label label-warning">Not yet uploaded</span>';
    }

    // Define the action link based on $value->kyc_status
    if ($value->kyc_status == 3) {
        $actionLink = '<a href="' . URL::to('/').'/'. env('ADMIN_URL') . '/editKyc/' . encrypt_decrypt('encrypt', $value->user_id) . '" class=""><i title="View KYC" class="fa fa-eye"></i></a>';

    }

    else {
        $actionLink = '<a href="' . URL::to('/').'/' . env('ADMIN_URL') . '/editKyc/' . encrypt_decrypt('encrypt', $value->user_id) . '" class=""><i title="Edit KYC" class="fa fa-pencil"></i></a>';


    }

    $data[] = array(
        'id' => $i,
        "username" => $value->username,
        "email" => encrypt_decrypt('decrypt', $value->email),
        "kyc_status" => $kycStatusLabel,
        "date" => date('d, M y h:i A', strtotime($value->created_at)),
        "action" => $actionLink,
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




public function pendingkyc(){

    $data['js_file'] = '';
    $data['title'] = 'Pending kyc';
    return view('admin.dashboard.pendingkyc', $data);

}






public function getpendingkyc(Request $request){
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

            // $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or UeAVBvpelsUJpczNv.email like '%".encrypt_decrypt('encrypt',$searchValue)."%' or UeAVBvpelsUJpczNv.kyc_status like '%".$statusVal."%')";
            $searchQuery[] = "(UeAVBvpelsUJpczNv.username like '%".$searchValue."%' or UeAVBvpelsUJpczNv.email like '%".encrypt_decrypt('encrypt',$searchValue)."%')";

        }


         // Date filter
         if($searchByFromdate != '' && $searchByTodate != ''){
             $startDate = $searchByFromdate.' 00:00:00';
             $endDate = $searchByTodate.' 23:59:59';
              $searchQuery[] = "(ukyOfUauwGyniOUh.created_at between '".$startDate."' and '".$endDate."')";
         }

         $WHERE = "";
         if(count($searchQuery) > 0){
              $WHERE = " WHERE ".implode(' and ',$searchQuery);
         }


        // ## Total number of records without filtering
        $totalRecords = kyc::count();
        // ## Total number of records with filtering
        $sel = DB::select("select count(*) as allcount FROM ukyOfUauwGyniOUh INNER JOIN UeAVBvpelsUJpczNv ON ukyOfUauwGyniOUh.user_id = UeAVBvpelsUJpczNv.id ".$WHERE);



        $totalRecordwithFilter = $sel[0]->allcount;


        $empQuery = DB::select("SELECT ukyOfUauwGyniOUh.*, UeAVBvpelsUJpczNv.username, UeAVBvpelsUJpczNv.email, UeAVBvpelsUJpczNv.kyc_status FROM ukyOfUauwGyniOUh
        INNER JOIN UeAVBvpelsUJpczNv ON ukyOfUauwGyniOUh.user_id = UeAVBvpelsUJpczNv.id
        ".$WHERE." AND UeAVBvpelsUJpczNv.kyc_status = 1
        ORDER BY ".$columnName." DESC LIMIT ".$row.",".$rowperpage);




// dd($empQuery);die;

$data = array();
$i = 1;
foreach ($empQuery as $key => $value) {
    // Determine the status label based on kyc_status
    if ($value->kyc_status == 3) {
        $kycStatusLabel = '<span class="label label-success">Approved</span>';
    } elseif ($value->kyc_status == 2) {
        $kycStatusLabel = '<span class="label label-danger">Rejected</span>';
    } elseif ($value->kyc_status == 1) {
        $kycStatusLabel = '<span class="label label-primary">Pending</span>';
    } else {
        $kycStatusLabel = '<span class="label label-warning">Not yet uploaded</span>';
    }

    // Define the action link based on $value->kyc_status
    if ($value->kyc_status == 3) {
        $actionLink = '<a href="' . URL::to('/').'/'. env('ADMIN_URL') . '/editKyc/' . encrypt_decrypt('encrypt', $value->user_id) . '" class=""><i title="View KYC" class="fa fa-eye"></i></a>';

    }

    else {
        $actionLink = '<a href="' . URL::to('/').'/' . env('ADMIN_URL') . '/editKyc/' . encrypt_decrypt('encrypt', $value->user_id) . '" class=""><i title="Edit KYC" class="fa fa-pencil"></i></a>';


    }

    $data[] = array(
        'id' => $i,
        "username" => $value->username,
        "email" => encrypt_decrypt('decrypt', $value->email),
        "kyc_status" => $kycStatusLabel,
        "date" => date('d, M y h:i A', strtotime($value->created_at)),
        "action" => $actionLink,
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
