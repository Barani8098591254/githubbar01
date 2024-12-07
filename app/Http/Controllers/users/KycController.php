<?php

namespace App\Http\Controllers\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use URL;
use Redirect;
use DB;
use DateTime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Users;
use App\Models\Userkyc;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;


class KycController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

    // Cloudinary


    public function kycupload(Request $request)
    {

        $request->validate([
            'proof_number' => 'required',
        ]);

        $user_id = session('userId');
        $proof_number = trim($request['proof_number']);

        $get_kyc_details = getkycdetails($user_id);

        $front    = $_FILES["front"];
        $back     = $_FILES["back"];
        $selfi    = $_FILES["selfi"];


        if ($get_kyc_details->fStatus == 0 || $get_kyc_details->fStatus == 2) {
            if ($front['name'] == '' || $front['name'] == 'proof1.jpeg') {

                $res = ['status' => 0, 'msg' => 'Please upload proof front side image!', 'page' => ''];
                echo json_encode($res);
                die;
            }
        }

        if ($get_kyc_details->bStatus == 0 || $get_kyc_details->bStatus == 2) {

            if ($back['name'] == '' || $back['name'] == 'proof1.jpeg') {

                $res = ['status' => 0, 'msg' => 'Please upload proof back side image!', 'page' => ''];
                echo json_encode($res);
                die;
            }
        }

        if ($get_kyc_details->sStatus == 0 || $get_kyc_details->sStatus == 2) {
            if ($selfi['name'] == '' || $selfi['name'] == 'proof1.jpeg') {

                $res = ['status' => 0, 'msg' => 'Please upload your selfi image!', 'page' => ''];
                echo json_encode($res);
                die;
            }
        }



$frontImg = $get_kyc_details->front;
$backImg = $get_kyc_details->back;
$selfiImg = $get_kyc_details->selfi;

if (isset($_FILES["front"]["name"]) && $request->hasFile('front')) {
    $file = $request->file('front');
    if ($file->isValid()) {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $frontImg = Cloudinary::upload($file->getRealPath())->getSecurePath();
    } else {
        $res = ['status' => 0, 'msg' => 'Document proof front invalid', 'page' => ''];
        echo json_encode($res);
        die;
    }
}

if (isset($_FILES["back"]["name"]) && $request->hasFile('back')) {
    $file = $request->file('back');
    if ($file->isValid()) {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $backImg = Cloudinary::upload($file->getRealPath())->getSecurePath();
    } else {
        $res = ['status' => 0, 'msg' => 'Document proof back invalid', 'page' => ''];
        echo json_encode($res);
        die;
    }
}

if (isset($_FILES["selfi"]["name"]) && $request->hasFile('selfi')) {
    $file = $request->file('selfi');
    if ($file->isValid()) {
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $selfiImg = Cloudinary::upload($file->getRealPath())->getSecurePath();
    } else {
        $res = ['status' => 0, 'msg' => 'Document proof selfi invalid', 'page' => ''];
        echo json_encode($res);
        die;
    }
}




        if ($frontImg != '' && $backImg != '' && $selfiImg != '') {

            if ($get_kyc_details->fStatus == 0 || $get_kyc_details->fStatus == 2) {
                $proof_front_status = 1;
            } else {
                $proof_front_status = $get_kyc_details->fStatus;
            }

            if ($get_kyc_details->bStatus == 0 || $get_kyc_details->bStatus == 2) {
                $proof_back_status = 1;
            } else {
                $proof_back_status = $get_kyc_details->bStatus;
            }

            if ($get_kyc_details->sStatus == 0 || $get_kyc_details->sStatus == 2) {
                $selfi_status = 1;
            } else {
                $selfi_status = $get_kyc_details->sStatus;
            }

            $UpdateData = [

                'proof_number' => $proof_number,
                'front' => $frontImg,
                'back' => $backImg,
                'selfi' => $selfiImg,
                'fStatus' => $proof_front_status,
                'bStatus' => $proof_back_status,
                'sStatus' => $selfi_status,
                'created_at' => date('Y-m-d H:i:s'),
            ];



            $update = Userkyc::where('user_id', $user_id)->update($UpdateData);

            

            $get_kyc_details = getkycdetails($user_id);

            $fReason = '';
            $back_reject_reason = '';
            $selfie_reject_reason = '';

            if ($get_kyc_details->fStatus == 0) {
                $proof_front_status = 'Not Yet Uploaded';
                $proof_front_color = '';
            } else if ($get_kyc_details->fStatus == 1) {
                $proof_front_status = 'Pending';
                $proof_front_color = '#ffc107';
            } else if ($get_kyc_details->fStatus == 2) {
                $proof_front_status = 'Rejected';
                $fReason = 'RejectedReason';
                $proof_front_color = '#fd8b8b';
            } else if ($get_kyc_details->fStatus == 3) {
                $proof_front_status = 'Approved';
                $proof_front_color = '#13d487';
            }


            if ($get_kyc_details->bStatus == 0) {
                $proof_back_status = 'Not Yet Uploaded';
                $proof_back_color = '';
            } else if ($get_kyc_details->bStatus == 1) {
                $proof_back_status = 'Pending';
                $proof_back_color = '#ffc107';
            } else if ($get_kyc_details->bStatus == 2) {
                $proof_back_status = 'Rejected';
                $back_reject_reason = 'RejectedReason';
                $proof_back_color = '#fd8b8b';
            } else if ($get_kyc_details->bStatus == 3) {
                $proof_back_status = 'Approved';
                $proof_back_color = '#13d487';
            }

            if ($get_kyc_details->sStatus == 0) {
                $selfi_status = 'Not Yet Uploaded';
                $selfi_color = '';
            } else if ($get_kyc_details->sStatus == 1) {
                $selfi_status = 'Pending';
                $selfi_color = '#ffc107';
            } else if ($get_kyc_details->sStatus == 2) {
                $selfi_status = 'Rejected';
                $selfie_reject_reason = 'RejectedReason';
                $selfi_color = '#fd8b8b';
            } else if ($get_kyc_details->sStatus == 3) {
                $selfi_status = 'Approved';
                $selfi_color = '#13d487';
            }

            if ($update) {

                $updateuser = ['kyc_status' => 1];
                $updates = Users::where('id', $user_id)->update($updateuser);

                user_activity($user_id, 'KYC uploaded');

                $res = ['status' => 1, 'msg' => 'Your KYC document upload successfully.', 'front' => $frontImg, 'back' => $backImg, 'selfi' => $selfiImg, 'frontclr' => $proof_front_color, 'backclr' => $proof_back_color, 'selficlr' => $selfi_color, 'frontsts' => $proof_front_status, 'backsts' => $proof_back_status, 'selfists' => $selfi_status, 'scomment' => @($selfie_reject_reason) ? $selfie_reject_reason : '', 'fcomment' => @($fReason) ? $fReason : '', 'bcomment' => @($back_reject_reason) ? $back_reject_reason : ''];
                echo json_encode($res);
                die;
            } else {

                $res = ['status' => 0, 'msg' => 'Your KYC document upload invalid!', 'page' => ''];
                echo json_encode($res);
                die;
            }
        } else {
            $res = ['status' => 0, 'msg' => 'Your KYC document upload invalid! .', 'page' => ''];
            echo json_encode($res);
            die;
        }
    }
}
