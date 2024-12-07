<div class="wrapper theme-1-active pimary-color-green">

        <!-- Top NAV Menu -->
@php $url = URL::to('/').'/'.env('ADMIN_URL').'/'; @endphp
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="mobile-only-brand pull-left">
            <div class="nav-header pull-left">
                <div class="logo-wrap">
                    <a href="{{$url}}dashboard">
                        <!-- <img class="brand-img" src="../public/assets/admin/dist/img/logo.png" alt="brand"> -->
                        <span class="brand-text">Admin</span>
                    </a>
                </div>
            </div>
            <a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left"
                href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
            <a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view"
                href="javascript:void(0);"><i class="zmdi zmdi-search"></i></a>
            <a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i
                    class="zmdi zmdi-more"></i></a>
            <form id="search_form" role="search" class="top-nav-search collapse pull-left">
                <div class="input-group">
                    <input type="text" name="example-input1-group2" class="form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default" data-target="#search_form" data-toggle="collapse"
                            aria-label="Close" aria-expanded="true"><i class="zmdi zmdi-search"></i></button>
                    </span>
                </div>
            </form>
        </div>


        <div id="mobile_only_nav" class="mobile-only-nav pull-right">
            <ul class="nav navbar-right top-nav pull-right">
                <li>
                    <a id="open_right_sidebar" href="#"><i class="zmdi zmdi-settings top-nav-icon"></i></a>
                </li>
                <li class="dropdown app-drp">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="zmdi zmdi-apps top-nav-icon"></i></a>
                    <ul class="dropdown-menu app-dropdown" data-dropdown-in="slideInRight" data-dropdown-out="flipOutX">
                        <li>
                            <div class="slimScrollDiv"
                                style="position: relative; overflow: hidden; width: auto; height: 162px;">
                                <div class="app-nicescroll-bar" style="overflow: hidden; width: auto; height: 162px;">
                                    <ul class="app-icon-wrap pa-10">
                                        <li>
                                            <a href="weather.html" class="connection-item">
                                                <i class="zmdi zmdi-cloud-outline txt-info"></i>
                                                <span class="block">weather</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="inbox.html" class="connection-item">
                                                <i class="zmdi zmdi-email-open txt-success"></i>
                                                <span class="block">e-mail</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="calendar.html" class="connection-item">
                                                <i class="zmdi zmdi-calendar-check txt-primary"></i>
                                                <span class="block">calendar</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="vector-map.html" class="connection-item">
                                                <i class="zmdi zmdi-map txt-danger"></i>
                                                <span class="block">map</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="chats.html" class="connection-item">
                                                <i class="zmdi zmdi-comment-outline txt-warning"></i>
                                                <span class="block">chat</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="contact-card.html" class="connection-item">
                                                <i class="zmdi zmdi-assignment-account"></i>
                                                <span class="block">contact</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="slimScrollBar"
                                    style="background: rgb(135, 135, 135); width: 4px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 0px; z-index: 99; right: 1px;">
                                </div>
                                <div class="slimScrollRail"
                                    style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="app-box-bottom-wrap">
                                <hr class="light-grey-hr ma-0">
                                <a class="block text-center read-all" href="javascript:void(0)"> more </a>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="dropdown alert-drp">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="zmdi zmdi-notifications top-nav-icon"></i><span
                            class="top-nav-icon-badge">5</span></a>
                    <ul class="dropdown-menu alert-dropdown" data-dropdown-in="bounceIn" data-dropdown-out="bounceOut">
                        <li>
                            <div class="notification-box-head-wrap">
                                <span class="notification-box-head pull-left inline-block">notifications</span>
                                <a class="txt-danger pull-right clear-notifications inline-block"
                                    href="javascript:void(0)"> clear all </a>
                                <div class="clearfix"></div>
                                <hr class="light-grey-hr ma-0">
                            </div>
                        </li>
                        <li>
                            <div class="slimScrollDiv"
                                style="position: relative; overflow: hidden; width: auto; height: 229px;">
                                <div class="streamline message-nicescroll-bar"
                                    style="overflow: hidden; width: auto; height: 229px;">
                                    <div class="sl-item">
                                        <a href="javascript:void(0)">
                                            <div class="icon bg-green">
                                                <i class="zmdi zmdi-flag"></i>
                                            </div>
                                            <div class="sl-content">
                                                <span
                                                    class="inline-block capitalize-font pull-left truncate head-notifications">
                                                    New subscription created</span>
                                                <span
                                                    class="inline-block font-11 pull-right notifications-time">2pm</span>
                                                <div class="clearfix"></div>
                                                <p class="truncate">Your customer subscribed for the basic plan. The
                                                    customer will pay $25 per month.</p>
                                            </div>
                                        </a>
                                    </div>
                                    <hr class="light-grey-hr ma-0">
                                    <div class="sl-item">
                                        <a href="javascript:void(0)">
                                            <div class="icon bg-yellow">
                                                <i class="zmdi zmdi-trending-down"></i>
                                            </div>
                                            <div class="sl-content">
                                                <span
                                                    class="inline-block capitalize-font pull-left truncate head-notifications txt-warning">Server
                                                    #2 not responding</span>
                                                <span
                                                    class="inline-block font-11 pull-right notifications-time">1pm</span>
                                                <div class="clearfix"></div>
                                                <p class="truncate">Some technical error occurred needs to be resolved.
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                    <hr class="light-grey-hr ma-0">
                                    <div class="sl-item">
                                        <a href="javascript:void(0)">
                                            <div class="icon bg-blue">
                                                <i class="zmdi zmdi-email"></i>
                                            </div>
                                            <div class="sl-content">
                                                <span
                                                    class="inline-block capitalize-font pull-left truncate head-notifications">2
                                                    new messages</span>
                                                <span
                                                    class="inline-block font-11 pull-right notifications-time">4pm</span>
                                                <div class="clearfix"></div>
                                                <p class="truncate"> The last payment for your G Suite Basic
                                                    subscription failed.</p>
                                            </div>
                                        </a>
                                    </div>
                                    <hr class="light-grey-hr ma-0">
                                    <div class="sl-item">
                                        <a href="javascript:void(0)">
                                            <div class="sl-avatar">
                                                <img class="img-responsive" src="{{URL::to('/')}}/public/assets/admin/dist/img/avatar.jpg?1" alt="avatar">
                                            </div>
                                            <div class="sl-content">
                                                <span
                                                Person's Info    class="inline-block capitalize-font pull-left truncate head-notifications">Sandy
                                                    Doe</span>
                                                <span
                                                    class="inline-block font-11 pull-right notifications-time">1pm</span>
                                                <div class="clearfix"></div>
                                                <p class="truncate">Neque porro quisquam est qui dolorem ipsum quia
                                                    dolor sit amet, consectetur, adipisci velit</p>
                                            </div>
                                        </a>
                                    </div>
                                    <hr class="light-grey-hr ma-0">
                                    <div class="sl-item">
                                        <a href="javascript:void(0)">
                                            <div class="icon bg-red">
                                                <i class="zmdi zmdi-storage"></i>
                                            </div>
                                            <div class="sl-content">
                                                <span
                                                    class="inline-block capitalize-font pull-left truncate head-notifications txt-danger">99%
                                                    server space occupied.</span>
                                                <span
                                                    class="inline-block font-11 pull-right notifications-time">1pm</span>
                                                <div class="clearfix"></div>
                                                <p class="truncate">consectetur, adipisci velit.</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="slimScrollBar"
                                    style="background: rgb(135, 135, 135); width: 4px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 0px; z-index: 99; right: 1px;">
                                </div>
                                <div class="slimScrollRail"
                                    style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="notification-box-bottom-wrap">
                                <hr class="light-grey-hr ma-0">
                                <a class="block text-center read-all" href="javascript:void(0)"> read all </a>
                                <div class="clearfix"></div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown auth-drp">
                    <a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><img
                            src="{{URL::to('/')}}/public/assets/admin/dist/img/user1.png" alt="user_auth"
                            class="user-auth-img img-circle"><span class="user-online-status"></span></a>
                    <ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX"
                        data-dropdown-out="flipOutX">
                        <li>
                            <a href="{{$url}}siteSettings"><i class="fa fa-gears mr-20"></i><span>Site Setting</span></a>
                        </li>
                        <li>
                            <a href="{{$url}}securitySettings"><i class="zmdi zmdi-lock mr-20"></i><span>Security Setting</span></a>
                        </li>

                        <li>
                            <a href="{{$url}}support"><i class="fa fa-book mr-20"></i><span>Support</span></a>
                        </li>

{{--
                        <li>
                            <a href="{{$url}}ipWhitelist"><i class="fa fa-server mr-20 mr-20"></i><span>Ip White List</span></a>
                        </li> --}}


                        <li class="divider"></li>
                        <li>
                            <a href="{{$url}}adminLogout"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>


            <!-- / Top NAV Menu -->

    <!-- Left Sidebar Menu -->
    <div class="fixed-sidebar-left">
        <ul class="nav navbar-nav side-nav nicescroll-bar">
            <li class="navigation-header">
                <span>Main</span>
                <i class="zmdi zmdi-more"></i>
            </li>

            <li>
                <a href="{{$url}}dashboard" class="active">
                    <div class="pull-left"><i class="fa fa-dashboard mr-20"></i><span
                            class="right-nav-text">Dashboard</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
            </li>




            <li class="navigation-header">
                <span>USER MANAGEMENT</span>
                <i class="zmdi zmdi-more"></i>
            </li>

            <li>
                <a href="{{$url}}usersList" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-group mr-20"></i><span class="right-nav-text">User
                            List</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>

            <li>
                <a href="{{$url}}kyc" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-file mr-20"></i><span class="right-nav-text">User
                            Kyc</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>




            <li>
                <a href="{{$url}}userActivity" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-tasks mr-20"></i><span class="right-nav-text">User
                            Activity</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>




            <li>
                <a href="{{$url}}ipBlock" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-exclamation-triangle mr-20"></i><span
                            class="right-nav-text">User Ip Block</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>



            <li>
                <hr class="light-grey-hr mb-10">
            </li>




            <li class="navigation-header">
                <span>CURRENCY MANAGEMENT</span>
                <i class="zmdi zmdi-more"></i>
            </li>

            <li>
                <a href="{{$url}}currencyList" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-money mr-20"></i><span class="right-nav-text">Currency
                            List</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>



            <li>
                <a href="{{$url}}currencySetting" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-credit-card alt mr-20"></i><span
                            class="right-nav-text">Currency Setting</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>


            <li>
                <hr class="light-grey-hr mb-10">
            </li>




            <li class="navigation-header">
                <span>PLAN MANAGEMENT</span>
                <i class="zmdi zmdi-more"></i>
            </li>

            {{-- <li>
                <a href="{{$url}}addPlan" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-calendar mr-20"></i><span class="right-nav-text">Create Plan</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li> --}}


            <li>
                <a href="{{$url}}planList" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-list-alt mr-20"></i><span class="right-nav-text">Plan List</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>



            <li>
                <hr class="light-grey-hr mb-10">
            </li>



            <li class="navigation-header">
                <span>SWAP MANAGEMENT</span>
                <i class="zmdi zmdi-more"></i>
            </li>

            {{-- <li>
                <a href="{{$url}}addPlan" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-calendar mr-20"></i><span class="right-nav-text">Create Plan</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li> --}}


            <li>
                <a href="{{$url}}swaplist" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-list-alt mr-20"></i><span class="right-nav-text">swap pair List</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>


            <li>
                <a href="{{$url}}swaphistory" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-fax mr-20"></i><span class="right-nav-text">Swap History</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>




            <li>
                <hr class="light-grey-hr mb-10">
            </li>





            <li class="navigation-header">
                <span>HISTORY MANAGEMENT</span>
                <i class="zmdi zmdi-more"></i>
            </li>


            <li>
                <a href="{{$url}}depositHistory" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-cubes mr-20"></i><span class="right-nav-text">Deposit
                            History</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>


            <li>
                <a href="{{$url}}withdrawHistory" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-exchange mr-20"></i><span class="right-nav-text">Withdraw
                            History</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>




            <li>
                <a href="{{$url}}investment" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-rotate-right mr-20"></i><span class="right-nav-text">Investments History</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>




            <li>
                <a href="{{$url}}levelCommission" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-rotate-right mr-20"></i><span class="right-nav-text">
                            Level Commison</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>

            <li>
                <a href="{{$url}}directCommission" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-rotate-right mr-20"></i><span class="right-nav-text">
                            Direct Commison</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>

            <li>
                <a href="{{$url}}roiCommission" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-rotate-right mr-20"></i><span class="right-nav-text">
                            ROI Commison</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>



            <li>
                <a href="{{$url}}pairCommission" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-rotate-right mr-20"></i><span class="right-nav-text">
                            PAIR Commison</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>



            <li>
                <a href="{{$url}}internaltransferhistory" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-align-left mr-20"></i><span class="right-nav-text">
                            Internal Transfer </span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>



            <li>
                <a href="{{$url}}internalredeemhistory" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-align-right mr-20"></i><span class="right-nav-text">
                           Internal Reedom</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>


            {{-- <li>
                <a href="{{$url}}roi" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-history mr-20"></i><span class="right-nav-text">ROI
                            History</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li> --}}



            <li>
                <hr class="light-grey-hr mb-10">
            </li>


            <li class="navigation-header">
                <span>CMS MANAGEMENT</span>
                <i class="zmdi zmdi-more"></i>
            </li>

            <li>
                <a href="{{$url}}cms" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-money mr-20"></i><span class="right-nav-text">CMS</span>
                    </div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>


            {{-- <li>
                <a href="{{$url}}email" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-envelope mr-20"></i><span class="right-nav-text">Email
                            Template</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li> --}}


            <li>
                <hr class="light-grey-hr mb-10">
            </li>



            <li class="navigation-header">
                <span>ADMIN MANAGEMENT</span>
                <i class="zmdi zmdi-more"></i>
            </li>

            <li>
                <a href="{{$url}}siteSettings" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-gears mr-20"></i><span class="right-nav-text">Site
                            Setting</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>


            <li>
                <a href="{{$url}}securitySettings" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="zmdi zmdi-lock mr-20"></i><span class="right-nav-text">Security
                            Setting</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>



            <li>
                <a href="{{$url}}adminActivity" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-book mr-20"></i><span class="right-nav-text">Admin
                            Activity</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a>
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>



            <li>
  <!--               <a href="{{$url}}ipWhitelist" data-toggle="collapse" data-target="#ecom_dr">
                    <div class="pull-left"><i class="fa fa-server mr-20"></i><span class="right-nav-text">Admin IP
                            White List</span></div>
                    <div class="pull-right"></div>
                    <div class="clearfix"></div>
                </a> -->
                <ul id="ecom_dr" class="collapse collapse-level-1">
                </ul>
            </li>






        </ul>
    </div>
    <!-- /Left Sidebar Menu -->




</div>
