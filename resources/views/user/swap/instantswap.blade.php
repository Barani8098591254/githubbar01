
@include('user.common.header')


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
                                        aria-selected="true">Buy</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="transaction-tab2" data-bs-toggle="pill"
                                        data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2"
                                        aria-selected="false">Sell</button>
                                </li>
                            </ul>
                        </div>
                            <div class="tab-content" id="pills-tabContent">

                                <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                    aria-labelledby="transaction-tab1">

                                    <div class="dashboard-widget-wrapper mb-4">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-3">
                                                <div class="dashboard-widget">
                                                    <div class="dashboard-widget-content">
                                                        <h5>From Currency Balance</h5>
                                                        <span class="" id="swapbuyfrombalance">0.00000000</span>
                                                        <span class="swapbuyfromcurrency" id="swapbuyfromcurrency"></span>
                                                    </div>
                                                    <i class="flaticon-world"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="dashboard-widget">
                                                    <div class="dashboard-widget-content">
                                                        <h5>To Currency Balance</h5>
                                                        <span class="" id="swapbuytobalance">0.00000000</span>
                                                        <span class="swapbuytocurrency" id="swapbuytocurrency"></span>
                                                    </div>
                                                    <i class="flaticon-world"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="dashboard-widget">
                                                    <div class="dashboard-widget-content">
                                                        <h5>Miminum Amount</h5>
                                                        <span id="swapbuymin"> 0.00000000</span>
                                                        <span class="swapbuytocurrency" id="swapbuytocurrency"></span>
                                                    </div>
                                                    <i class="flaticon-wallet"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-3">
                                                <div class="dashboard-widget">
                                                    <div class="dashboard-widget-content">
                                                        <h5>Maximum Amount</h5>
                                                        <span id="swapbuymax">0.00000000</span>
                                                         <span class="swapbuytocurrency" id="swapbuytocurrency"></span>
                                                    </div>
                                                    <i class="flaticon-dollar"></i>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="withdrawform">

                                        <div class="row align-items-start">
                                            <div class="col-md-12 col-lg-8">
                                            <form class="buyswap" id="buyswap" method="post" action="{{URL::to('/')}}/swapbuy" autocomplete="off">
                                                    {{ csrf_field() }}

                                                    <label for="exampleInputcurrency">Select Pair<span class="reqfi mx-1">*</span></label>
                                                   <select class="form-select mb-4 curr" aria-label="Default select example" name="pair_id" id="swapbuypair" onchange="buyPair(this);">
                                                            <option value="">Select Pair</option>

                                                            @php foreach ($currencyList as $key => $value) { @endphp
                                                                <option value="<?php echo $value->id; ?>" ><?php echo $value->symbol.''.$value->pair; ?></option>
                                                               @php } @endphp
                                                   </select>

                                                   <div class="afterSelectPair" style="display: none;">
                                                   <div class="input__area text-start content__space alt afterSelectPair" >
                                                    <label class="content__space--extra--small"> <span class="text-green-color text-bold">1</span> <span class="swapbuyfromcurrency"></span> = <b><span id="swapbuymarketprice" class="text text-success">0.000000</span></b> <b><span class="swapbuytocurrency"></span></b></label>
                                                   </div>

                                                    <input type="hidden" name="type" id="type" value="buy">
                                                    <input type="hidden" name="marketPrice" id="marketPrice">
                                                    <input type="hidden" name="swapbuyfee" id="swapbuyfee">


                                                      <div class="row afterSelectPair">
                                                      <div class="col-md-12 col-lg-6">
                                                        <div class="">
                                                            <label for="exampleInputcurrency">I have <span class="swapbuyfromcurrency" id="swapbuyfromcurrency">*</span></label>

                                                            <input type="text" class="form-control w-100" name="fromAmount" id="fromAmount" onkeypress="return (event.charCode == 8 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" onkeyup="buyFromKeyup(this)"/>
                                                          </div>

                                                      </div>
                                                      <div class="col-md-12 col-lg-6">
                                                        <label for="exampleInputcurrency">I want <span class="swapbuytocurrency" id="swapbuytocurrency">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-append">
                                                              </div>
                                                              <input type="text"  name="toAmount" id="toAmount"class="form-control w-100"  onkeypress="return (event.charCode == 8 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" onkeyup="buyToKeyup(this)"/>
                                                          </div>
                                                      </div>
                                                    </div>
                                                    <div class="plan-ratee">
                                                    <div class="submtibtn mt-3 afterSelectPair">
                                                            <a href="void:javascript(0)" class="themee-btn afterSelectPair" onclick="buyamountPercentage('25');">25%</a>
                                                            <a href="void:javascript(0)" class="themee-btn afterSelectPair" onclick="buyamountPercentage('50');">50%</a>
                                                            <a href="void:javascript(0)" class="themee-btn afterSelectPair" onclick="buyamountPercentage('75');">75%</a>
                                                            <a href="void:javascript(0)" class="themee-btn afterSelectPair" onclick="buyamountPercentage('100');">Max</a>
                                                    </div>
                                                   </div>
                                                   <div class="submtibtn mt-4">
                                                    {{-- <a href="" class="theme-btn">Swap</a> --}}
                                                    <button type="submit" name="buyswapsubmit" id="buyswapsubmit" class="theme-btn mt-20 afterSelectPair">Swap</button>

                                                    <button type="button" name="buyswaploader" id="buyswaploader" class="theme-btn mt-4 " style="display: none;">Loading ...</button>
                                                </div>
                                            </div>
                                        </form>
                                            </div>
                                            <div class="col-md-12 col-lg-4">
                                                <div class="dashboard-widget1">
                                                    <div class="dashboard-widget-content">
                                                        <h5>Fee Amount</h5>
                                                        <label class="content__space--extra--small"><span id="swapbuyfeeamount"> 0.00000000 </span> <span class="swapbuyfromcurrency"> </span> </label>
                                                    </div>
                                                    <i class="flaticon-dollar"></i>
                                                </div>
                                                <hr class="bdr">
                                                <div class="dashboard-widget1">
                                                    <div class="dashboard-widget-content">
                                                        <h5>Receive Amount</h5>
                                                        <label class="content__space--extra--small"><span id="swapbuyrecevieamount"> 0.00000000 </span> <span class="swapbuyfromcurrency"> </span> </label>
                                                    </div>
                                                    <i class="flaticon-dollar"></i>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>






                                <div class="tab-pane fade" id="tab2" role="tabpanel"
                                    aria-labelledby="transaction-tab2">

                                <div class="dashboard-widget-wrapper mb-4">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div class="dashboard-widget-content">
                                                    <h5>From Currency Balance</h5>
                                                    <span class="" id="swapsellfrombalance">0.00000000</span>
                                                    <span class="swapsellfromcurrency" id="swapsellfromcurrency"></span>
                                                </div>
                                                <i class="flaticon-world"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div class="dashboard-widget-content">
                                                    <h5>To Currency Balance</h5>
                                                    <span class="" id="swapselltobalance">0.00000000</span>
                                                    <span class="swapselltocurrency" id="swapselltocurrency"></span>
                                                </div>
                                                <i class="flaticon-world"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div class="dashboard-widget-content">
                                                    <h5>Miminum Amount</h5>
                                                    <span id="swapsellmin"> 0.00001</span>
                                                    <span class="swapselltocurrency" id="swapselltocurrency"></span>
                                                </div>
                                                <i class="flaticon-wallet"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div class="dashboard-widget-content">
                                                    <h5>Maximum Amount</h5>
                                                    <span id="swapsellmax">0.00000000</span>
                                                     <span class="swapselltocurrency" id="swapselltocurrency"></span>
                                                </div>
                                                <i class="flaticon-dollar"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="withdrawform">

                                    <div class="row align-items-start">
                                        <div class="col-md-12 col-lg-8">
                                        <form class="sellswap" id="sellswap" method="post" action="{{URL::to('/')}}/swapsell" autocomplete="off">
                                                {{ csrf_field() }}

                                                <label for="exampleInputcurrency">Select Pair<span class="reqfi mx-1">*</span></label>

                                               <select class="form-select mb-4 curr" aria-label="Default select example" name="pair_id" id="swapbuypair" onchange="sellPair(this);">

                                                        <option value="">Select Pair</option>

                                                        @php foreach ($currencyList as $key => $value) { @endphp
                                                            <option value="<?php echo $value->id; ?>" ><?php echo $value->symbol.''.$value->pair; ?></option>
                                                           @php } @endphp
                                               </select>

                                               <div class="afterSelectPairSell" style="display: none;">
                                               <div class="input__area text-start content__space alt afterSelectPairSell" >
                                                <label class="content__space--extra--small"> <span class="text-green-color text-bold">1</span> <span class="swapsellfromcurrency">BTC</span> = <span id="swapsellmarketprice" class="text text-success">27881.14098</span> <span class="swapselltocurrency">USD</span></label>
                                               </div>

                                                <input type="hidden" name="type" id="type" value="sell">
                                                <input type="hidden" name="marketPrice" id="marketPrice">
                                                <!-- <input type="hidden" name="swapbuyfee" id="swapbuyfee"> -->
                                                <input type="hidden" name="swapsellfee" id="swapsellfee">


                                                  <div class="row afterSelectPairSell">
                                                  <div class="col-md-12 col-lg-6">
                                                    <div class="">
                                                        <label for="exampleInputcurrency">I have <span class="swapsellfromcurrency">*</span></label>
                                                        <input type="text" class="form-control w-100" name="sellfromAmount" id="sellfromAmount" onkeypress="return (event.charCode == 8 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" onkeyup="sellFromKeyup(this)"/>
                                                      </div>
                                                  </div>
                                                  <div class="col-md-12 col-lg-6">
                                                    <label for="exampleInputcurrency">I want <span class="swapselltocurrency" id="" >*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-append">
                                                          </div>
                                                          <input type="text" class="form-control w-100" name="selltoAmount" id="selltoAmount" required="required" onkeypress="return (event.charCode == 8 || event.charCode == 46) ? null : event.charCode >= 48 && event.charCode <= 57" onkeyup="sellToKeyup(this)"/>
                                                      </div>
                                                  </div>
                                                </div>
                                                <div class="plan-ratee">


                                                <div class="submtibtn mt-3 afterSelectPairSell">

                                                        <a href="void:javascript(0)" class="themee-btn afterSelectPairSell" onclick="sellamountPercentage('25');">25%</a>
                                                        <a href="void:javascript(0)" class="themee-btn afterSelectPairSell" onclick="sellamountPercentage('50');">50%</a>
                                                        <a href="void:javascript(0)" class="themee-btn afterSelectPairSell" onclick="sellamountPercentage('75');">75%</a>
                                                        <a href="void:javascript(0)" class="themee-btn afterSelectPairSell" onclick="sellamountPercentage('100');">Max</a>
                                                </div>
                                               </div>
                                               <div class="submtibtn mt-4">
                                                {{-- <a href="" class="theme-btn">Swap</a> --}}
                                                <button type="submit" name="sellswapsubmit" id="sellswapsubmit" class="theme-btn mt-20 ">Swap</button>

                                                <button type="button" name="sellswaploader" id="sellswaploader" class="theme-btn mt-4" style="display: none;">Loading ...</button>
                                            </div>
                                        </div>
                                    </form>
                                        </div>
                                        <div class="col-md-12 col-lg-4">
                                            <div class="dashboard-widget1">
                                                <div class="dashboard-widget-content">
                                                    <h5>Fee Amount</h5>
                                                    <label class="content__space--extra--small"><span id="swapsellfeeamount"> 0.00000000 </span> <span class="swapselltocurrency"> </span> </label>
                                                </div>
                                                <i class="flaticon-dollar"></i>
                                            </div>
                                            <hr class="bdr">
                                            <div class="dashboard-widget1">
                                                <div class="dashboard-widget-content">
                                                    <h5>Receive Amount</h5>
                                                    <label class="content__space--extra--small"><span id="swapsellrecevieamount"> 0.00000000 </span> <span class="swapselltocurrency"> </span> </label>
                                                </div>
                                                <i class="flaticon-dollar"></i>
                                            </div>
                                        </div>

                                    </div>
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



<script>
      $(document).ready(function(){
        $("#sellswap").validate({
          rules: {
            swapsellpair: {
              required: true,
            },
            sellfromAmount: {
              required: true,
            },
            selltoAmount: {
              required: true,
            },
          },
          messages : {
            swapsellpair : {
              required : "Pair is required"
            },
            sellfromAmount: {
              required : "From amount is required",
            },
            selltoAmount: {
              required : "To amount is required",
            },
          },
          submitHandler: function(form) {
            $("#sellswapsubmit").hide();
            $("#sellswaploader").show();
            form.submit();
          },
        });
    });
</script>
