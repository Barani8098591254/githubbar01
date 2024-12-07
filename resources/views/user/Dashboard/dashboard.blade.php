@include('user.common.header')



<main class="main">
    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ URL::to('/') }}"><i class="far fa-home"></i> Home</a></li>
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
                        <div class="dashboard-content-head">
                            <div class="dashboard-content-search">
                                <h4>{{$title}}</h4>
                            </div>
                            <div class="dashboard-content-head-menu">
                                <ul>


                                    <li>
                                        <div class="dropdown">
                                            <a class="dashboard-head-profile" href="#" data-bs-toggle="dropdown">
                                                <i class="far fa-user-circle"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end dashboard-head-profile-dropdown">
                                                <li><a class="dropdown-item" href="{{ URL::to('/profile') }}"><i
                                                            class="fas fa-user-cog"></i> My Profile</a></li>
                                                <li><a class="dropdown-item" href="{{ URL::to('logout') }}"><i
                                                            class="fas fa-user-lock"></i> Log Out</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="dashboard-widget-wrapper">
                            <div class="row">
                            <div class="col-md-6 col-lg-6 mt-3 ">
                                <div class="dashboard-widget">
                                    <i class="flaticon-world mt-3"></i>
                                    <div class="dashboard-widget-content">
                                        <h5>Total Investment</h5>
                                        <span>$ <?php  echo number_format($total_investment,2); ?></span>
                                        <br>
                                        <span>Last Investment : $ {{@(number_format($lastInverstment->equivalentAmt,2)) ? @number_format($lastInverstment->equivalentAmt,2) : '---'}}</span>
                                        <br>
                                        <span>Dated On : {{@($lastInverstment->created_at) ? date('d, M Y', strtotime($lastInverstment->created_at)) : '---' }}</span>
                                    </div>
                                    <a href="{{URL::to('/')}}/Investment" class="theme-btn">Investment</a>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 mt-3 ">
                                <div class="dashboard-widget ">
                                    <i class="flaticon-world mt-3"></i>
                                    <div class="dashboard-widget-content">
                                        <h5> Total Roi Earnings</h5>
                                        <span>&nbsp$ <?php echo number_format($roi_scheduled + $roi_unscheduled,4); ?></span>
                                        <br>
                                        <span>&nbsp Settled : $ <?php echo number_format($roi_scheduled,4); ?></span>
                                        <br>
                                        <span>&nbsp Un-Settled : $ <?php echo number_format($roi_unscheduled,4); ?></span>
                                    </div>

                                      <?php if($roi_unscheduled > 0 && $walletStatus == 1) { ?>
                                         <button class="theme-btn walletBtn walletBtn1" onclick="moveToWallet('<?php echo encrypt_decrypt('encrypt','daily_interest') ?>',4)">Move to Wallet</button>
                                      <?php } else { ?>
                                        <a href="javascript:void(0)" class="theme-btn walletBtn" onclick="walletMsg(<?php echo $roi_unscheduled; ?>, <?php echo $walletStatus; ?>)"> Move to Wallet</a>
                                      <?php } ?>


                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4 mt-3 ">
                                <div class="dashboard-widget ">
                                    <div class="dashboard-widget-content">
                                        <h5>My Investment</h5>
                                        <span>$ <?php echo number_format($today_investment,4); ?> Today</span>
                                    </div>
                                    <i class="flaticon-world mt-3"></i>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 mt-3 ">
                                <div class="dashboard-widget ">
                                    <div class="dashboard-widget-content">
                                        <h5>Rate Of Interest</h5>
                                        <span>$ <?php echo number_format($today_roi,2); ?> %</span>
                                    </div>
                                    <i class="flaticon-world mt-3"></i>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4 mt-3 ">
                                <div class="dashboard-widget ">
                                    <div class="dashboard-widget-content">
                                        <h5>Roi Earning</h5>
                                        <span>$ <?php echo number_format($today_roi_total,2); ?> Today</span>
                                    </div>
                                    <i class="flaticon-world mt-3"></i>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6 mt-3 ">
                                <div class="dashboard-widget  ">
                                    <i class="flaticon-world mt-3"></i>
                                    <div class="dashboard-widget-content">
                                        <h5>Total profite Sharing</h5>
                                        <span>&nbsp $ <?php echo number_format($level_scheduled + $level_unscheduled, 4); ?></span>
                                        <br>
                                        <span>&nbsp Settled : <?php echo ($level_scheduled) ? '$ '.number_format($level_scheduled,4) : number_format('0',4); ?></span>
                                        <br>
                                        <span>&nbsp Un-Settled : <?php echo ($level_unscheduled) ? '$ '.number_format($level_unscheduled,4) : number_format('0',4); ?></span>
                                    </div>

                                    <?php if($level_unscheduled > 0  && $walletStatus == 1) { ?>
                                         <button class="theme-btn walletBtn walletBtn2" onclick="moveToWallet('<?php echo encrypt_decrypt('encrypt','level_commission') ?>',2)"> Move to Wallet</button>
                                      <?php } else { ?>
                                        <a href="javascript:void(0)" class="theme-btn walletBtn" onclick="walletMsg(<?php echo $level_unscheduled; ?>, <?php echo $walletStatus; ?>)"> Move to Wallet</a>
                                      <?php } ?>

                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 mt-3 ">
                                <div class="dashboard-widget ">
                                    <i class="flaticon-world mt-3"></i>
                                    <div class="dashboard-widget-content">
                                        <h5>Direct Commission</h5>
                                        <span>&nbsp $ <?php echo number_format($direct_scheduled + $direct_unscheduled, 4); ?></span>
                                        <br>
                                        <span>&nbsp Settled : $ <?php echo number_format($direct_scheduled,4); ?></span>
                                        <br>
                                        <span>&nbsp Un-Settled : $ <?php echo number_format($direct_unscheduled,4); ?></span>
                                    </div>


                                  <?php if($direct_unscheduled > 0 && $walletStatus == 1) { ?>
                                         <button class="theme-btn walletBtn walletBtn3" onclick="moveToWallet('<?php echo encrypt_decrypt('encrypt','direct_commission') ?>',3)">Move to Wallet</button>
                                      <?php } else { ?>
                                        <a href="javascript:void(0)" title="Fund not available." class="theme-btn walletBtn"  onclick="walletMsg(<?php echo $direct_unscheduled; ?>, <?php echo $walletStatus; ?>)"> Move to Wallet</a>
                                      <?php } ?>


                                </div>
                            </div>







                            </div>
                            </div>
















                        <div class="dashboard-table-wrapper" style="display: none;">
                            <div class="dashboard-table-head">
                                <h3>Transaction History</h3>
                                <select class="select">
                                    <option value="">Sort By Default</option>
                                    <option value="1">This Month</option>
                                    <option value="2">Last Month</option>
                                    <option value="3">This Year</option>
                                    <option value="4">Last Year</option>
                                </select>
                            </div>
                            <div class="dashboard-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Transaction ID</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd">
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2021</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                        <tr>
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2021</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                        <tr class="odd">
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2021</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                        <tr>
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2021</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                        <tr class="odd">
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2021</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                        <tr>
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2021</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                        <tr class="odd">
                                            <th>NVDSF4GHS12</th>
                                            <td>25 August, 2021</td>
                                            <td>$15,056</td>
                                            <td>Your Payment Successfully Received</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>



@include('user.common.footer')

<script type="text/javascript">

function walletMsg($amount, $walletStatus) {
    if(!$amount) {
        toastr.error('Insufficient Fund. !', 'Error', {timeOut: 2000});

    } else if($walletStatus == 0){
        toastr.error('You must Trdae minimum 1000 USD', 'Success', {timeOut: 2000});

    }
}
function moveToWallet(type,num) {
    $('.walletBtn').prop("disabled", true);
    $('.walletBtn'+num).html('Loading ...');
    var baseUrl = '<?php echo URL::to('moveToWallet'); ?>/'+type;
    window.location.href=baseUrl;
}
</script>
