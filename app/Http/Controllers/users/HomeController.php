<?php

namespace App\Http\Controllers\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Plan;
use App\Models\LevelCommission;
use App\Models\Deposit;
use App\Models\WithdrawReq;
use App\Models\Currency;





class HomeController extends Controller
{



    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

    public function index()
    {


        $data['currencyList'] = Currency::where('type',0)->where('status', 1)->where('withdraw_status', 1)->get();
        $data['plan'] = plan::where('status', 1)->where('status', 1)->get();


        $data['planList'] = Plan::where('status', 1)->limit(4)->get();
        $data['depositList'] = Deposit::orderBy('id', 'DESC')->limit(5)->get();
        $data['WithdrawReqList'] = WithdrawReq::orderBy('id', 'DESC')->limit(5)->get();


        $data['title'] = 'Home';
        $data['js_file'] = '';
        $data['pageTitle'] = 'Home';
        $data['subTitle'] = 'Home';
        return view('user/Home/index', $data);
    }

    function undermaintenance()
    {

        $data['js_file'] = '';
        $data['title'] = 'under Maintenance';
        return view('user/Home/maintenance', $data);
    }

    function ipblock()
    {

        $data['js_file'] = '';
        $data['title'] = 'Your Ip Block';
        return view('user/Home/ipblock', $data);
    }




public function fetch_data(Request $request)
{

    $planId = $request->input('id');

    $levelcommsionid = $request->input('plan_id');

    $plan = Plan::find($planId);

    $levelcommsion = LevelCommission::where('plan_id', $levelcommsionid)->get();

    if (!$plan) {
        return response()->json(['error' => 'Plan not found']);
    }



    $level1 = LevelCommission::where('plan_id', $levelcommsionid)
    ->where('level', 1)
    ->first();

    $level2 = LevelCommission::where('plan_id', $levelcommsionid)
    ->where('level', 2)
    ->first();

if (!$level1 || !$level2) {
    return response()->json(['error' => 'Level commission not found']);

}





$roi_commission = $plan->price * $plan->roi_commission / 100;



    $data = [
        'price' => $plan->price,
        'directCommission' => $plan->direct_commission,
        'roi_commission' => $plan->roi_commission,
        'level1Commission' => $level1->commission,
        'level2Commission' => $level2->commission,
        'roitotal' => number_format($roi_commission,2),

    ];
    return response()->json($data);
}
}
