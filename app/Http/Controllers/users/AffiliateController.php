<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Deposit;
use App\Models\Plan;
use App\Models\LevelCommission;

use URL;

class AffiliateController extends Controller
{

     public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }



    function getLevelInformation() {

        $planData = Plan::select('id')->where('status', 1)->orderBy('id','DESC')->first();

        if($planData){
            $result = LevelCommission::where('plan_id',$planData->id)->get()->toArray();
        } else {
            $result = array();
        }

        return $result;
    }


	public function affiliate(){

        $data['levelsData'] = self::getLevelInformation();

        $data['directRef'] = Plan::select('direct_commission')->where('status',1)->first();
        $userData = Users::select('referralId')->where('id',userId())->first();
        $data['depositSum']      = Deposit::where('user_id',userId())->where('status', "Completed")->sum('amount');
        if($userData) {
            $data['referralLink'] = URL::to('/sign-up').'?ref='.$userData->referralId;
            $data['referralCount'] = Users::select('referralId')->where('referrerId',$userData->referralId)->count();
        } else {
            $data['referralCount'] = 0;
            $data['referralLink'] = '';
        }

        $data['js_file'] = 'affiliate';
        $data['title'] = 'Affiliate';
        $data['pageTitle'] = 'User Affiliate';
        $data['subTitle'] = 'Affiliate';
        return view("user.Affiliate.affiliate",$data);
    }



}
