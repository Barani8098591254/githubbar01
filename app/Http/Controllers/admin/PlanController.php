<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Plan;
use App\Models\LevelCommission;
use Session;
use App\Models\Currency;

use Illuminate\Support\Facades\URL;

class PlanController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }


    public function plan_add(){


        $data['currency'] = Currency::select('id','name','symbol')->where('status',1)->where('investment_status',1)->get();



     $data['js_file'] = 'plan_val';
     $data['title'] = ' Create Plan ';

     return view('admin.plan.plan_add', $data);

    }




    public function getplandeatils(Request $request)
    {


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


                $searchQuery[] = "(cuKZJurxYSsFaXNv.symbol like '%".$searchValue."%' or PnACeUagDYOKDcYL.name like '%".$searchValue."%' or PnACeUagDYOKDcYL.price like '%".$searchValue."%' or PnACeUagDYOKDcYL.direct_commission like '%".$searchValue."%')";


                // PnACeUagDYOKDcYL

                // cuKZJurxYSsFaXNv
            }

             // Date filter
             if($searchByFromdate != '' && $searchByTodate != ''){
                 $startDate = $searchByFromdate.' 00:00:00';
                 $endDate = $searchByTodate.' 23:59:59';
                  $searchQuery[] = "(PnACeUagDYOKDcYL.created_at between '".$startDate."' and '".$endDate."')";
             }

             $WHERE = "";
             if(count($searchQuery) > 0){
                  $WHERE = " WHERE ".implode(' and ',$searchQuery);
             }


            // ## Total number of records without filtering
            $totalRecords = Plan::count();
            // ## Total number of records with filtering

            $sel = DB::select("select count(*) as allcount FROM PnACeUagDYOKDcYL INNER JOIN cuKZJurxYSsFaXNv ON PnACeUagDYOKDcYL.currency_id = cuKZJurxYSsFaXNv.id ".$WHERE);


            // $records = mysqli_fetch_assoc($sel);
            $totalRecordwithFilter = $sel[0]->allcount;


            // $empQuery = DB::select("select PnACeUagDYOKDcYL.*,cuKZJurxYSsFaXNv.symbol FROM PnACeUagDYOKDcYL INNER JOIN cuKZJurxYSsFaXNv ON PnACeUagDYOKDcYL.currency_id = cuKZJurxYSsFaXNv.id ".$WHERE." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage);

            $empQuery = DB::select("select PnACeUagDYOKDcYL.*,cuKZJurxYSsFaXNv.symbol,cuKZJurxYSsFaXNv.usdprice FROM PnACeUagDYOKDcYL INNER JOIN cuKZJurxYSsFaXNv ON PnACeUagDYOKDcYL.currency_id = cuKZJurxYSsFaXNv.id " . $WHERE . " order by " . $columnName . " DESC limit " . $row . "," . $rowperpage);



            $data = array();
            $i = 1;
            foreach ($empQuery as $key => $value) {

                $editplan = '<a href="' . URL::to('/') . '/' . env('ADMIN_URL') . '/edit_plan/' . encrypt_decrypt('encrypt', $value->id) . '" class=""><i title="Edit Plan" class="fa fa-edit pa-10"></i></a>';


                $data[] = array(
                    'id' => $i,
                    "name"=>$value->name,
                    "price"=>number_format($value->price,2),
                    "direct_commission"=>$value->direct_commission.' %',
                    "roi_commission"=>$value->roi_commission.' %',
                    "symbol"=>$value->symbol,
                    "equivalent_amt" => number_format(($value->price)/($value->equivalent_amt),2),
                    "date"=>date('d,M Y h:i a',strtotime($value->created_at)),
                    "action" => $editplan,


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





public function Planstore(Request $request)
{

    $validatedData = $request->validate([
            'currencyId' => 'required',
            'name' => 'required',
            'price' => 'required',
            'direct_commission' => 'required',
            'roi_commission' => 'required',
            'status'=> 'required',
            'pair_commission' => 'required',
            "commission.*"  => "required|numeric",


    ], [

        'currencyId.required' => 'Please choose the currency',
        'name.required' => 'Please enter the name',
        'price.required' => 'Please enter the price',
        'direct_commission.required' => 'Please enter the direct commission',
        'roi_commission.required' => 'Please enter the roi commission',
        'status.required' => 'Please enter status',

    ]);

    $currencyid          = strip_tags($request->input('currencyId'));
    $name              = strip_tags(ucfirst($request->input('name')));
    $price             = strip_tags($request->input('price'));
    $direct_commission = strip_tags($request->input('direct_commission'));
    $roi_commission    = strip_tags($request->input('roi_commission'));
    $pair_commission = strip_tags($request->input('pair_commission'));
    $status            = strip_tags($request->input('status'));
    $days            = strip_tags($request->input('days'));
    $commission        = $request->input('commission');

    $checkname =  Plan::where('currency_id',$currencyid)->where('name',$name);

        if($checkname->count() == 0){
            $checkCurr = Currency::select('id','name','symbol','investment_status')->where('id',$currencyid)->where('status',1);

            if($checkCurr->count() > 0){

                $currency = $checkCurr->first()->investment_status;

                    if($currency == 1){

                        $insertData = [
                            'name' => $name,
                            'price' => $price,
                            'direct_commission' => $direct_commission,
                            'roi_commission' => $roi_commission,
                            'pair_commission' => $pair_commission,
                            'currency_id' => $currencyid,
                            'equivalent_amt' => get_currency($currencyid)->usdprice,
                            'status' => $status,
                            'days' => $days,
                            'cancel_fee' => 5,
                            'created_at' => date('Y-m-d H:i:s'),

                        ];


                        // echo "<pre>";
                        // print_r( $insertData );
                        // die;



                        $insert = Plan::insert($insertData);
                        $lastInsertId = DB::getPdo()->lastInsertId();
                        $levelCommission = $commission;
                        if($lastInsertId){
                        if(count($levelCommission) > 0) {

                            for($i=0; $i<count($levelCommission); $i++) {

                                $level = $i + 1;

                                $commission = $levelCommission[$i];

                                $data = array('plan_id' => $lastInsertId, 'plan_amount' => $price,'level' => $level, 'commission' => $commission,'created_at' => date('Y-m-d H:i:s'));

                               LevelCommission::insert($data);
                            }

                        }
                            Session::flash('success', 'Plan added successfully');
                            return redirect(env('ADMIN_URL') .'/'. 'planList' );
                       }else{
                            Session::flash('error', 'Plan add invalid');
                            return redirect(env('ADMIN_URL') .'/'. 'planList' );
                       }



                    }else{
                        Session::flash('error', 'This currency investment status disabled');
                        return redirect(env('ADMIN_URL') .'/'. 'planList' );
                    }

            }else{
               Session::flash('error', 'This currency status disabled');
               return redirect(env('ADMIN_URL') .'/'. 'planList' );
            }

        }else{
            Session::flash('error', 'Plan name already exist!');
            return redirect(env('ADMIN_URL') .'/'. 'planList' );
        }


    $insertdata =

    $Plan = new Plan;
    $Plan->name = strip_tags($request->input('name'));
    $Plan->price = strip_tags($request->input('price'));
    $Plan->direct_commission = strip_tags($request->input('direct_commission'));
    $Plan->roi_commission = strip_tags($request->input('roi_commission'));
    $Plan->currency_id = 1;
    $Plan->status = $request->input('status');
    $Plan->save();
    $lastID = $Plan->id;
    $levelCommission = $request->input('commission');
    $result = self::update_level_commission($levelCommission, $lastID);
    // return redirect('plan-list')->with('success', 'plan created successfully!');

    return redirect(env('ADMIN_URL').'/planList')->with('success', 'plan created successfully!');


}

function update_level_commission($levelCommission,$lastID){

    if(count($levelCommission) > 0) {

        // $this->db->delete('level_commission', array('plan_id' => $lastID));

        $this->db->truncate('level_commission');

        for($i=0; $i<count($levelCommission); $i++) {

            $level = $i + 1;

            $commission = $levelCommission[$i];

            $data = array('plan_id' => $lastID, 'level' => $level, 'commission' => $commission);

            $this->sameDataUpdate('level_commission', $data);

            //$this->db->insert('level_commission', $data);
        }

        return true;

    } else {

        return false;
    }
}



    public function plan_list()
    {

     $data['js_file'] = 'Plan List';
     $data['title'] = 'Plan List';

     return view('admin.plan.plans_list', $data);

    }



    public function edit_plan($planIds){


        $id = encrypt_decrypt('decrypt',$planIds);

        $data['plan'] = Plan::where('id',$id)->first();



        $data['commissionData'] = LevelCommission::where('plan_id',$id)->get()->toArray();

        // $data['currency'] =  Currency::select('id','name','symbol','investment_status')->where('status',1)->get();

        $data['currency'] = Currency::select('id','name','symbol')->where('status',1)->where('investment_status',1)->where('symbol','USD')->get();

        $data['id'] = $planIds;


        $data['js_file'] = 'Plan_Update';
        $data['title'] = 'Plan Update';
        return view('admin.plan.plan_edit', $data);

    }


    public function editPlan(Request $request)
    {
        if ($request->isMethod('post')) {

            $validatedData = $request->validate([
                'price' => 'required',
                'roi_commission' => 'required|numeric',
                'direct_commission' => 'required|numeric',
                'commission.*' => 'required|numeric',
                'status' => 'required',
                'days' => 'required',
                'currency_id' => 'required',
                'pair_commission' => 'required',
            ], [
                'price.required' => 'Enter the price',
                'commission.*.required' => 'Enter the level commission',
            ]);

            $id = encrypt_decrypt('decrypt', strip_tags($request['id']));
            $tradeName = trim(strip_tags($request['tradeName']));
            $price = trim(strip_tags($request['price']));
            $commission = $request['commission'];
            $status = $request['status'];
            $currency_id = $request['currency_id'];
            $planId = $id;

            $insertPlan = [
                'name' => $tradeName,
                'price' => $price,
                'currency_id' => $currency_id,
                'status' => $request['status'],
                'direct_commission' => $request['direct_commission'],
                'roi_commission' => $request['roi_commission'],
                'pair_commission' => $request['pair_commission'],
                'days' => $request['days'],
                'equivalent_amt' => get_currency($currency_id)->usdprice,
            ];


            // echo "<pre>";
            // print_r( $insertPlan);
            // die;

            $updatePlan = Plan::where('id', $id)->update($insertPlan);

            if ($updatePlan) {
                if (count($commission) > 0) {
                 DB::table('LftDOlfkBbywgObD')->where('plan_id', $planId)->delete();

                    foreach ($commission as $key => $value) {
                        $level = $key + 1;

                        $data = [
                            'commission' => $value,
                            'plan_amount' => $price,
                        ];

                        LevelCommission::updateOrCreate(
                            ['plan_id' => $planId, 'level' => $level],
                            $data
                        );

                        $admin_id = Session::get('adminId');
                        admin_activity($admin_id, 'Plan Created');
                    }
                    Session::flash('success', 'Plan has been updated successfully!');
                    return redirect(env('ADMIN_URL') . '/' . 'planList');
                }else{
                    Session::flash('error', 'Invalid Level Commission');
                    return redirect(env('ADMIN_URL') . '/' . 'planList');
                }


            }


        }
    }




}
