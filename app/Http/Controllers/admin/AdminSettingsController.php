<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Adminactivity;
use App\Models\Setting;
use DB;
Use Session;
use Validator;
use DataTables;
use App\Models\Useractivity;




class AdminSettingsController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }


    public function user_activity()
    {

    $data['js_file'] = 'User Activity';
    $data['title'] = 'User Activity';

    return view('admin.user.user_activity', $data);
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
        $totalRecords = Useractivity::count();
        // ## Total number of records with filtering
        $sel = DB::select("select count(*) as allcount FROM UatMuXaJtDhDLqIe INNER JOIN UeAVBvpelsUJpczNv ON UatMuXaJtDhDLqIe.userId = UeAVBvpelsUJpczNv.id ".$WHERE);





        // $records = mysqli_fetch_assoc($sel);
        $totalRecordwithFilter = $sel[0]->allcount;

        // $empQuery = DB::select("select UatMuXaJtDhDLqIe.*,UeAVBvpelsUJpczNv.username FROM UatMuXaJtDhDLqIe INNER JOIN UeAVBvpelsUJpczNv ON UatMuXaJtDhDLqIe.userId = UeAVBvpelsUJpczNv.id ".$WHERE." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage);


        $newSortOrder = ($columnSortOrder === 'asc') ? 'desc' : 'asc';

$empQuery = DB::select("SELECT UatMuXaJtDhDLqIe.*, UeAVBvpelsUJpczNv.username FROM UatMuXaJtDhDLqIe INNER JOIN UeAVBvpelsUJpczNv ON UatMuXaJtDhDLqIe.userId = UeAVBvpelsUJpczNv.id $WHERE
                        ORDER BY $columnName $newSortOrder
                        LIMIT $row, $rowperpage");

            $data = array();
            $i = 1;
            foreach ($empQuery as $key => $value) {
                $data[] = array(
                    'id' => $i,
                    "username"=>$value->username,
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


   public function siteSettings(){

    $adminId = 1;
    $setting = Setting::where('id', $adminId)->first();

    $data['setting'] = $setting;

    $data['head'] = 'Site Setting';

    $data['title'] = 'Site Setting';

    $data['js_file'] = 'site_setting';


    return view('admin.AdminSettings.siteSettings', $data);

}


public function setting(Request $request){

    if ($request->isMethod('post')) {

        $validator = Validator::make($request->all(),[
            'sitename' => 'required|string|min:3|max:25',
            'contactaddress' => 'required',
            'contactnumber' => 'required',
            'contactmail' => 'required',
            'copyright' => 'required',
            'fblink' => 'required',
            'telegramlink' => 'required',
            'twitterlink' => 'required',
            'instainlink' => 'required',
            'maintanance_content' => 'required',
            'mlm' => 'required',
            'kyc' => 'required',
            'withdraw' => 'required',


        ], [
            'sitename.required' => 'Enter your site name',
            'contactaddress.required' => 'Enter contact address',
            'copyright.required' => 'Enter copyright information',
            'fblink.required' => 'Enter facebook link',
            'telegramlink.required' => 'Enter telegram link',
            'instainlink.required' => 'Enter instagram link',
            'maintanance_content.required' => 'Enter maintenance content',
        ]);

         if($validator->fails()){
            $errors = $validator->errors()->first();
            return back()->with("error", $errors);
         }

        $updateData = [
            'sitename' => $request->input('sitename'),
            'contactaddress' => trim($request->input('contactaddress')),
            'contactnumber' => $request->input('contactnumber'),
            'contactmail' => $request->input('contactmail'),
            'maintanance' => $request->input('site_status'),
            'copyright' => $request->input('copyright'),
            'fblink' => $request->input('fblink'),
            'telegramlink' => $request->input('telegramlink'),
            'instainlink' => $request->input('instainlink'),
            'twitterlink' => $request->input('twitterlink'),
            'maintanance_content' => $request->input('maintanance_content'),
            'mlm' => $request->input('mlm'),
            'kyc' => $request->input('kyc'),
            'withdraw' => $request->input('withdraw'),




        ];

        try {
            $update = Setting::where('id', 1)->update($updateData);

            $admin_id = Session::get('adminId');
            admin_activity($admin_id, 'Site Setting Update');

            if ($update) {
                return back()->with("success", "Site setting update successfully");
            } else {
                return back()->with("error", "Update failed");
            }
        } catch (Exception $e) {
            return back()->with("error", "An error occurred while updating the site settings: " . $e->getMessage());
        }
    }
}


public function ipwhitelisthistory(){

    $data['head'] = 'Ip Whitelist';
    $data['title'] = 'Ip Whitelist';
    $data['mainTitle'] = 'Ip Whitelist';
    $data['js_file'] = 'Ip Whitelist';
    return view('admin.AdminSettings.ipwhiteHistory', $data);
                    }




                }
