@include('admin.common.header')

<style>
    span.counter {
    font-size: 16px;
}
td.date-trim {
    white-space: nowrap;
}



</style>
@include('admin.common.sidebar')



      <!-- Main Content -->
      <div class="page-wrapper">



        <div class="row pa-30">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h5 class="txt-dark">Internal Reddem Data</h5>
                </div>
                <!-- Breadcrumb -->
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{admin_url()}}dashboard">Dashboard</a></li>
                        <li><a href="{{adminBaseurl()}}internalredeemhistory"><span>Internal redeem history</span></a></li>

                        <li class="active"><span>Internal Reddem Data</span></li>

                    </ol>
                </div>
            </div>
                <!-- /Breadcrumb -->



        <div class="container-fluid pt-25">

            <!-- Row -->
            <div class="row">
                <div class="col-lg-3 col-xs-12">
                    <div class="panel panel-default card-view  pa-0">

                    </div>
                </div>
                <div class="col-lg-12 col-xs-12">
                    <div class="panel panel-default card-view pa-0">
                        <div class="panel-wrapper collapse in">
                            <div  class="panel-body pb-0">
                                <div  class="tab-struct custom-tab-1">
                                    <ul role="tablist" class="" id="myTabs_8">
{{--
                                        <div class="mt-5">
                                        <button class="btn btn-primary mt-5">Back</button>
                                    </div> --}}
                                    </ul>
                                    <div class="tab-content" id="myTabContent_8">
                                        <div id="profile_8" class="tab-pane fade active in" role="tabpanel">
                                            <div class="col-md-12">
                                                <div class="pt-20">
                                                    <div class="streamline user-activity">


                                                      <h5 class="pb-45"> Internal Reddem Data </h5>
                                                        <div class="box-body">
                                                            <div class="row">
                                                                <input class="form-control" type="hidden" name="redeemId" value="591">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Currency Name :  </label>               <span>{{$userredeem->symbol}}</span>
                                                                    </div>
                                                                </div>


                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label ">Sender : </label>                    <span>{{$userredeem->fromUsername}}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label ">Receiver : </label>                  <span>{{$userredeem->toUsername}}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label ">Amount : </label>                      <span>{{$userredeem->toAmount}}</span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="control-label ">Status : </label>
                                                                        <span class="text-success">
                                                                            <?php if ($userredeem->status == '1') { ?>
                                                                                <span class="text-success">Completed</span>
                                                                            <?php } elseif ($userredeem->status == '0') { ?>
                                                                                <span class="text-warning">pending</span>
                                                                            <?php } else { ?>
                                                                                <span class="text-danger">rejected</span>
                                                                            <?php } ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                </div>



                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                         <?php if($userredeem->status == '0'){ ?>
                                                                           <button class="btn btn-danger">Cancel</button>
                                                                            <?php }else{ ?>

                                                                            <?php } ?> </span>



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
                    </div>


                </div>
            </div>
            <!-- /Row -->


            <!-- /Row -->
            @include('admin.common.footer')
