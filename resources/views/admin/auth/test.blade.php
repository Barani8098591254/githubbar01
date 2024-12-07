@include('admin.common.header')
@include('admin.common.sidebar')


<div class="page-wrapper" style="min-height: 547px;">
    <div class="container-fluid pt-25">
        <!-- Row -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <a href="{{adminBaseurl()}}usersList">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$totalUsers}}</span></span>
                                            <span class="weight-500 uppercase-font block font-13">Total users</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="icon-user data-right-rep-icon txt-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <a href="{{adminBaseurl()}}activeuser">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$activeUser}}</span></span>
                                            <span class="weight-500 uppercase-font block font-13">Active users</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="icon-user-following data-right-rep-icon txt-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <a href="{{adminBaseurl()}}Inactiveuser">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$inactive}}</span></span>
                                            <span class="weight-500 uppercase-font block">Inactive users</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="data-right-rep-icon icon-user-follow txt-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">

                                            <a href="{{adminBaseurl()}}depositHistory">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$totalDeposit}}</span></span>
                                            <span class="weight-500 uppercase-font block">Deposit History</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="icon-layers data-right-rep-icon txt-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">

                                            <a href="{{adminBaseurl()}}support">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$totalSupport}}</span></span>
                                            <span class="weight-500 uppercase-font block">Support</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 pt-25  data-wrap-right">
                                            <div id="sparkline_4" style="width: 100px; overflow: hidden; margin: 0px auto;"><canvas width="115" height="50" style="display: inline-block; width: 115px; height: 50px; vertical-align: top;"></canvas></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">

                                            <a href="{{adminBaseurl()}}support">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$totalSupport}}</span></span>
                                            <span class="weight-500 uppercase-font block">Support</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="data-right-rep-icon icon-call-in txt-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">

                                            <a href="{{adminBaseurl()}}pendingkyc">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$pendingkyc}}</span></span>
                                            <span class="weight-500 uppercase-font block">Pending Kyc </span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="data-right-rep-icon icon-grid txt-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">

                                            <a href="{{adminBaseurl()}}KycApproved">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$approvedkyc}}</span></span>
                                            <span class="weight-500 uppercase-font block">KYC Approved</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="data-right-rep-icon icon-map txt-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">

                                            <a href="{{adminBaseurl()}}rejctkyc">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$rejectedkyc}}</span></span>
                                            <span class="weight-500 uppercase-font block">KYC Rejected</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="data-right-rep-icon icon-disc txt-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">

                                            <a href="{{adminBaseurl()}}levelCommission">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$completelevelcommission}}</span></span>
                                            <span class="weight-500 uppercase-font block">Level Commission</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="data-right-rep-icon fa fa-dollar txt-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">

                                            <a href="{{adminBaseurl()}}directCommission">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$completedirectcommission}}</span></span>
                                            <span class="weight-500 uppercase-font block">Direct Commission</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="data-right-rep-icon fa fa-dollar txt-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">

                                            <a href="{{adminBaseurl()}}roiCommission">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$completeroi}}</span></span>
                                            <span class="weight-500 uppercase-font block">ROI Commission</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="data-right-rep-icon fa fa-dollar txt-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">

                                            <a href="{{adminBaseurl()}}withdrawpending">

                                            <span class="txt-dark block counter"><span class="counter-anim">{{$pendingwithdraw}}</span></span>
                                            <span class="weight-500 uppercase-font block">Withdraw Pending</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="data-right-rep-icon fa fa-bank txt-grey"></i>
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

        <!-- Row -->
        <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">user statistics</h6>
                        </div>
                        <div class="pull-right">
                            {{-- <span class="no-margin-switcher">
                                <input type="checkbox" checked="" id="morris_switch" class="js-switch" data-color="#2ecd99" data-secondary-color="#dedede" data-size="small" data-switchery="true" style="display: none;"><span class="switchery switchery-small" style="background-color: rgb(46, 205, 153); border-color: rgb(46, 205, 153); box-shadow: rgb(46, 205, 153) 0px 0px 0px 11px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"><small style="left: 13px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"></small></span>
                            </span> --}}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div id="area_chart" class="morris-chart" style="height: 293px; position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><svg height="293" version="1.1" width="733" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.2.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="34.640625" y="251" text-anchor="end" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><text x="34.640625" y="194.5" text-anchor="end" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">75</tspan></text><text x="34.640625" y="138" text-anchor="end" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">150</tspan></text><text x="34.640625" y="81.5" text-anchor="end" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">225</tspan></text><text x="34.640625" y="25" text-anchor="end" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">300</tspan></text><text x="708" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Sat</tspan></text><text x="597.8567708333334" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Fri</tspan></text><text x="487.7135416666667" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Thu</tspan></text><text x="377.5703125" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Wed</tspan></text><text x="267.42708333333337" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Tue</tspan></text><text x="157.28385416666669" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Mon</tspan></text><text x="47.140625" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Son</tspan></text><path fill="#5bd2ab" stroke="none" d="M47.140625,243.46666666666667C74.67643229166667,220.86666666666667,129.748046875,159.65833333333333,157.28385416666669,153.06666666666666C184.81966145833337,146.475,239.89127604166669,185.08333333333334,267.42708333333337,190.73333333333335C294.962890625,196.38333333333335,350.03450520833337,207.6833333333333,377.5703125,198.26666666666665C405.1061197916667,188.85,460.177734375,118.69583333333334,487.7135416666667,115.4C515.2493489583334,112.10416666666667,570.3209635416667,178.49166666666667,597.8567708333334,171.9C625.392578125,165.30833333333334,680.4641927083334,89.97500000000002,708,62.666666666666686L708,251L47.140625,251Z" fill-opacity="0.6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0.6;"></path><path fill="none" stroke="#2ecd99" d="M47.140625,243.46666666666667C74.67643229166667,220.86666666666667,129.748046875,159.65833333333333,157.28385416666669,153.06666666666666C184.81966145833337,146.475,239.89127604166669,185.08333333333334,267.42708333333337,190.73333333333335C294.962890625,196.38333333333335,350.03450520833337,207.6833333333333,377.5703125,198.26666666666665C405.1061197916667,188.85,460.177734375,118.69583333333334,487.7135416666667,115.4C515.2493489583334,112.10416666666667,570.3209635416667,178.49166666666667,597.8567708333334,171.9C625.392578125,165.30833333333334,680.4641927083334,89.97500000000002,708,62.666666666666686" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="47.140625" cy="243.46666666666667" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="157.28385416666669" cy="153.06666666666666" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="267.42708333333337" cy="190.73333333333335" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="377.5703125" cy="198.26666666666665" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="487.7135416666667" cy="115.4" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="597.8567708333334" cy="171.9" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="708" cy="62.666666666666686" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="#89bbe8" stroke="none" d="M47.140625,190.73333333333335C74.67643229166667,186.9666666666667,129.748046875,170.95833333333334,157.28385416666669,175.66666666666669C184.81966145833337,180.37500000000003,239.89127604166669,237.81666666666666,267.42708333333337,228.4C294.962890625,218.98333333333335,350.03450520833337,102.21666666666667,377.5703125,100.33333333333334C405.1061197916667,98.45,460.177734375,210.50833333333335,487.7135416666667,213.33333333333334C515.2493489583334,216.15833333333333,570.3209635416667,132.35,597.8567708333334,122.93333333333334C625.392578125,113.51666666666668,680.4641927083334,134.23333333333335,708,138L708,251L47.140625,251Z" fill-opacity="0.6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0.6;"></path><path fill="none" stroke="#4e9de6" d="M47.140625,190.73333333333335C74.67643229166667,186.9666666666667,129.748046875,170.95833333333334,157.28385416666669,175.66666666666669C184.81966145833337,180.37500000000003,239.89127604166669,237.81666666666666,267.42708333333337,228.4C294.962890625,218.98333333333335,350.03450520833337,102.21666666666667,377.5703125,100.33333333333334C405.1061197916667,98.45,460.177734375,210.50833333333335,487.7135416666667,213.33333333333334C515.2493489583334,216.15833333333333,570.3209635416667,132.35,597.8567708333334,122.93333333333334C625.392578125,113.51666666666668,680.4641927083334,134.23333333333335,708,138" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="47.140625" cy="190.73333333333335" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="157.28385416666669" cy="175.66666666666669" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="267.42708333333337" cy="228.4" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="377.5703125" cy="100.33333333333334" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="487.7135416666667" cy="213.33333333333334" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="597.8567708333334" cy="122.93333333333334" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="708" cy="138" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="#eed380" stroke="none" d="M47.140625,235.93333333333334C74.67643229166667,224.63333333333333,129.748046875,195.4416666666667,157.28385416666669,190.73333333333335C184.81966145833337,186.025,239.89127604166669,203.91666666666666,267.42708333333337,198.26666666666665C294.962890625,192.61666666666665,350.03450520833337,152.125,377.5703125,145.53333333333333C405.1061197916667,138.94166666666666,460.177734375,139.88333333333333,487.7135416666667,145.53333333333333C515.2493489583334,151.18333333333334,570.3209635416667,196.38333333333335,597.8567708333334,190.73333333333335C625.392578125,185.08333333333334,680.4641927083334,122.93333333333334,708,100.33333333333334L708,251L47.140625,251Z" fill-opacity="0.6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0.6;"></path><path fill="none" stroke="#f0c541" d="M47.140625,235.93333333333334C74.67643229166667,224.63333333333333,129.748046875,195.4416666666667,157.28385416666669,190.73333333333335C184.81966145833337,186.025,239.89127604166669,203.91666666666666,267.42708333333337,198.26666666666665C294.962890625,192.61666666666665,350.03450520833337,152.125,377.5703125,145.53333333333333C405.1061197916667,138.94166666666666,460.177734375,139.88333333333333,487.7135416666667,145.53333333333333C515.2493489583334,151.18333333333334,570.3209635416667,196.38333333333335,597.8567708333334,190.73333333333335C625.392578125,185.08333333333334,680.4641927083334,122.93333333333334,708,100.33333333333334" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="47.140625" cy="235.93333333333334" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="157.28385416666669" cy="190.73333333333335" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="267.42708333333337" cy="198.26666666666665" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="377.5703125" cy="145.53333333333333" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="487.7135416666667" cy="145.53333333333333" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="597.8567708333334" cy="190.73333333333335" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="708" cy="100.33333333333334" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle></svg><div class="morris-hover morris-default-style" style="left: 118.284px; top: 86px; display: none;"><div class="morris-hover-row-label">Mon</div><div class="morris-hover-point" style="color: #2ecd99">
iphone:
130
</div><div class="morris-hover-point" style="color: #4e9de6">
ipad:
100
</div><div class="morris-hover-point" style="color: #f0c541">
itouch:
80
</div></div></div>
                            <ul class="flex-stat mt-40">
                                <li>
                                    <span class="block">Weekly Users</span>
                                    <span class="block txt-dark weight-500 font-18"><span class="counter-anim">324,222</span></span>
                                </li>
                                <li>
                                    <span class="block">Monthly Users</span>
                                    <span class="block txt-dark weight-500 font-18"><span class="counter-anim">123,432</span></span>
                                </li>
                                <li>
                                    <span class="block">Trend</span>
                                    <span class="block">
                                        <i class="zmdi zmdi-trending-up txt-success font-24"></i>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body sm-data-box-1">
                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">customer satisfaction</span>
                            <div class="cus-sat-stat weight-500 txt-success text-center mt-5">
                                <span class="counter-anim">93.13</span><span>%</span>
                            </div>
                            <div class="progress-anim mt-20">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success wow animated progress-animated" role="progressbar" aria-valuenow="93.12" aria-valuemin="0" aria-valuemax="100" style="width: 93.12%;"></div>
                                </div>
                            </div>
                            <ul class="flex-stat mt-5">
                                <li>
                                    <span class="block">Previous</span>
                                    <span class="block txt-dark weight-500 font-15">79.82</span>
                                </li>
                                <li>
                                    <span class="block">% Change</span>
                                    <span class="block txt-dark weight-500 font-15">+14.29</span>
                                </li>
                                <li>
                                    <span class="block">Trend</span>
                                    <span class="block">
                                        <i class="zmdi zmdi-trending-up txt-success font-20"></i>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">browser stats</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block mr-15">
                                <i class="zmdi zmdi-download"></i>
                            </a>
                            <a href="#" class="pull-left inline-block close-panel" data-effect="fadeOut">
                                <i class="zmdi zmdi-close"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div>
                                <span class="pull-left inline-block capitalize-font txt-dark">
                                    google chrome
                                </span>
                                <span class="label label-warning pull-right">50%</span>
                                <div class="clearfix"></div>
                                <hr class="light-grey-hr row mt-10 mb-10">
                                <span class="pull-left inline-block capitalize-font txt-dark">
                                    mozila firefox
                                </span>
                                <span class="label label-danger pull-right">10%</span>
                                <div class="clearfix"></div>
                                <hr class="light-grey-hr row mt-10 mb-10">
                                <span class="pull-left inline-block capitalize-font txt-dark">
                                    Internet explorer
                                </span>
                                <span class="label label-success pull-right">30%</span>
                                <div class="clearfix"></div>
                                <hr class="light-grey-hr row mt-10 mb-10">
                                <span class="pull-left inline-block capitalize-font txt-dark">
                                    safari
                                </span>
                                <span class="label label-primary pull-right">10%</span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
               <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Visit by Traffic Types</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block refresh mr-15">
                                <i class="zmdi zmdi-replay"></i>
                            </a>
                            <div class="pull-left inline-block dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Devices</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>General</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>Referral</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
                                <canvas id="chart_6" height="191" width="342" style="display: block; width: 342px; height: 191px;"></canvas>
                            </div>
                            <hr class="light-grey-hr row mt-10 mb-15">
                            <div class="label-chatrs">
                                <div class="">
                                    <span class="clabels clabels-lg inline-block bg-blue mr-10 pull-left"></span>
                                    <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left"><span class="block font-15 weight-500 mb-5">44.46% organic</span><span class="block txt-grey">356 visits</span></span>
                                    <div id="sparkline_1" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;"><canvas width="100" height="35" style="display: inline-block; width: 100px; height: 35px; vertical-align: top;"></canvas></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <hr class="light-grey-hr row mt-10 mb-15">
                            <div class="label-chatrs">
                                <div class="">
                                    <span class="clabels clabels-lg inline-block bg-green mr-10 pull-left"></span>
                                    <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left"><span class="block font-15 weight-500 mb-5">5.54% Refrral</span><span class="block txt-grey">36 visits</span></span>
                                    <div id="sparkline_2" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;"><canvas width="100" height="35" style="display: inline-block; width: 100px; height: 35px; vertical-align: top;"></canvas></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <hr class="light-grey-hr row mt-10 mb-15">
                            <div class="label-chatrs">
                                <div class="">
                                    <span class="clabels clabels-lg inline-block bg-yellow mr-10 pull-left"></span>
                                    <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left"><span class="block font-15 weight-500 mb-5">50% Other</span><span class="block txt-grey">245 visits</span></span>
                                    <div id="sparkline_3" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;"><canvas width="100" height="35" style="display: inline-block; width: 100px; height: 35px; vertical-align: top;"></canvas></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->

        <!-- Row -->
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">social campaigns</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block refresh mr-15">
                                <i class="zmdi zmdi-replay"></i>
                            </a>
                            <a href="#" class="pull-left inline-block full-screen mr-15">
                                <i class="zmdi zmdi-fullscreen"></i>
                            </a>
                            <div class="pull-left inline-block dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Edit</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Delete</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>New</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row pa-0">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Campaign</th>
                                                <th>Client</th>
                                                <th>Changes</th>
                                                <th>Budget</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="txt-dark weight-500">Facebook</span></td>
                                                <td>Beavis</td>
                                                <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>2.43%</span></span></td>
                                                <td>
                                                    <span class="txt-dark weight-500">$1478</span>
                                                </td>
                                                <td>
                                                    <span class="label label-primary">Active</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="txt-dark weight-500">Youtube</span></td>
                                                <td>Felix</td>
                                                <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>1.43%</span></span></td>
                                                <td>
                                                    <span class="txt-dark weight-500">$951</span>
                                                </td>
                                                <td>
                                                    <span class="label label-danger">Closed</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="txt-dark weight-500">Twitter</span></td>
                                                <td>Cannibus</td>
                                                <td><span class="txt-danger"><i class="zmdi zmdi-caret-down mr-10 font-20"></i><span>-8.43%</span></span></td>
                                                <td>
                                                    <span class="txt-dark weight-500">$632</span>
                                                </td>
                                                <td>
                                                    <span class="label label-default">Hold</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="txt-dark weight-500">Spotify</span></td>
                                                <td>Neosoft</td>
                                                <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>7.43%</span></span></td>
                                                <td>
                                                    <span class="txt-dark weight-500">$325</span>
                                                </td>
                                                <td>
                                                    <span class="label label-default">Hold</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="txt-dark weight-500">Instagram</span></td>
                                                <td>Hencework</td>
                                                <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>9.43%</span></span></td>
                                                <td>
                                                    <span class="txt-dark weight-500">$258</span>
                                                </td>
                                                <td>
                                                    <span class="label label-primary">Active</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Advertising &amp; Promotions</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block refresh mr-15">
                                <i class="zmdi zmdi-replay"></i>
                            </a>
                            <div class="pull-left inline-block dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>option 1</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>option 2</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>option 3</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
                                <canvas id="chart_2" height="253" width="472" style="display: block; width: 472px; height: 253px;"></canvas>
                            </div>
                            <div class="label-chatrs mt-30">
                                <div class="inline-block mr-15">
                                    <span class="clabels inline-block bg-yellow mr-5"></span>
                                    <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Active</span>
                                </div>
                                <div class="inline-block mr-15">
                                    <span class="clabels inline-block bg-blue mr-5"></span>
                                    <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Closed</span>
                                </div>
                                <div class="inline-block">
                                    <span class="clabels inline-block bg-green mr-5"></span>
                                    <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Hold</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



@include('admin.common.footer')
