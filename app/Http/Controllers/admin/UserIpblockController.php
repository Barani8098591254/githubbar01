<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ipblock;
use Session;
use Illuminate\Support\Facades\URL;

use DB;




class UserIpblockController extends Controller
{
    
    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

    public function users_ip_block(){

        // $data['Ipblock'] = Ipblock::select('*')->orderBy('id', 'DESC')->get();
        $data['js_file'] = 'ip_Block';
        $data['title'] = 'IpBlock';
        return view('admin.user.user-ip-block',$data);
    }




    public function getipBlock(Request $request){


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
                $searchQuery[] = "(IpyUhtibySEiwdPZS.ip like '%".$searchValue."%' or IpyUhtibySEiwdPZS.created_at like '%".$searchValue."%' or IpyUhtibySEiwdPZS.status like '%".$searchValue."%')";


            }


             // Date filter
             if($searchByFromdate != '' && $searchByTodate != ''){
                 $startDate = $searchByFromdate.' 00:00:00';
                 $endDate = $searchByTodate.' 23:59:59';
                  $searchQuery[] = "(IpyUhtibySEiwdPZS.created_at between '".$startDate."' and '".$endDate."')";
             }

             $WHERE = "";
             if(count($searchQuery) > 0){
                  $WHERE = " WHERE ".implode(' and ',$searchQuery);
             }


            // ## Total number of records without filtering
            $totalRecords = Ipblock::count();
            // ## Total number of records with filtering
            $sel =  DB::select("select count(*) as allcount from IpyUhtibySEiwdPZS ".$WHERE);

            // $records = mysqli_fetch_assoc($sel);
            $totalRecordwithFilter = $sel[0]->allcount;




            // $empQuery = DB::select("SELECT * FROM IpyUhtibySEiwdPZS $WHERE
            // ORDER BY $columnName $columnSortOrder $newSortOrder
            // LIMIT $row, $rowperpage");



$newSortOrder = ($columnSortOrder === 'asc') ? 'desc' : 'asc';

$empQuery = DB::select("SELECT * FROM IpyUhtibySEiwdPZS $WHERE
                        ORDER BY $columnName $newSortOrder
                        LIMIT $row, $rowperpage");


                $data = array();
                $i = 1;
                foreach ($empQuery as $key => $value) {



                    $statusCheckbox = ($value->status == 0)
                    ? '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'ip_status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'deactive\')"><i class="ti-unlock text-danger"></i></a>'
                    : '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'ip_status/' . encrypt_decrypt('encrypt', $value->id) . '\', \'active\')"><i class="ti-unlock text-success"></i></a>';


                    $rejectLink = '<a href="javascript:void()" onclick="return confirmUserStatusChange(\'delete_ipblock/' . encrypt_decrypt('encrypt', $value->id) . '\', \'Delete\')"><i class="fa fa-remove"></i></a>';




                    $data[] = array(
                        'id' => $i,
                        "ip"=>$value->ip,
                        "status" => $statusCheckbox,
                        "date" => date('d, M y h:i A', strtotime($value->created_at)),
                        "reject" => $rejectLink,

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



    public function rejectipaddress(Request $request, $id){

        $ipBlock =  Ipblock::where('id',$id);

        if($ipBlock->count() != 0){
            Ipblock::where('id', $id)->delete();

            Session::flash('success', 'IP address has been rejected successfully');
            return redirect()->back();
        }else{
            Session::flash('error', 'Invalid IP address id');
            return redirect()->back();
        }

    }




    public function ipBlockAdd(Request $request){



        $validatedData = $request->validate([
            'ip' => 'required',
        ]);


        $ipaddress = strip_tags($request->input('ip'));



        if(!filter_var($ipaddress, FILTER_VALIDATE_IP)) {
            session()->flash('error', 'Enter valid Ip Address');
            return redirect()->back();
        } else {
            $IpblockCount   = Ipblock::select('*')->Where('ip',$ipaddress)->get()->count();
            if($IpblockCount > 0) {
                session()->flash('error', 'Already exist.');
                return redirect()->back();
            } else {
                $inputs['ip'] = $ipaddress;
                DB::table('IpyUhtibySEiwdPZS')->insert($inputs);
                session()->flash('success', 'Ip Address created Successfully.');
                return redirect()->back();
            }
        }
    }



    public function ip_status($id){


        $id = encrypt_decrypt('decrypt',$id);


            $ipBlock = Ipblock::where('id',$id);



                if($ipBlock->count() > 0){
                    $ipBlock = $ipBlock->first();

                        $status = ($ipBlock->status == 1) ? 0 : 1;

                        Ipblock::where('id',$id)->update(['status' => $status]);

                        $admin_id = Session::get('adminId');
                        admin_activity($admin_id, 'ipaddress Status');

                        $msg = ($ipBlock->status == 1) ? 'deactive' : 'active';
                        Session::flash('success', 'ipaddress Status '.$msg.' successfully');

                        return back()->with("success", 'ipaddress Status '.$msg.' successfully');


                }else{

                }

    }




    public function delete_ipblock($value){

        $ipId = encrypt_decrypt('decrypt',$value);


        $IpblockCount   = Ipblock::select('*')->Where('id',$ipId)->get()->count();

        if($IpblockCount == 0) {
            session()->flash('error', 'Invalid access ');
            return redirect()->back();
        } else {
            $res = Ipblock::where('id',$ipId)->delete();
            session()->flash('success', 'Ip Address deleted Successfully.');
            return redirect()->back();
        }
    }


}
