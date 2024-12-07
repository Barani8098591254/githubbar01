@include('admin.common.header')
@include('admin.common.sidebar')





<div class="page-wrapper" style="min-height: 373px;">
    <div class="container-fluid">

        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h5 class="txt-dark">Edit Currency Settings</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                <li><a href="{{adminBaseurl()}}dashboard">Dashboard</a></li>
                <li><a href="{{adminBaseurl()}}currencySetting">Currency List</a></li>
                <li class="active"><span>Edit Currency Settings</span></li>

              </ol>
            </div>
            <!-- /Breadcrumb -->
        </div>


        <!-- Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default card-view">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">

                                        <div class="form-wrap">
                                                <div class="form-body">
                                                    <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Deposit currency</h6>
                                                    <hr class="light-grey-hr">
                                                    <div class="div-one">
                                            <form action="{{URL::to('/')}}/{{env('ADMIN_URL')}}/depositcurrencyupdate" method="post" name="depositForm" id="depositForm" class="deposit-Form" novalidate="novalidate">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">

                                                                {{-- <input type="text" id="id" name="id" class="form-control" value="{{$userid}}" readonly=""> --}}



                                             <label class="control-label mb-10">Currency Name</label>
                                                                <input type="text" id="name" name="name" class="form-control" value="{{$currencysetting->name}}" readonly="">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="currencyIdse" id="currencyIdse" value="{{encrypt_decrypt('encrypt',$currencysetting->id)}}">
                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Currency Symbol</label>
                                                                <input type="text" id="currency_symbol" name="currency_symbol" class="form-control" value="{{$currencysetting->symbol}}" readonly="">
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>

                                                    <!-- /Row -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Currency Type</label>
                                                                <select class="form-control valid" name="type" id="type" data-placeholder="Choose a Category" tabindex="1" aria-invalid="false">
                                                                    <option value="1" {{($currencysetting->type == 1) ? 'selected' : ''}} >crypto
                                                                    </option>
                                                                    <option value="0" {{($currencysetting->type == 0) ? 'selected' : ''}} >Fiat
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Deposit status </label>
                                                                <select class="form-control valid" name="deposit_status" id="deposit_status" data-placeholder="Choose a Category" tabindex="1" aria-invalid="false">
                                                                    <option value="1" {{($currencysetting->deposit_status == 1) ? 'selected' : ''}} >Active
                                                                    </option>
                                                                    <option value="2" {{($currencysetting->deposit_status == 2) ? 'selected' : ''}} >Inactive
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- /Row -->

                                                    <div class="form-actions mt-10">
                                                        <button type="submit" class="btn btn-success mr-10" id="btno-submit">Submit <i class="fa fa-spinner fa-spin" id="spino" style="font-size:20px; display:none;"></i></button>
                                                    </div>
                                                </form>
                                            </div>




                                                    <div class="seprator-block"></div>




                                                    <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account-box mr-10"></i>Withdraw Settings</h6>
                                                    <hr class="light-grey-hr">
                                                    <div class="div-two">
                                                <form action="{{URL::to('/')}}/{{env('ADMIN_URL')}}/withdrawcurrencyupdate" method="post" id="withdrawForm" name="withdrawForm" class="withdrawForm" novalidate="novalidate">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Currency Name ({{$currencysetting->symbol}})</label>
                                                                <input type="text" class="form-control" id="name" name="name" value="{{$currencysetting->name}}" placeholder="Currency Name">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="currencyIdw" id="currencyIdw" value="{{encrypt_decrypt('encrypt',$currencysetting->id)}}">



                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Currency Symbol({{$currencysetting->symbol}})</label>
                                                                <input type="text" class="form-control" id="symbol" name="symbol" value="{{$currencysetting->symbol}}" placeholder="Currency Symbol">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Withdraw Limit (Per Day)({{$currencysetting->symbol}})</label>
                                                                <input type="number" class="form-control" id="per_day_limit" name="per_day_limit" value="{{$currencysetting->per_day_limit}}" placeholder="Withdraw Limit">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Minimum Amount({{$currencysetting->symbol}})</label>
                                                                <input type="number" class="form-control" id="min" name="min" value="{{$currencysetting->min}}" placeholder="Minimum Amount">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Maximum Amount ({{$currencysetting->symbol}})</label>
                                                                <input type="number" class="form-control" id="max" name="max" value="{{$currencysetting->max}}" placeholder="Maximum Amount">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Fee Amount ({{$currencysetting->symbol}})</label>
                                                                <input type="number" class="form-control" id="fee" name="fee" value="{{$currencysetting->fee}}" placeholder="Fee Amount">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">USD Price ({{$currencysetting->symbol}})</label>
                                                                <input type="number" class="form-control" id="usdprice" name="usdprice" value="{{$currencysetting->usdprice}}" placeholder="USD Price">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Withdraw status </label>
                                                                <select class="form-control valid" name="withdraw_status" id="withdraw_status" data-placeholder="Choose a Category" tabindex="1" aria-invalid="false">
                                                                    <option value="1" {{($currencysetting->withdraw_status == 1) ? 'selected' : ''}} >Active
                                                                    </option>
                                                                    <option value="2" {{($currencysetting->withdraw_status == 2) ? 'selected' : ''}} >Inactive
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <div class="form-actions mt-10">
                                                    <button type="submit" class="btn btn-success mr-10" id="btn-submit">Submit <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i></button>
                                                </div>
                                            </form>
                                        </div>








                                        <div class="seprator-block"></div>



                                        <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-file-text mr-10"></i> InternalTransfer Settings</h6>

                                        <hr class="light-grey-hr">
                                        <div class="div-two">
                                    <form action="{{URL::to('/')}}/{{env('ADMIN_URL')}}/internaltransferamountupdate" method="post" id="internaltransferamount" name="internaltransferamount" class="internaltransferamount" novalidate="novalidate">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="currencyIdin" id="currencyIdin" value="{{encrypt_decrypt('encrypt',$currencysetting->id)}}">

                                        <div class="row">
                                            <div class="col-md-6">


                                                <div class="form-group">
                                                <label class="control-label mb-10">Min Amount ({{$currencysetting->symbol}})</label>
                                                <input type="number" class="form-control" id="Imin" name="Imin" value="{{$currencysetting->Imin}}" placeholder="Min Amount">
                                             </div>
                                            </div>


                                            <div class="col-md-6">



                                                <div class="form-group">
                                                    <label class="control-label mb-10">Max Amount ({{$currencysetting->symbol}})</label>
                                                    <input type="number" class="form-control" id="Imax" name="Imax" value="{{$currencysetting->Imax}}" placeholder="Max Amount">
                                                 </div>

                                            </div>


                                            </div>
                                        </div>

                                    <div class="form-actions mt-10">
                                        <button type="submit" class="btn btn-success mr-10" id="btn-submit">Submit <i class="fa fa-spinner fa-spin" id="spinc" style="font-size:20px; display:none;"></i></button>
                                    </div>
                                </form>
                            </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            <!-- /Row -->






@include('admin.common.footer')

