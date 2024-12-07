@include('admin.common.header')

@include('admin.common.sidebar')


<!-- Main Content -->
<div class="page-wrapper">
    <div class="container-fluid">
        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h5 class="txt-dark">{{$head}}</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                <li><a href="dashboard">Dashboard</a></li>
                <li class="active"><span>{{$title}}</span></li>
              </ol>
            </div>
            <!-- /Breadcrumb -->
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-sm-12">
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
                                <div class="col-md-12">
                                    <div class="form-wrap">
                                        <form action="setting" class="form-horizontal setting_form" name="setting_form" id="setting_form" method="post" >
                                            @csrf
                                            <div class="form-body">
                                                <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account-box mr-10"></i>{{$title}}</h6>
                                                <hr class="light-grey-hr">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">SiteName </label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="sitename" id="sitename" value="{{$setting->sitename}}" placeholder="SiteName">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Email</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="contactmail" id="contactmail" value="{{$setting->contactmail}}" placeholder="Email">
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Phone Number</label>
                                                            <div class="col-md-9">
                                                                <input type="number" class="form-control" name="contactnumber" id="contactnumber" value="{{$setting->contactnumber}}" placeholder="Phone Number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Address</label>
                                                            <div class="col-md-9">
                                                                <textarea class="form-control" name="contactaddress" id="contactaddress" placeholder="Address">{{$setting->contactaddress}} </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                       <div class="form-group">
                                                           <label class="control-label col-md-3">Kyc status</label>
                                                           <div class="col-md-9">
                                                               <select class="form-control" name="kyc"
                                                               id="kyc"data-placeholder="Choose a Category"
                                                               tabindex="1">
                                                               <option <?php echo ($setting->kyc == 1) ? 'selected' : ''; ?> value="1">Enable
                                                               </option>
                                                               <option <?php echo ($setting->kyc == 2) ? 'selected' : ''; ?> value="2">Disable
                                                               </option>

                                                           </select>                                                            </div>
                                                       </div>
                                                   </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">withdraw status </label>
                                                        <div class="col-md-9">
                                                            <select class="form-control" name="withdraw"
                                                            id="withdraw"data-placeholder="Choose a Category"
                                                            tabindex="1">
                                                            <option <?php echo ($setting->withdraw == 1) ? 'selected' : ''; ?> value="1">Enable
                                                            </option>
                                                            <option <?php echo ($setting->withdraw == 2) ? 'selected' : ''; ?> value="2">Disable
                                                            </option>

                                                        </select>                </div>
                                                    </div>
                                                </div>


                                               </div>


                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">MLM </label>
                                                            <div class="col-md-9">
                                                                <select class="form-control" name="mlm"
                                                                id="mlm"data-placeholder="Choose a Category"
                                                                tabindex="1">
                                                                <option <?php echo ($setting->mlm == 1) ? 'selected' : ''; ?> value="1">Binary
                                                                </option>
                                                                <option <?php echo ($setting->mlm == 2) ? 'selected' : ''; ?> value="2">Uni-level
                                                                </option>
                                                                <option <?php echo ($setting->mlm == 3) ? 'selected' : ''; ?> value="3">Forced
                                                                </option>
                                                            </select>                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">copyright </label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="copyright" id="copyright" value="{{$setting->copyright}}" placeholder="copyright">
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                                 <div class="row">


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Site UnderMaintenance </label>
                                                            <div class="col-md-9">
                                                                <select class="form-control" name="site_status"
                                                                    id="site_status"data-placeholder="Choose a Category"
                                                                    tabindex="1">
                                                                    <option <?php echo ($setting->maintanance == 1) ? 'selected' : ''; ?> value="1">Yes
                                                                    </option>
                                                                    <option <?php echo ($setting->maintanance == 0) ? 'selected' : ''; ?> value="0">No
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Maintanance Content</label>
                                                            <div class="col-md-9">
                                                                 <textarea class="form-control" name="maintanance_content" id="maintanance_content" placeholder="Maintanance Content
                                                                 ">{{$setting->maintanance_content}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>





                                                <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account-box mr-10" ></i>Social Media Links</h6>
                                                <hr class="light-grey-hr">


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Facebook Links</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control"  name="fblink" id="fblink" value="{{$setting->fblink}}" placeholder="Facebook Links">
                                                              </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Twitter links</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="twitterlink" id="twitterlink" value="{{$setting->twitterlink}}" placeholder="Twitter links">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Instagram Links</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="instainlink" id="instainlink" value="{{$setting->instainlink}}" placeholder="instainlink">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">Telegram Lnks</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" name="telegramlink" id="telegramlink" value="{{$setting->telegramlink}}" placeholder="Telegram Lnks">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions mt-10">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="" class="btn btn-success mr-10" id="btn-submit">Submit <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i></button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6"> </div>
                                                </div>
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




@include('admin.common.footer')


