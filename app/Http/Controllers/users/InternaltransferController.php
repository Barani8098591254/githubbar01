<?php

namespace App\Http\Controllers\users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Users;
use session;
use DB;
use App\Models\Withdraw;
use App\Models\Transaction;
use App\Models\Intertransferhistory;
use App\Models\Interredeemhistory;

class InternaltransferController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Kolkata');
    }

    public function internaltransfer()
    {
        $userId = userId();
        $interRedeemData = Interredeemhistory::where("status", 0)->where(
            "toUserid",
            $userId
        );

        if ($interRedeemData->count() > 0) {
            $data["redeemDataCount"] = "1";
        } else {
            $data["redeemDataCount"] = "0";
        }

        $data["currencyList"] = Currency::where("status", 1)->get();
        $data["js_file"] = "intertransfer";
        $data["title"] = "Internal Transfer";
        $data["pageTitle"] = "Internal Transfer";
        $data["subTitle"] = "Internal Transfer";

        return view("user.internal.internaltransfer", $data);
    }

    public function redeemhistory()
    {
        $data["js_file"] = "";
        $data["title"] = "Redeem History";
        $data["pageTitle"] = "Redeem History";
        $data["subTitle"] = "Redeem History";

        return view("user.internal.redeemhistory", $data);
    }

    public function transferhistory()
    {
        $data["js_file"] = "";
        $data["title"] = "Transfer History";
        $data["pageTitle"] = "Transfer History";
        $data["subTitle"] = "Transfer History";

        return view("user.internal.transferhistory", $data);
    }

    public function getredeemhistory(Request $request)
    {
        $userId = userId();
        $draw = $request["draw"];
        $row = $request["start"];
        $rowperpage = $request["length"]; // Rows display per page
        $columnIndex = $request["order"][0]["column"]; // Column index
        $columnName = $request["columns"][$columnIndex]["data"]; // Column name
        $columnSortOrder = $request["order"][0]["dir"]; // asc or desc
        $searchValue = $request["search"]["value"]; // Search value
        ## Date search value
        $searchByFromdate = $request["searchByFromdate"];
        $searchByTodate = $request["searchByTodate"];
        ## Search Query
        $searchQuery = [];
        if ($searchValue != "") {
            $searchQuery[] =
                "(RedweMSFNdgWlhGJry.symbol like '%" .
                $searchValue .
                "%' or RedweMSFNdgWlhGJry.toAmount like '%" .
                $searchValue .
                "%' or RedweMSFNdgWlhGJry.toUsername like '%" .
                $searchValue .
                "%')";
        }
        $whereClause = "toUserid = " . $userId;
        if (!empty($searchQuery)) {
            $whereClause .= " AND (" . implode(" OR ", $searchQuery) . ")";
        }
        // ## Total number of records without filtering
        $totalRecords = Interredeemhistory::where("toUserid", $userId)->count();
        $newSortOrder = $columnSortOrder === "asc" ? "desc" : "asc";

        $empQuery = "SELECT RedweMSFNdgWlhGJry.*, UeAVBvpelsUJpczNv.username
 FROM RedweMSFNdgWlhGJry
 INNER JOIN UeAVBvpelsUJpczNv ON RedweMSFNdgWlhGJry.toUserid = UeAVBvpelsUJpczNv.id
 WHERE RedweMSFNdgWlhGJry.toUserid = {$userId}
 AND {$whereClause}
 ORDER BY {$columnName} DESC, created_at DESC
 LIMIT {$row}, {$rowperpage}";

 $empQuery = DB::select($empQuery);
 $data = array();
 $i = 1;
 foreach ($empQuery as $key => $value) {
 $status = $value->status;
 $userStatusAction = '';
 switch ($status) {
 case 0:
 $userStatusAction = '<span  class="label text-warning">Initiated</span>';
 break;
 case 1:
 $userStatusAction ='<span  class="label  text-danger">Cancelled</span>';
 break;
 case 2:
 $userStatusAction = '<span class="label  text-success">Completed</span>';
 break;
 }
 $data[] = array(
 'id' => $i,
 "symbol" => $value->symbol,
 "toUsername" => $value->fromUsername,
 "toAmount" => $value->toAmount,
 "redeemCode" => $value->redeemCode,
 "status" => $userStatusAction,
 "date" => date('d, M y h:i A', strtotime($value->created_at)),
 );
 $i++;
 }
 ## Response
 $response = array(
 "draw" => intval($draw),
 "iTotalRecords" => $totalRecords,
 "iTotalDisplayRecords" => count($data),
 "aaData" => $data
 );
 echo json_encode($response);
 }

    public function gettransferhistory(Request $request)
    {
        $userId = userId();
        $draw = $request["draw"];
        $row = $request["start"];
        $rowperpage = $request["length"]; // Rows display per page
        $columnIndex = $request["order"][0]["column"]; // Column index
        $columnName = $request["columns"][$columnIndex]["data"]; // Column name
        $columnSortOrder = $request["order"][0]["dir"]; // asc or desc
        $searchValue = $request["search"]["value"]; // Search value
        ## Date search value
        $searchByFromdate = $request["searchByFromdate"];
        $searchByTodate = $request["searchByTodate"];
        ## Search Query
        $searchQuery = [];
        if ($searchValue != "") {
            $searchQuery[] =
                "(TrsnopjaXHTrYdCXory.symbol like '%" .
                $searchValue .
                "%' or TrsnopjaXHTrYdCXory.toAmount like '%" .
                $searchValue .
                "%' or TrsnopjaXHTrYdCXory.toUsername like '%" .
                $searchValue .
                "%')";
        }
        $whereClause = "fromUserid = " . $userId;
        if (!empty($searchQuery)) {
            $whereClause .= " AND (" . implode(" OR ", $searchQuery) . ")";
        }
        // ## Total number of records without filtering
        $totalRecords = Interredeemhistory::where(
            "fromUserid",
            $userId
        )->count();

        $newSortOrder = $columnSortOrder === "asc" ? "desc" : "asc";

        $empQuery = "SELECT TrsnopjaXHTrYdCXory.*, UeAVBvpelsUJpczNv.username
 FROM TrsnopjaXHTrYdCXory
 INNER JOIN UeAVBvpelsUJpczNv ON TrsnopjaXHTrYdCXory.fromUserid = UeAVBvpelsUJpczNv.id
 WHERE TrsnopjaXHTrYdCXory.fromUserid = {$userId}
 AND {$whereClause}
 ORDER BY {$columnName} DESC, created_at DESC
 LIMIT {$row}, {$rowperpage}";

        $empQuery = DB::select($empQuery);
        $data = [];
        $i = 1;
        foreach ($empQuery as $key => $value) {
            $status = $value->status;
            $userStatusAction = "";
            switch ($status) {
                case 1:
                    $userStatusAction =
                        '<span  class="label text-warning">Initiated</span>';
                    break;
                case 2:
                    $userStatusAction =
                        '<span class="label text-success">Completed</span>';
                    break;
                case 3:
                    $userStatusAction =
                        '<span  class="label text-danger">Cancelled</span>';
                    break;
            }
            $data[] = [
                "id" => $i,
                "symbol" => $value->symbol,
                "fromUsername" => $value->fromUsername,
                "toUsername" => $value->toUsername,
                "toAmount" => $value->toAmount,
                // "equivalentAmt" => $value->equivalentAmt,
                "redeemCode" => $value->redeemCode,
                "status" => $userStatusAction,
                "date" => date("d, M y h:i A", strtotime($value->created_at)),
            ];
            $i++;
        }
        ## Response
        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data,
        ];
        echo json_encode($response);
    }

    public function getCurrencyData(Request $request)
    {


        $userId = session("user_id");

        if ($request->isMethod("post")) {
            $currency_id = $request["currency_id"];
            $userId = userId();

            $currencyData = Withdraw::where("status", 1)->where(
                "currency_id",
                $currency_id
            );

            if ($currencyData->count() > 0) {
                $currencyData = $currencyData->first();
                $currencyID = $currencyData->currency_id;
                $currencySymbol = $currencyData->symbol;
                $userBalance = get_balance($userId, $currencyID);
                $Imin = $currencyData->Imin; // Get the minimum amount
                $Imax = $currencyData->Imax; // Get the maximum

                $res = [
                    "status" => 1,
                    "msg" => "Success",
                    "userBalance" => bcadd($userBalance, 0, 8),
                    "symbol" => get_currency($currencyData->currency_id)->symbol,
                    "minAmount" => $Imin, // Include the minimum amount
                    "maxAmount" => $Imax, // Include the maximum amount
                ];

                echo json_encode($res);
                exit();
            }

            else {
                $res = [
                    "status" => 0,
                    "msg" => "Invalid currency",
                    "page" => "instantswap",
                ];
                echo json_encode($res);
                exit();
            }
        }
    }

    public function doInterTransfer(Request $request)
    {
        $userId = userId(); // Assuming userId() function exists

        if ($request->isMethod("post")) {
            $currency_id = $request->input("currency_id");
            $transferusername = $request->input("transferusername");
            $amount = $request->input("amount");
            $withdrawcode = $request->input("withdrawcode");
            $security_pin = $request->input("security_pin");

            // Check if user exists with the given username
            $checkUser = Users::where("username", $transferusername)->get();

            $checkUser = Users::where("id", userId())
                ->where(
                    "security_pin",
                    encrypt_decrypt("encrypt", $security_pin)
                )
                ->get();

            $user = $checkUser->first();

            // Amount check
            if ((float) $amount <= 0) {
                $msg = "Invalid Amount !!!";
                session()->flash("error", $msg);
                return redirect("internaltransfer");
            }

            // Session userdata
            $sessionUserData = Users::where("is_active", 1)
                ->where("id", $userId)
                ->first();

            if ($sessionUserData) {
                $sessionUserDataUserName = $sessionUserData->username;
            } else {
                $msg = "Invalid security pin";
                session()->flash("error", $msg);
                return redirect("internaltransfer");
            }

            // To username check
            $toUserData = Users::where("is_active", 1)
                ->where("username", $transferusername)
                ->first();

            if ($toUserData) {
                $toUserId = $toUserData->id;

                // $userEmail = encrypt_decrypt('decrypt', $toUserData->email);
                $userEmail = getuserEmail($userId);
            } else {
                $msg = "Username does not exist !!!";
                session()->flash("error", $msg);
                return redirect("internaltransfer");
            }

            // Username check from and to
            if (trim($sessionUserDataUserName) == trim($transferusername)) {
                $msg = "Same user transfer must not be allowed";
                session()->flash("error", $msg);
                return redirect("internaltransfer");
            }

            $currencyData = Currency::where("status", 1)
                ->where("id", $currency_id)
                ->first();

            if ($currencyData) {
                $currencyID = $currencyData->id;
                $symbol = $currencyData->symbol;
                $currencyName = $currencyData->name;
                $getCurncy = get_currency($currencyID);

                // Get balance
                $userBalance = get_balance($userId, $currencyID);

                // Balance check
                if ((float) $amount > (float) $userBalance) {
                    $msg = "Insufficient Balance !!!";
                    session()->flash("error", $msg);
                    return redirect("internaltransfer");
                }

                $limitCheck = Withdraw::where(
                    "currency_id",
                    $currency_id
                )->first();

                $minAmount = $limitCheck->Imin; // Get minAmount from the request
                $maxAmount = $limitCheck->Imax; // Get maxAmount from the request

                // Check if the amount falls within the min and max range
                if (
                    (float) $amount < (float) $minAmount ||
                    (float) $amount > (float) $maxAmount
                ) {
                    $msg =
                        "Transfer Amount not in Min and Max value range. Kindly check it.";
                    Session::flash("error", $msg);
                    return redirect("internaltransfer");
                }

                // $equivalentAmt = ($amount) / ($currencyData->usdprice);

                $redeemCode = "RMC" . date("ymdhis");
                $insertInterData = [
                    "symbol" => $symbol,
                    "currency_id" => $currencyID,
                    "fromUserid" => $userId,
                    "fromUsername" => getuserName($userId),
                    "toUsername" => $transferusername,
                    "toAmount" => $amount,
                    "redeemCode" => $redeemCode,
                    "status" => 1, // 1 - initiated, 2 - completed
                    // 'equivalentAmt' => $equivalentAmt, // Include equivalentAmt
                    "created_at" => date("Y-m-d, H:i:s"),
                ];

                $currencyBalanceData = (float) $userBalance - (float) $amount;
                $insertswap = Intertransferhistory::insert($insertInterData);

                if ($insertswap) {
                    $insertswap = DB::getPdo()->lastInsertId();
                    update_balance($userId, $currencyID, $currencyBalanceData);
                    $insertRedeemData = [
                        "symbol" => $symbol,
                        "currency_id" => $currencyID,
                        "transferid" => $insertswap,
                        "fromUserid" => $userId,
                        "fromUsername" => getuserName($userId),
                        "toUsername" => $transferusername,
                        "toUserid" => $toUserId,
                        "toAmount" => $amount,
                        "redeemCode" => $redeemCode,
                        "status" => 0, // 0 - pending, 1 - completed, 2 - cancelled
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];

                    $insertswap = Interredeemhistory::insert($insertRedeemData);

                    // Email function
                    $mailContent = [
                        "###toUserData###" => $toUserData,
                        "###CURRENCY###" => $symbol,
                        "###transferusername###" => $transferusername,
                        "###AMOUNT###" => $amount,
                        "###RedeemCode###" => $redeemCode,
                    ];

                    // Assuming you have a function to send emails
                    $send = send_mail(
                        17,
                        $userEmail,
                        "Internal Transfer",
                        $mailContent
                    );

                    $msg =
                        "The amount has been transferred to the user account and waiting for redeem confirmation!!!";
                    session()->flash("success", $msg);
                    return redirect("internaltransfer")->with([
                        "fromTransfer" => true,
                    ]);
                } else {
                    $msg = "Invalid currency";
                    session()->flash("error", $msg);
                    return redirect("internaltransfer");
                }
            }
        }
    }
    public function doRedeemTransfer(Request $request)
    {
        $userId = userId();

        if ($request->isMethod("post")) {
            $redeemcode = $request["redeemcode"];
            $redeemwithdrawcode = $request["redeemwithdrawcode"];
            $security_pin = $request["security_pin"];

            $receiveUserData = Users::where("is_active", 1)
                ->where("id", $userId)
                ->first();

            if (!$receiveUserData) {
                $msg = "Invalid redeemwithdrawcode";
                session()->flash("error", $msg);
                return redirect("internaltransfer");
            }

            // Define the verifySecurityPin function
            $isSecurityPinCorrect = $this->verifySecurityPin(
                $userId,
                $security_pin
            );

            if (!$isSecurityPinCorrect) {
                session()->flash("error", "Wrong security pin.");
                return redirect("internaltransfer");
            }

            $TransferData = Interredeemhistory::where("status", 0)
                ->where("toUsername", $receiveUserData->username)
                ->where("redeemCode", $redeemcode)
                ->first();

            if (!$TransferData) {
                $msg = "Invalid redeem code";
                session()->flash("error", $msg);
                return redirect("internaltransfer");
            }

            $userBalance = get_balance($userId, $TransferData->currency_id);

            $currencyBalanceData =
                (float) $userBalance + (float) $TransferData->toAmount;

            $updateTransferWheredata = ["id" => $TransferData->transferid];
            $updateTransferUpdatedata = ["status" => 2];
            $updateRedeemWheredata = ["transferid" => $TransferData->transferid];
            $updateRedeemUpdatedata = ["status" => 2];

            DB::transaction(function () use (
                $userId,
                $TransferData,
                $currencyBalanceData,
                $updateTransferWheredata,
                $updateTransferUpdatedata,
                $updateRedeemWheredata,
                $updateRedeemUpdatedata
            ) {
                update_balance(
                    $userId,
                    $TransferData->currency_id,
                    $currencyBalanceData
                );
                Intertransferhistory::where($updateTransferWheredata)->update(
                    $updateTransferUpdatedata
                );
                Interredeemhistory::where($updateRedeemWheredata)->update(
                    $updateRedeemUpdatedata
                );

                $msg = "Request has been completed !!!";
                session()->flash("success", $msg);
            });

            return redirect("internaltransfer");
        } else {
            $msg = "Invalid Access";
            session()->flash("error", $msg);
            return redirect("internaltransfer");
        }
    }

    private function verifySecurityPin($userId, $inputSecurityPin)
    {
        $user = Users::find($userId);

        if (!$user) {
            return false;
        }

        if ($user->security_pin === $inputSecurityPin) {
            return true;
        }

        return false;
    }
}
