<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;

class securityController extends Controller
{
    
    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }


    public function security_Settings()
    {

     $data['js_file'] = 'admin';
     $data['title'] = 'Security Setting';
     return view('admin.AdminSettings.securitySettings',$data);

    }


    public function change_password(Request $request){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $validatedData = $request->validate([
                'current_password' => 'required',
                'password' => 'required',
                'c_password' => 'required',

            ], [
               'current_password.required' => 'Enter first name',
               'password.required' => 'Enter last name',
               'c_password.required' => 'Select your date Of birth',

            ]);

            $current_password = trim(strip_tags($request['current_password']));
            $password         = trim(strip_tags($request['password']));
            $c_password       = trim(strip_tags($request['c_password']));

             $user_id = Session::get('adminId');



             $get_password = Admin::where('id',$user_id)->first();


                if(encrypt_decrypt('encrypt',$current_password) == $get_password->password){

                    if($password == $c_password){

                        $updateData = [
                                'password'  => encrypt_decrypt('encrypt',$password),
                        ];


                        $update = Admin::where('id',1)->update($updateData);

                        $admin_id = Session::get('adminId');
                        admin_activity($admin_id, 'Password Changed');

                        $res = ['status' => 1,'msg' => 'password changed successfully. Please Login Again','page' => ''];
                        echo json_encode($res) ; die;
                        // $send = sendemail($email_id,3,'',['###USER###' => $username]);
                    }else{
                        $res = ['status' => 0,'msg' => 'Your password and confirmation password do not match.','page' => ''];
                        echo json_encode($res) ; die;
                    }
                }else{
                    $res = ['status' => 0,'msg' => 'Current password is wrong!.','page' => ''];
                    echo json_encode($res) ; die;
                }
        }

    }





    public function change_pattern(Request $request)
    {

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $validatedData = $request->validate([
        'current_pattern_val' => 'required',
        'new_pattern' =>  'required',
        'confirm_pattern'=>'required|same:new_pattern'
        ], [
            'current_pattern_val.required' => 'Please enter the current pattern',
            'new_pattern.required' => 'Please enter the new pattern',
            'confirm_pattern.required' => 'Please enter the confirm pattern'
        ]);

			$current_pattern_val = encrypt_decrypt('encrypt',$request['current_pattern_val']);
			$new_pattern =$request->new_pattern;
			$confirm_pattern =$request->confirm_pattern;


            $user_id = Session::get('adminId');
            $check_old_password = Admin::where('id',$user_id)->where('pattern',$current_pattern_val)->first();




			if($check_old_password){
				if( $new_pattern == $confirm_pattern ){
					$updateData =[

						'pattern' => encrypt_decrypt('encrypt',$new_pattern)
					];


					$Update =Admin::where('id', $user_id)->update($updateData);
                    $admin_id = Session::get('adminId');
                    admin_activity($admin_id, 'Pattern Changed');

					if($Update){
						$datas = ['status' => 1,'msg' => ' Pattern Changed successfully. please login'];
						return json_encode($datas);
					}else{
						$datas = ['status' => 0,'msg' => 'invaild'];
						return json_encode($datas);
					}
				}else{
					$datas = ['status' => 0,'msg' => 'New pattern & Confirm pattern not matching'];
						return json_encode($datas);

					}
				}else{
					$datas = ['status' => 0,'msg' => 'Current pattern Does not match'];
					return json_encode($datas);


			}
        }

    }

}
