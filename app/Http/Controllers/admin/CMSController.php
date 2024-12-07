<?php

namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\staticcontent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\contact_us;
use App\Models\Admin;
use Illuminate\Support\Facades\URL;
use DB;


class CMSController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }


    public function cms()
    {

     $data['static'] =  staticcontent::All();

     $data['title'] = 'Static Content';
     $data['js_file'] = 'Cms';
     $data['title'] = 'Cms';

     return view('admin.Cms.view-cms',$data);

    }



    public function getcmsdata(Request $request){

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
                $searchQuery[] = "(scOxalUygShFnAjG.title like '%".$searchValue."%' or scOxalUygShFnAjG.created_at like '%".$searchValue."%')";
            }


             // Date filter
             if($searchByFromdate != '' && $searchByTodate != ''){
                 $startDate = $searchByFromdate.' 00:00:00';
                 $endDate = $searchByTodate.' 23:59:59';
                  $searchQuery[] = "(scOxalUygShFnAjG.created_at between '".$startDate."' and '".$endDate."')";
             }

             $WHERE = "";
             if(count($searchQuery) > 0){
                  $WHERE = " WHERE ".implode(' and ',$searchQuery);
             }


            // ## Total number of records without filtering
            $totalRecords = staticcontent::count();
            // ## Total number of records with filtering
            $sel =  DB::select("select count(*) as allcount from scOxalUygShFnAjG ".$WHERE);

            // $records = mysqli_fetch_assoc($sel);
            $totalRecordwithFilter = $sel[0]->allcount;



            // $empQuery = DB::select("SELECT * FROM scOxalUygShFnAjG $WHERE
            //                 ORDER BY $columnName $columnSortOrder
            //                 LIMIT $row, $rowperpage");


            $empQuery = DB::select("SELECT * FROM scOxalUygShFnAjG $WHERE
            ORDER BY $columnName DESC
            LIMIT $row, $rowperpage");


                                    $data = array();
                        $i = 1;
                        foreach ($empQuery as $key => $value) {

                            $verifyLabel = ($value->status == '1')
                            ? '<span title="Activate" class="label label-success">Activated</span>'
                            : '<span title="Deactivate" class="label label-danger">Deactivated</span>';



        $editcms = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/cmsEdit/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="Edit Currency" class="fa fa-edit pa-10"></i></a>';

                            $data[] = array(
                                'id' => $i,
                                "title" => $value->title,
                                "status" => $verifyLabel,
                                "date" => date('d, M y h:i A', strtotime($value->created_at)),
                                "action" => $editcms,

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






    public function cmsEdit($id){

     $id = encrypt_decrypt('decrypt',$id);
     $query = staticcontent::where('id',$id);
     if($query->count() == 0){
        Session::flash('error', 'Invalid CMS');
        return redirect()->back();
     }else{
         $data['cms'] = $query->first();
         $data['js_file'] = 'EditCms';
         $data['title'] = 'Edit Cms';

         return view('admin.Cms.edit-cms',$data);

     }

    }



    public function cmsCreate(){
     $data['js_file'] = 'Create CMS ';
     $data['title'] = 'Create CMS';
     return view('admin.Cms.create_cms',$data);
    }





public function updatecms(Request $request){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ], [
            'name.required' => 'Enter enter name',
            'description.required' => 'Please enter description',
            'status.required' => 'Please select a status',
        ]);

      $id = encrypt_decrypt('decrypt',$request['cmsid']);
      $name = $request['name'];
      $description = $request['description'];
      $status = $request['status'];

      $check_static = staticcontent::select('title')->where('id','!=',$id)->where('title',$name)->count();

              if($check_static != 0){

                Session::flash('error', 'CMS already exist!!');
                return redirect()->back();
              }

                $updateData = [
                    'title' => $name,
                    'page' => '',
                    'description' => trim($description),
                    'status' => $status,
                ];

                $Update = staticcontent::where('id',$id)->update($updateData);


                $admin_id = Session::get('adminId');
                admin_activity($admin_id, 'Site Setting Update');

                Session::flash('success', 'CMS updated successfully');
                return redirect(env('ADMIN_URL').'/cms');
     }

}

    public function email(){
     $data['js_file'] = 'Email Template';
     $data['title'] = 'Email Template';
     return view('admin.Cms.email_template', $data);
    }

    public function email_edit(){
     $data['js_file'] = 'EditEmail Template';
     $data['title'] = 'Edit Email Template';
     return view('admin.Cms.edit_email', $data);
    }





    public function support(){

        // $data['contact'] = contact_us::orderBy('id', 'desc')->get();

        $data['js_file'] = 'Contact';
        $data['title'] = 'Contact';
        return view('admin.contact.contact_view', $data);


    }





    public function getsupportdata(Request $request){

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
                $searchQuery[] = "(cOnJQWNPYMdPpRho.name like '%".$searchValue."%' or cOnJQWNPYMdPpRho.email like '%".$searchValue."%' or cOnJQWNPYMdPpRho.phoneno like '%".$searchValue."%')";
            }


             // Date filter
             if($searchByFromdate != '' && $searchByTodate != ''){
                 $startDate = $searchByFromdate.' 00:00:00';
                 $endDate = $searchByTodate.' 23:59:59';
                  $searchQuery[] = "(cOnJQWNPYMdPpRho.created_at between '".$startDate."' and '".$endDate."')";
             }

             $WHERE = "";
             if(count($searchQuery) > 0){
                  $WHERE = " WHERE ".implode(' and ',$searchQuery);
             }


            // ## Total number of records without filtering
            $totalRecords = contact_us::count();
            // ## Total number of records with filtering
            $sel =  DB::select("select count(*) as allcount from cOnJQWNPYMdPpRho ".$WHERE);

            // $records = mysqli_fetch_assoc($sel);
            $totalRecordwithFilter = $sel[0]->allcount;



            // $empQuery = DB::select("SELECT * FROM cOnJQWNPYMdPpRho $WHERE
            //                 ORDER BY $columnName $columnSortOrder
            //                 LIMIT $row, $rowperpage");


            $empQuery = DB::select("SELECT * FROM cOnJQWNPYMdPpRho $WHERE
            ORDER BY $columnName DESC
            LIMIT $row, $rowperpage");

                                    $data = array();
                        $i = 1;
                        foreach ($empQuery as $key => $value) {

                            $verifyLabel = ($value->status == '1')
                            ? '<span title="Activate" class="label label-success">Replied</span>'
                            : '<span title="Deactivate" class="label label-danger">Not Replied</span>';



                          $editcon = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/reply_page/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="View Support" class="fa fa-eye pa-10"></i></a>';

                            $data[] = array(
                                'id' => $i,
                                "name" => $value->name,
                                "email" => $value->email,

                                "phoneno" => $value->phoneno,
                                "message" => $value->message,

                                "status" => $verifyLabel,
                                "date" => date('d, M y h:i A', strtotime($value->created_at)),
                                "action" => $editcon,

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





    public function reply_page(Request $request,$id){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $validatedData = $request->validate([
            'admin_msg' => 'required',
        ], [
            'admin_msg.required' => 'Please enter the message',
          ]);


              $id = encrypt_decrypt('decrypt',strip_tags($id));
              $admin_msg = strip_tags($request['admin_msg']);
              $email = strip_tags($request['email']);
              $phone = strip_tags($request['phoneno']);


              $admin_reply = Contact_Us::select('name','email','phoneno')->where('id',$id);


                if($admin_reply->count() != 0){
                    $get_contact = $admin_reply->first();

                            $updateData = [
                                'admin_msg' => $admin_msg,
                                'status'  => 1,
                            ];

                            $Update = Contact_Us::where('id',$id)->update($updateData);


                            $user_email = trim(strip_tags($get_contact->email));
                            $user_name = $get_contact->name;
                            $user_phone = $get_contact->phoneno;
                            $content = $admin_msg;


                            $send = send_mail(15,$user_email,'Support Us - MLm',['###USERNAME###' => $user_name,'###USEREMAIL###' => $user_email,'###MESSAGE###' => $content,'###COPY###' => 'Copyright © 2023 MLM All rights reserved.']);


                            $admin_id = Session::get('adminId');
                            admin_activity($admin_id, 'Password Changed');

                            if($send == 1){
                                Session::flash('success', 'Message sent successfully');
                                return redirect(env('ADMIN_URL').'/support');
                            }else{
                                Session::flash('error', 'Message sent invalid');
                                return redirect(env('ADMIN_URL').'/support');
                            }

                        }else{
                            Session::flash('error', 'Invalid user contact US !!');
                            return redirect()->back();
                            }
                        }

        $id = encrypt_decrypt('decrypt',$id);
        $data['contact_id'] = encrypt_decrypt('encrypt',$id);
        $data['reply'] =  Contact_Us::where('id',$id)->first();

        $data['js_file'] = 'Replay';
        $data['title'] = 'Contact Us Replay';

        return view('admin.contact.replay-page', $data);

    }



}
