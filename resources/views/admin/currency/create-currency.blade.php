@include('admin.common.header')
@include('admin.common.sidebar')
<div class="page-wrapper" style="min-height: 373px;">
<div class="container-fluid">
   <!-- Title -->
   <div class="row heading-bg">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
         <h5 class="txt-dark">{{$title}}</h5>
      </div>
      <!-- Breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
         <ol class="breadcrumb">
            <li><a href="{{adminBaseurl()}}dashboard">Dashboard</a></li>
            <li><a href="{{adminBaseurl()}}currencySetting">Currency List</a></li>
            <li class="active"><span>{{$title}}</span></li>
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
                              <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Create currency</h6>
                              <hr class="light-grey-hr">
                              <div class="div-one">
                                 <form action="{{URL::to('/')}}/{{env('ADMIN_URL')}}/addcurrency" method="post" name="createcurrency" id="createcurrency" class="deposit-Form" novalidate="novalidate">
                                    {{ csrf_field() }}
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label class="control-label mb-10">Currency Name</label>
                                             <input type="text" id="name" name="name" class="form-control" value="" placeholder="Currency Name">
                                             <input type="hidden" id="currency_id" name="currency_id" class="form-control" value="" >


                                          </div>
                                       </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label mb-10">Withdraw status</label>
                                                <div class="radio-list">
                                                    <div class="radio-inline pl-0">
                                                        <span class="radio radio-info">
                                                            <input type="radio" name="withdraw_status" id="withdraw_status" value="1">
                                                            <label for="radio_5">Active</label>
                                                    </span>
                                                    </div>
                                                    <div class="radio-inline">
                                                        <span class="radio radio-info">
                                                            <input type="radio" name="withdraw_status" id="withdraw_status" value="2" >
                                                            <label for="radio_6">Deactive</label>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label id="withdraw_status-error" class="error" for="withdraw_status"></label>
                                        </div>


                                       </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label mb-10">Currency Symbol</label>
                                            <input type="text" id="symbol" name="symbol" class="form-control" value="" placeholder="Currency Symbol">
                                         </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label mb-10">Deposit status</label>
                                                <div class="radio-list">
                                                    <div class="radio-inline pl-0">
                                                        <span class="radio radio-info">
                                                            <input type="radio" name="deposit_status" id="deposit_status" value="1" >
                                                            <label for="radio_5">Active</label>
                                                    </span>
                                                    </div>
                                                    <div class="radio-inline">
                                                        <span class="radio radio-info">
                                                            <input type="radio" name="deposit_status" id="deposit_status" value="0" >
                                                            <label for="radio_6">Deactive</label>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label id="deposit_status-error" class="error" for="deposit_status"></label>
                                        </div>



                                    </div>
                                    <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                   <label class="control-label mb-10">Currency Type</label>
                                                   <select class="form-control" name="type" id="type"data-placeholder="Choose a Category" tabindex="1">
                                                      <option value="">Select option</option>
                                                      <option value="1">Crypt</option>
                                                      <option value="0">Fiat</option>
                                                   </select>
                                                </div>
                                             </div>

                                             <div class="col-md-6">
                                             <div class="form-group">
                                                <label class="control-label mb-10">Currency status</label>
                                                <div class="radio-list">
                                                    <div class="radio-inline pl-0">
                                                        <span class="radio radio-info">
                                                            <input type="radio" name="status" id="status" value="1">
                                                            <label for="radio_5">Active</label>
                                                    </span>
                                                    </div>
                                                    <div class="radio-inline">
                                                        <span class="radio radio-info">
                                                            <input type="radio" name="status" id="status" value="0" >
                                                            <label for="radio_6">Deactive</label>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label id="status-error" class="error" for="status"></label>
                                         </div>


                                    </div>


                                    <div class="row">


                                        <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="control-label mb-10">Decimal</label>
                                            <input type="number" id="decimal" name="decimal" class="form-control" value="" placeholder="Decimal">

                                         </div>
                                        </div>



                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label mb-10">Investment status</label>
                                                <div class="radio-list">
                                                    <div class="radio-inline pl-0">
                                                        <span class="radio radio-info">
                                                            <input type="radio" name="investment_status" id="investment_status" value="1">
                                                            <label for="radio_5">Active</label>
                                                    </span>
                                                    </div>
                                                    <div class="radio-inline">
                                                        <span class="radio radio-info">
                                                            <input type="radio" name="investment_status" id="investment_status" value="0" >
                                                            <label for="radio_6">Deactive</label>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>

                                     </div>

                                    </div>

                                    <div class="form-actions mt-10">
                                        <button type="" class="btn btn-success mr-10" id="btn-submit">Submit <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i></button>
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
      </div>
<!-- /Row -->
@include('admin.common.footer')
