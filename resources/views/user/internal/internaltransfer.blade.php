
@include('user.common.header')
<style type="text/css">
    h5 {
        color: red;
    }

    #select-box{
  height:40px;
  overflow-y:auto;
    width:50px;
}
option{
  overflow-y:scroll;
}

</style>

<main class="main">

    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{URL::to('/')}}"><i class="far fa-home"></i> Home</a></li>
                <li class="active">{{$subTitle}}</li>
            </ul>
        </div>
    </div>


    <div class="dashboard-area pt-70 pb-70">
        <div class="container">
            <div class="row">

                @include('user.common.settingTab')


                <div class="col-lg-9 col-md-8">
                    <div class="dashboard-content">


                        <div class="transaction-wrapper deposit-ui">
                         <div class="transaction-wrapper profile-change">
                            <ul class="nav nav-pills mb-3 mt-3 justify-content-left" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="transaction-tab1" data-bs-toggle="pill"
                                        data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1"
                                        aria-selected="true">Transfer</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="transaction-tab2" data-bs-toggle="pill"
                                        data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2"
                                        aria-selected="false">Redeem</button>
                                </li>
                            </ul>
                        </div>



                            <div class="tab-content" id="pills-tabContent">

                                <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                    aria-labelledby="transaction-tab1">

                                    <div class="personal-info ">


                                     <div class="row align-items-center">
                                            <div class="col-md-12 col-lg-8">

                                               <form action="{{URL::to('doInterTransfer')}}" autocomplete="off" method="post" id="intertransfer" class="intertransfer">
                                                    {{ csrf_field() }}

                                                <div class="form-group mb-4">
                                                    <label class="content__space--extra--small">
                                                    <span class="swapbuyfromcurrency"></span>
                                                    <span>Balance: </span>
                                                    <span id="inetrtransferbalance" class="text-green-color text-bold"> 0.00000000 </span>
                                                    <span id="inetrtransfercurrency" style=" font-weight: bold;">  </span>
                                                </div>


                                                <div class="mb-4">
                                                    <label>Select Currency *</label>
                                                   <select class="select w-100" aria-label="Default select example" name="currency_id" id="swapbuypair" onchange="interCurrency(this);">
                                                        <option selected>Select Currency</option>

                                                        @php foreach ($currencyList as $key => $value) { @endphp
                                                            <option value="<?php echo $value->id; ?>" ><?php echo $value->symbol.' -'.$value->name; ?></option>
                                                           @php } @endphp
                                                     </select>
                                                    </div><br>
                                                      <div class="mb-4">
                                                        <label>Receiver Username *</label>
                                                        <input type="text" class="form-control"  name="transferusername" id="transferusername" placeholder="Receiver Name">
                                                      </div>
                                                      <div class="mb-4">
                                                        <label>Transfer Amount *</label>
                                                        <input type="text" class="form-control" name="amount" id="amount" required="required" onkeypress="return (event.charCode == 8 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" onkeyup="transferAmountKeyup(this)"placeholder="Transfer Amount">
                                                      </div>
                                                      <div class="mb-4">
                                                        <label>Security Code *</label>
                                                        <input type="password" class="form-control" name="withdrawcode" id="withdrawcode" placeholder="Security Pin">
                                                      </div>
                                                         @if(empty(user_details(userId(),'w_pin')))
                                                          <a href="{{URL::to('/')}}/profile" style="float:right">Set Reset Pin</a>
                                                          @endif


                                                     <button type="submit" name="transfersubmit" id="transfersubmit" class="theme-btn  mt-20 profile_btn">Submit<i class="far fa-sign-in"></i></button>
                                                      <button type="button" name="transferloader" id="transferloader" class="theme-btn mt-4 " style="display: none;">Loading ...</button>
                                                </form>

                                            </div>
                                            <div class="col-md-12 col-lg-4" >

                                                <div class="dashboard-widget1">
                                                    <div class="dashboard-widget-content">
                                                        <h5 class="Amount">Minimum Amount</h5>
                                                        <span id="minimum-amount">0.00000000</span>
                                                    </div>
                                                    <i class="flaticon-dollar"></i>
                                                </div>

                                                <hr class="bdr">
                                                 <div class="dashboard-widget1">
                                                    <div class="dashboard-widget-content">
                                                        <h5 class="Amount">Maximum Amount</h5>
                                                        <span id="maximum-amount">0.00000000</span>
                                                    </div>
                                                    <i class="flaticon-dollar"></i>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="tab-pane fade" id="tab2" role="tabpanel"
                                    aria-labelledby="transaction-tab2">

                                <div class="withdrawform">
                                    <form id="redeemtransfer" class="redeemtransfer" action="{{URL::to('doredeemtransfer')}}" autocomplete="off" method="post">
                                        {{ csrf_field() }}
                                    @if($redeemDataCount == '0')
                                        <h6 class="mt-2 text-center text-warning">No More Redeem Code Found</h6>
                                    @else
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label>Redeem Code *</label>
                                                <input type="password" class="form-control" name="redeemcode" id="redeemcode" placeholder="Redeem Code">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group mb-4">
                                                <label>Security Code *</label>
                                                <input type="password" class="form-control" name="redeemwithdrawcode" id="redeemwithdrawcode" placeholder="Security Pin">
                                            </div>
                                        </div>
                                    </div>

                                    @if(empty(user_details(userId(),'w_pin')))
                                    <a href="{{URL::to('/')}}/profile" style="float:right">Set Reset Pin</a>
                                    @endif


                                    <button type="submit" name="redeemsubmit" id="redeemsubmit" class="theme-btn  mt-20 profile_btn">Submit<i class="far fa-sign-in"></i></button>
                                    <button type="button" name="redeemloader" id="redeemloader" class="theme-btn mt-4 " style="display: none;">Loading ...</button>

                                    @endif

                                        </form>
                                </div>
                            </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



@include('user.common.footer')


