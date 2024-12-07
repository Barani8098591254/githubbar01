<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\users\HomeController;
use App\Http\Controllers\users\UserCmsController;
use App\Http\Controllers\users\UserAuthController;
use App\Http\Controllers\users\DashboardController;
use App\Http\Controllers\users\SettingController;
use App\Http\Controllers\users\KycController;
use App\Http\Controllers\users\InvestmentController;
use App\Http\Controllers\users\FundController;
use App\Http\Controllers\users\withdrawontroller;
use App\Http\Controllers\users\CronController;
use App\Http\Controllers\users\GenealogyController;
use App\Http\Controllers\users\userDepositController;
use App\Http\Controllers\users\AffiliateController;
use App\Http\Controllers\users\userswapController;
use App\Http\Controllers\users\InternaltransferController;
use App\Http\Controllers\users\MyBoardController;









// Admin Controller
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\AdminuserController;
use App\Http\Controllers\admin\UserIpblockController;
use App\Http\Controllers\admin\AdminSettingsController;
use App\Http\Controllers\admin\CurrencyController;
use App\Http\Controllers\admin\DepositController;
use App\Http\Controllers\admin\HistoryController;
use App\Http\Controllers\admin\UserKycController;
use App\Http\Controllers\admin\CMSController;
use App\Http\Controllers\admin\PlanController;
use App\Http\Controllers\admin\securityController;
use App\Http\Controllers\admin\AdminIpblockController;
use App\Http\Controllers\admin\SwapController;
use App\Http\Controllers\admin\InternalController;





Route::group(['middleware' => ['checkauth','web']], function () {
// user Controller
Route::get('/', [HomeController::class, 'index']);

Route::get('undermaintenance', [HomeController::class, 'undermaintenance']);
Route::get('ipblock', [HomeController::class, 'ipblock']);



 // CMS
Route::get('aboutus', [UserCmsController::class, 'aboutus']);
Route::get('investPlan', [UserCmsController::class, 'investPlan']);
Route::get('affiliates', [UserCmsController::class, 'affiliate']);
Route::get('termsofservice', [UserCmsController::class, 'termsofservice']);
Route::get('privacyPolicy', [UserCmsController::class, 'privacyPolicy']);
Route::get('refundPolicy', [UserCmsController::class, 'refundPolicy']);

Route::match(['get', 'post'], 'signin', [UserAuthController::class, 'signin']);
Route::match(['get', 'post'], 'signup', [UserAuthController::class, 'signup']);

Route::get('userotp', [UserAuthController::class, 'userotp']);
Route::post('verification', [UserAuthController::class, 'verification']);
Route::get('userManualReg/{id}', [UserAuthController::class, 'userManualReg']);

Route::get('usertfa', [UserAuthController::class, 'user_tfa']);
Route::post('tfalogin', [UserAuthController::class, 'tfalogin']);


Route::get('accountActivate/{id}', [UserAuthController::class, 'account_activate']);
Route::get('verify-link/{id?}', [UserAuthController::class, 'forgot_Password']);

Route::get('forgotpassword/{id?}', [UserAuthController::class, 'forgotpassword']);
Route::post('forgetpw', [UserAuthController::class, 'forgetpw']);

Route::post('resetPasssubmit', [UserAuthController::class, 'resetPasssubmit']);
Route::get('forgotpass', [UserAuthController::class, 'forgotpass']);

Route::post('awardPairCommission', [UserAuthController::class, 'awardPairCommission']);



 // User Kyc
//  Route::post('uploadkyc', [KycController::class, 'uploadkyc']);

 Route::post('kycupload',[KycController::class,'kycupload']);

  // ResendRegisterEmail!
  Route::get('resendmail/{id?}', [UserAuthController::class, 'resendmail']);
  Route::post('resendmailactive', [UserAuthController::class, 'resendmailactive']);

  // dashboard
  Route::get('dashboard', [DashboardController::class, 'dashboard']);
  Route::get('moveToWallet/{id}', [DashboardController::class, 'moveToWallet']);



  Route::match(['get', 'post'], 'profile', [SettingController::class, 'userprofile']);

  Route::match(['get', 'post'], 'userchangepassword', [SettingController::class, 'userchangepassword']);


  Route::match(['get', 'post'], 'security', [SettingController::class, 'security']);

  Route::match(['get', 'post'], 'chnage_wPin', [SettingController::class, 'chnage_wPin']);

  Route::post('/send_email_pin',[SettingController::class,'send_email_pin']);
  Route::get('reset_security_pin',[SettingController::class,'reset_security_pin']);



    Route::match(['get', 'post'], 'deposit', [SettingController::class, 'deposit']);
    Route::post('create_address/{id}', [SettingController::class, 'create_address']);

//   Route::match(['get', 'post'],'security', [SettingController::class,'security']);
    Route::get('withdraw', [withdrawontroller::class, 'withdraw']);
    Route::post('sendwithdrawotp',[withdrawontroller::class,'sendwithdrawotp']);
    Route::post('withdrawSubmit',[withdrawontroller::class,'withdrawSubmit']);


  Route::get('withdrawhistory',[withdrawontroller::class,'withdrawhistory']);
  Route::post('userwithdrawhistory', [withdrawontroller::class, 'userwithdrawhistory']);
  Route::post('witdraw-details', [withdrawontroller::class, 'witdraw_details']);


  Route::match(['get', 'post'], 'useraffiliate', [SettingController::class, 'userreferral']);

  Route::post('commissonfecth_data', [SettingController::class, 'commissonfecth_data']);


  Route::get('myreferrals', [SettingController::class, 'myreferrals']);


  Route::post('getMyReferraldata', [SettingController::class, 'getMyReferraldata']);


//   User Activity
Route::get('userActivity', [SettingController::class, 'userActivity']);
Route::post('getuserActivity', [SettingController::class, 'getuserActivity']);




  Route::get('/logout', [UserAuthController::class, 'logout']);



  Route::get('deposithistory', [SettingController::class, 'deposithistory']);

Route::post('usergetdeposithistory', [SettingController::class, 'usergetdeposithistory']);



//   Route::get('tfa', [SettingController::class, 'tfaview']);

  Route::post('tfaenable', [SettingController::class, 'tfaenable']);
  Route::post('profile_pic', [SettingController::class, 'profile_pic']);



 //User Contact
 Route::get('contactus', [UserCmsController::class, 'contactus']);
 Route::post('contactmail', [UserCmsController::class, 'contactmail']);




// makeInvestments
 Route::get('Investment', [InvestmentController::class, 'Investment']);
 Route::get('confirmInvestment/{id}', [InvestmentController::class, 'confirmInvestment']);
 Route::post('submitCancelInvestment', [InvestmentController::class, 'submitCancelInvestment']);
 Route::post('getPlanDetails', [InvestmentController::class, 'getPlanDetails']);
 Route::get('getplanprice/{id}', [InvestmentController::class, 'getplanprice']);



//  Route::post('makeInvestment', [InvestmentController::class, 'makeInvestment']);

Route::post('submitInvestment', [InvestmentController::class, 'submitInvestment']);

Route::get('Investmenthistory', [InvestmentController::class, 'investmenthistory']);

Route::post('getinvestmentdata', [InvestmentController::class, 'getinvestmentdata']);

Route::get('cancelInvestment/{id}', [InvestmentController::class, 'cancelInvestment']);



Route::get('genealogy', [GenealogyController::class, 'genealogy']);
Route::get('downline', [GenealogyController::class, 'downline']);
Route::post('myDownline', [GenealogyController::class, 'myDownline']);



 // fund
 Route::get('fund', [FundController::class, 'index']);



 // Roi Cron
 Route::get('roiUpdate', [CronController::class, 'dailyRoi']);
 Route::get('binaryTree', [CronController::class, 'binaryTree']);
 Route::get('truncateTables', [CronController::class, 'truncateTables']);

 Route::match(['get', 'post'], 'userlevelcommison', [userDepositController::class, 'userlevelcommison']);

 Route::get('levelcommission', [userDepositController::class, 'levelcommison']);

 Route::post('userlevelcommison', [userDepositController::class, 'userlevelcommison']);

 Route::get('directcommisson', [userDepositController::class, 'directcommisson']);
 Route::post('userboardcommisson', [userDepositController::class, 'userboardcommisson']);


 Route::get('roicommisson', [userDepositController::class, 'roicommisson']);

 Route::post('getroicommisson', [userDepositController::class, 'getroicommisson']);

 Route::get('userinvestment', [userDepositController::class, 'userinvestment']);
 Route::post('getuserinvestment', [userDepositController::class, 'getuserinvestment']);

 Route::get('affiliate', [AffiliateController::class, 'affiliate']);


//  Swap

Route::match(['get', 'post'],'instantswap',[userswapController::class,'instantswap']);
Route::get('swaphistory', [userswapController::class, 'swaphistory']);
Route::post('getapairdata', [userswapController::class, 'getapairdata']);
Route::post('swapbuy', [userswapController::class, 'swapbuy']);

Route::post('swapsell', [userswapController::class, 'swapsell']);



Route::post('doinstantswap', [userswapController::class, 'doinstantswap']);


Route::get('instantswaphistory', [userswapController::class, 'instant_swaphistory']);
Route::post('getInstantSwaphistory', [userswapController::class, 'getInstantSwaphistory']);



Route::post('fetch-data', [HomeController::class, 'fetch_data']);


Route::post('fetch-level-commissions', [SettingController::class, 'fetchLevelCommissions']);


Route::post('getCurrencyData', [InternaltransferController::class, 'getCurrencyData']);

Route::post('doInterTransfer', [InternaltransferController::class, 'doInterTransfer']);


Route::post('CurrencyData', [InternaltransferController::class, 'CurrencyData']);




Route::get('transferhistory', [InternaltransferController::class, 'transferhistory']);
Route::post('gettransferhistory', [InternaltransferController::class, 'gettransferhistory']);

Route::get('redeemhistory', [InternaltransferController::class, 'redeemhistory']);
Route::post('getredeemhistory', [InternaltransferController::class, 'getredeemhistory']);



Route::post('doredeemtransfer', [InternaltransferController::class, 'doredeemtransfer']);


Route::match(['get', 'post'],'internaltransfer',[InternaltransferController::class,'internaltransfer']);



});




















// ADMIN CONTROLLER

$admin_url = env('ADMIN_URL', '8BNKaINa1FAHm3yrhCKo');

Route::group(['prefix' => $admin_url, 'middleware' => ['adminauth','web']], function () {


Route::get('/', [AuthController::class, 'admin_login']);
Route::get('admin', [AuthController::class, 'admin_login']);
Route::post('adminlogin', [AuthController::class, 'login']);
Route::get('adminLogout', [AuthController::class, 'adminLogout']);
Route::post('/sendloginotp', [AuthController::class, 'sendLoginOtp']);
Route::get('dashboard', [AuthController::class, 'admindashboard']);


Route::get('securitySettings', [securityController::class, 'security_Settings']);
Route::post('change_password', [securityController::class, 'change_password']);
Route::post('change_pattern', [securityController::class, 'change_pattern']);


Route::get('siteSettings', [AdminSettingsController::class, 'siteSettings']);
Route::post('setting', [AdminSettingsController::class, 'setting']);
Route::get('userActivity', [AdminSettingsController::class, 'user_activity']);
Route::post('getuserActivity', [AdminSettingsController::class, 'getuserActivity']);
// Route::get('ipWhitelist', [AdminSettingsController::class, 'ipwhitelisthistory']);


Route::get('usersList', [AdminuserController::class, 'users_list']);
Route::post('getuserslist', [AdminuserController::class, 'getuserslist']);
Route::post('getusersbalancetable', [AdminuserController::class, 'getusersbalancetable']);
Route::get('genealogy/{id}', [AdminuserController::class, 'genealogy']);
Route::get('user-status/{id}', [AdminuserController::class, 'user_status']);
Route::match(['get', 'post'],'resend/{id}',[AdminuserController::class,'resendMail']);
Route::get('updatetfa/{id}', [AdminuserController::class, 'updatetfa']);
Route::get('updatewithdraw/{id}', [AdminuserController::class, 'updatewithdraw']);

Route::get('Profile/{id}', [AdminuserController::class, 'view_user']);
Route::get('activeuser', [AdminuserController::class, 'activeuser']);
Route::post('getActiveuser', [AdminuserController::class, 'getActiveuser']);
Route::get('Inactiveuser', [AdminuserController::class, 'inactiveuser']);
Route::post('getinactiveuser', [AdminuserController::class, 'getinactiveuser']);





Route::get('kyc', [UserKycController::class, 'kyc']);
Route::post('getUserkycData', [UserKycController::class, 'getUserkycData']);
Route::match(['get', 'post'],'editKyc/{id}',[UserKycController::class,'edit_kyc']);
Route::get('approvedKyc/{id}/{userId}', [UserKycController::class, 'approvedKyc']);
Route::post('rejectKycSubmit/{id}', [UserKycController::class, 'rejectKycSubmit']);
Route::get('KycApproved', [UserKycController::class, 'activekyc']);
Route::post('getactivekyc', [UserKycController::class, 'getactivekyc']);
Route::get('rejctkyc', [UserKycController::class, 'rejctkyc']);
Route::post('getrejctkyc', [UserKycController::class, 'getrejctkyc']);

Route::get('pendingkyc', [UserKycController::class, 'pendingkyc']);

Route::post('getpendingkyc', [UserKycController::class, 'getpendingkyc']);




Route::get('adminActivity', [AdminIpblockController::class, 'adminActivity']);
Route::post('getAdminActivity', [AdminIpblockController::class, 'getAdminActivity']);


Route::match(['get', 'post'], 'ipBlock', [UserIpblockController::class, 'users_ip_block']);
Route::post('getipBlock', [UserIpblockController::class, 'getipBlock']);
Route::match(['get', 'post'], 'reject-ipaddress/{id}', [UserIpblockController::class, 'rejectipaddress']);
Route::match(['get', 'post'], 'ipblockadd', [UserIpblockController::class, 'rejectipaddress']);
Route::post('ipblockadd', [UserIpblockController::class, 'ipBlockAdd']);
Route::get('delete_ipblock/{id}', [UserIpblockController::class, 'delete_ipblock']);
Route::get('ip_status/{id}', [UserIpblockController::class, 'ip_status']);

Route::get('CreateCurrency', [CurrencyController::class, 'Create_Currency']);
Route::post('addcurrency', [CurrencyController::class, 'add_currency']);


Route::get('currencyList', [CurrencyController::class, 'currency_list']);
Route::post('getcurrencylist', [CurrencyController::class, 'getcurrencylist']);
Route::match(['get', 'post'], 'currencySetting', [CurrencyController::class, 'currency_setting']);
Route::post('getcurrencysettings', [CurrencyController::class, 'getcurrencysettings']);
Route::match(['get', 'post'], 'editcurrencySetting/{id}', [CurrencyController::class, 'viewucurrency_setting']);
Route::match(['get', 'post'], 'depositcurrencyupdate', [CurrencyController::class, 'deposit_setting']);
Route::match(['get', 'post'], 'withdrawcurrencyupdate', [CurrencyController::class, 'withdrawcurrency_setting']);
Route::match(['get', 'post'], 'editCurrency/{id}', [CurrencyController::class, 'viewucurrency']);
Route::get('currency-status/{id}', [CurrencyController::class, 'currency_status']);
Route::get('withdraw-status/{id}', [CurrencyController::class, 'withdraw_status']);
Route::get('deposit-status/{id}', [CurrencyController::class, 'deposit_status']);
Route::get('investment-status/{id}', [CurrencyController::class, 'investment_status']);

Route::post('update_currency', [CurrencyController::class, 'update_currency']);

Route::post('internaltransferamountupdate', [CurrencyController::class, 'internaltransferamountupdate']);


Route::match(['get', 'post'], 'depositHistory', [DepositController::class, 'deposit_History']);
Route::post('getdepositHistorydata', [DepositController::class, 'getdepositHistorydata']);


Route::post('approved-withdraw', [HistoryController::class, 'approved_withdraw']);
Route::post('rejected-withdraw', [HistoryController::class, 'rejected_withdraw']);


Route::get('withdrawpending', [HistoryController::class, 'withdrawpending']);
Route::post('getwithdrawpending', [HistoryController::class, 'getwithdrawpending']);




Route::get('levelCommission', [HistoryController::class, 'level_commission']);
 Route::get('directCommission', [HistoryController::class, 'directcommission']);
 Route::get('roiCommission', [HistoryController::class, 'roicommission']);
 Route::get('pairCommission', [HistoryController::class, 'pairCommission']);


Route::post('getlevelCommission', [HistoryController::class, 'getlevelCommission']);

Route::post('getdirectCommission', [HistoryController::class, 'getdirectCommission']);

Route::post('getroiCommission', [HistoryController::class, 'getroiCommission']);
Route::post('getpaircommission', [HistoryController::class, 'getpaircommission']);



Route::get('roi', [HistoryController::class, 'roi']);
Route::get('withdrawHistory', [HistoryController::class, 'withdraw_view']);
Route::post('getwithdrawdata', [HistoryController::class, 'getwithdrawdata']);
Route::get('investment', [HistoryController::class, 'investment']);
Route::post('getinvestment', [HistoryController::class, 'getinvestment']);

// Route::post('cancelinvestment/{id}', [HistoryController::class, 'cancelinvestment']);
Route::get('cancelinvestment/{id}', [HistoryController::class, 'cancel_investment']);


Route::get('cms', [CMSController::class, 'cms']);
Route::post('getcmsdata', [CMSController::class, 'getcmsdata']);
Route::get('cmsEdit/{id}', [CMSController::class, 'cmsEdit']);
Route::post('updatecms', [CMSController::class, 'updatecms']);
Route::get('cmsCreate', [CMSController::class, 'cmsCreate']);
Route::Post('createcms', [CMSController::class, 'createcms']);
Route::get('email', [CMSController::class, 'email']);
Route::get('emailEdit', [CMSController::class, 'email_edit']);
Route::match(['get', 'post'],'support', [CMSController::class, 'support']);
Route::post('getsupportdata', [CMSController::class, 'getsupportdata']);
Route::match(['get', 'post'],'reply_page/{id}', [CMSController::class, 'reply_page']);





Route::get('addPlan', [PlanController::class, 'plan_add']);
Route::Post('Planstore', [PlanController::class, 'Planstore']);
Route::Post('getplandeatils', [PlanController::class, 'getplandeatils']);
Route::get('planList', [PlanController::class, 'plan_list']);
Route::post('planUpdate', [PlanController::class, 'edit_plan']);
Route::match(['get', 'post'], 'edit_plan/{id}', [PlanController::class, 'edit_plan']);
Route::post('editPlan', [PlanController::class, 'editPlan']);

Route::get('addswap', [SwapController::class, 'add_swap']);
Route::Post('swapstore', [SwapController::class, 'swapstore']);
Route::get('swaplist', [SwapController::class, 'swap_list']);
Route::post('getswaplist', [SwapController::class, 'getswaplist']);
Route::match(['get', 'post'],'swapupdate/{id}', [SwapController::class, 'swap_update']);
Route::post('swapedit', [SwapController::class, 'swap_edit']);

Route::get('swaphistory', [SwapController::class, 'swaphistory']);

Route::post('getswaphistory', [SwapController::class, 'getswaphistory']);


Route::get('internalredeemhistory', [InternalController::class, 'internalredeemhistory']);
Route::post('getinternalredeemhistory', [InternalController::class, 'getinternalredeemhistory']);

Route::get('redeemhistory/{id}', [InternalController::class, 'redeemhistory']);


Route::get('internaltransferhistory', [InternalController::class, 'internaltransferhistory']);
Route::post('getinternaltransferhistory', [InternalController::class, 'getinternaltransferhistory']);



});
Route::get('binancecron', [SwapController::class, 'updateSwapBinancePrice']);

Route::get('apicall', [CronController::class, 'apicall']);
Route::get('currencylocaldata', [CronController::class, 'currencylocaldata']);

Route::get('getWazirXData', [CronController::class, 'getCryptoData']);


Route::match(['get', 'post'], 'test', [PlanController::class, 'test']);

Route::match(['get', 'post'], 'autoFillAndStoreData', [CronController::class, 'autoFillAndStoreData']);

Route::match(['get', 'post'], 'referalacc', [CronController::class, 'referalacc']);
Route::match(['get', 'post'], 'getreferidbalance', [CronController::class, 'getreferidbalance']);


Route::match(['get', 'post'], 'createBinaryMLMBoard', [CronController::class, 'createBinaryMLMBoard']);





Route::match(['get', 'post'], 'createBoard', [CronController::class, 'createBoard']);



Route::get('createBoard/{directId}',[MyBoardController::class,'createBoard']);
