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

class AdminIpblockController extends Controller
{
    
    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }


    public function adminActivity()
    {
        // $data['adminActivity'] = DB::table('AAlbCeRQCyyKtmzya')->select('AnbopVhAvWSumu.name','AAlbCeRQCyyKtmzya.*')
        //     ->join('AnbopVhAvWSumu', 'AAlbCeRQCyyKtmzya.adminId', '=', 'AnbopVhAvWSumu.id')
        //     ->orderBy('AAlbCeRQCyyKtmzya.id', 'DESC')
        //     ->get();

            $data['head'] = 'AdminActivity';
            $data['title'] = 'Admin Activity';
            $data['js_file'] = 'Admin Activity';
            return view('admin.AdminSettings.adminActivity', $data);
    }




    public function getAdminActivity(Request $request){

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
                 $searchQuery[] = "(AAlbCeRQCyyKtmzya.activity like '%".$searchValue."%' or AAlbCeRQCyyKtmzya.activity like '%".$searchValue."%' or AAlbCeRQCyyKtmzya.ip like '%".$searchValue."%' or AAlbCeRQCyyKtmzya.browser like '%".$searchValue."%' or AAlbCeRQCyyKtmzya.os like '%".$searchValue."%')";
            }

            // Date filter
            if($searchByFromdate != '' && $searchByTodate != ''){
                $startDate = $searchByFromdate.' 00:00:00';
                $endDate = $searchByTodate.' 23:59:59';
                 $searchQuery[] = "(AAlbCeRQCyyKtmzya.created_at between '".$startDate."' and '".$endDate."')";
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

            // $empQuery = DB::select("select AAlbCeRQCyyKtmzya.*, AnbopVhAvWSumu.name FROM AAlbCeRQCyyKtmzya INNER JOIN AnbopVhAvWSumu ON AAlbCeRQCyyKtmzya.adminId = AnbopVhAvWSumu.id ".$WHERE." ORDER BY ".$columnName." DESC LIMIT ".$row.",".$rowperpage);

            $empQuery = DB::select("SELECT AAlbCeRQCyyKtmzya.*, AnbopVhAvWSumu.name
                          FROM AAlbCeRQCyyKtmzya
                          INNER JOIN AnbopVhAvWSumu ON AAlbCeRQCyyKtmzya.adminId = AnbopVhAvWSumu.id
                          ".$WHERE."
                          ORDER BY ".$columnName." DESC
                          LIMIT ".$row.",".$rowperpage);

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

}
