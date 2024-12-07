

@include('admin.common.header')
@include('admin.common.sidebar')


<div class="page-wrapper" style="min-height: 373px;">
    <div class="container-fluid">

        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h5 class="txt-dark">Currency Management</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                <li><a href="{{adminBaseurl()}}dashboard">Dashboard</a></li>
                <li><a href="{{adminBaseurl()}}currencyList">Currency List</a></li>
                <li class="active"><span>Edit Currency</span></li>

              </ol>
            </div>
            <!-- /Breadcrumb -->
        </div>


        <!-- Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default card-view">

                        <div class="panel-heading">
                            <div class="pull-left">
                                <h6 class="panel-title txt-dark">{{$title}}</h6>
                            </div>
                            <div class="clearfix"></div>
                        </div>



                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">

                                        <div class="form-wrap">
                                                <div class="form-body">
                                                    <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Edit currency</h6>
                                                    <hr class="light-grey-hr">
                                            <form action="{{URL::to('/')}}/{{env('ADMIN_URL')}}/update_currency" method="post" name="depositForm" id="depositForm" class="deposit-Form" novalidate="novalidate">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">

                                                                <label class="control-label mb-10">Currency Name</label>
                                                                <input type="text" id="name" name="name" class="form-control" value="{{$currencyDetails->name}}" readonly="">
                                                            </div>
                                                        </div>
                                                       <input type="hidden" name="currencyId" id="currencyId" value="{{$currencyId}}">

                                                       {{-- <input type="text" id="id" name="id" class="form-control" value="{{$userid}}" readonly=""> --}}

                                                        <!--/span-->


                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Withdraw status</label>
                                                                <div class="radio-list">
                                                                    <div class="radio-inline pl-0">
                                                                        <span class="radio radio-info">
                                                                            <input type="radio" name="Withdrawstatus" id="Withdrawstatus" value="1" {{($currencyDetails->withdraw_status == 1) ? 'checked' : '' }} >
                                                                            <label for="radio_5">Active</label>
                                                                    </span>
                                                                    </div>
                                                                    <div class="radio-inline">
                                                                        <span class="radio radio-info">
                                                                            <input type="radio" name="Withdrawstatus" id="Withdrawstatus" value="0" {{($currencyDetails->withdraw_status == 0) ? 'checked' : '' }} >
                                                                            <label for="radio_6">Deactive</label>
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!-- /Row -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Currency Symbol</label>
                                                                <input type="text" id="currency_symbol" name="currency_symbol" class="form-control" value="{{$currencyDetails->symbol}}" readonly="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Deposit status </label>
                                                                <div class="radio-list">
                                                                    <div class="radio-inline pl-0">
                                                                        <span class="radio radio-info">
                                                                            <input type="radio" name="depositstatus" id="depositstatus" value="1" {{($currencyDetails->deposit_status == 1) ? 'checked' : '' }} >
                                                                            <label for="radio_5">Active</label>
                                                                    </span>
                                                                    </div>
                                                                    <div class="radio-inline">
                                                                        <span class="radio radio-info">
                                                                            <input type="radio" name="depositstatus" id="depositstatus" value="0" {{($currencyDetails->deposit_status == 0) ? 'checked' : '' }} >
                                                                            <label for="radio_6">Inactive</label>
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                    </div>
                                                    <!-- /Row -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Currency Type</label>

                                                                <select class="form-control valid" name="currency_type" id="currency_type" data-placeholder="Choose a Category" tabindex="1" aria-invalid="false">
                                                                    <option value="0" {{($currencyDetails->type == 0) ? 'selected' : ''}}>crypto
                                                                    </option>
                                                                    <option value="1" {{($currencyDetails->type == 1) ? 'selected' : ''}}>Fiat
                                                                    </option>
                                                                </select>


                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">currency status </label>
                                                                <div class="radio-list">
                                                                    <div class="radio-inline pl-0">
                                                                        <span class="radio radio-info">
                                                                            <input type="radio" name="currencystatus" id="currencystatus" value="1" {{($currencyDetails->status == 1) ? 'checked' : '' }} >
                                                                    <label for="radio_5">Active</label>
                                                                    </span>
                                                                    </div>
                                                                    <div class="radio-inline">
                                                                        <span class="radio radio-info">
                                                                            <input type="radio" name="currencystatus" id="currencystatus" value="0" {{($currencyDetails->status == 0) ? 'checked' : '' }} >
                                                                    <label for="radio_6">Inactive</label>
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Usd Price</label>
                                                                <input type="text" id="usdprice" name="usdprice" class="form-control" value="{{$currencyDetails->usdprice}}">
                                                            </div>
                                                        </div>
                                                        <!--/span-->

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Investment status </label>
                                                                <div class="radio-list">
                                                                    <div class="radio-inline pl-0">
                                                                        <span class="radio radio-info">
                                                                            <input type="radio" name="investment_status" id="investment_status" value="1" {{($currencyDetails->investment_status == 1) ? 'checked' : '' }} >
                                                                    <label for="radio_5">Active</label>
                                                                    </span>
                                                                    </div>
                                                                    <div class="radio-inline">
                                                                        <span class="radio radio-info">
                                                                            <input type="radio" name="investment_status" id="investment_status" value="0" {{($currencyDetails->investment_status == 0) ? 'checked' : '' }} >
                                                                    <label for="radio_6">Inactive</label>
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>


                                                    <div class="form-actions mt-10">
                                                        <button type="submit" class="btn btn-success mr-10" id="btno-submit">Submit <i class="fa fa-spinner fa-spin" id="spino" style="font-size:20px; display:none;"></i></button>
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
            </div>
            <!-- /Row -->


















@include('admin.common.footer')

