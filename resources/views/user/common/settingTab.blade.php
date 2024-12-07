<?php $uri = Request::segment(1); ?>

{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/> --}}

<div class="col-lg-3 col-md-4">
    <div class="dashboard-sidebar">
        <div class="dashboard-profile p-30-20">
            <input type="file" name="profilePicture" id="profilePicture" class="profilePicture" capture
                style="display:none" capture style="display:none" accept="image/png, image/jpg, image/jpeg" />

            @if (user_details(userId(), 'profile_pic'))
                <img src="{{ user_details(userId(), 'profile_pic') }}" id="profilePic" alt="dashboard">
            @else
                <img src="{{ URL::to('/') }}/public/assets/user/images/users.png?123" id="profilePic" alt="dashboard">
            @endif
            <div class="profile-content">
                <h5>{{ ucfirst(getuserName(userId())) }}</h5>
                <p><a href="/cdn-cgi/l/email-protection" class="__cf_email__ support"
                        data-cfemail="a1c2c0d7c4d3e1c4d9c0ccd1cdc48fc2cecc">{{ getuserEmail(userId()) }}</a>
                </p>
            </div>
        </div>
        <div class="dashboard-menu p-30-20">
            <ul>
                <li><a href="{{ URL::to('dashboard') }}" class="{{ $uri == 'dashboard' ? 'active' : '' }}"><i
                            class="fas fa-tachometer-alt"></i>
                        Dashboard</a></li>

                        <li><a href="{{ URL::to('fund') }}" class="{{ $uri == 'fund' ? 'active' : '' }}"><i
                            class="fas fa-money-check"></i>Wallet Fund</a></li>

                        <li><a href="{{ URL::to('deposit') }}" class="{{ $uri == 'deposit' ? 'active' : '' }}"><i
                                    class="fas fa-hand-holding-usd"></i> Deposit</a></li>
                            <li><a href="{{ URL::to('withdraw') }}" class="{{ $uri == 'withdraw' ? 'active' : '' }}"><i
                                class="fas fa-wallet"></i> Withdraw</a></li>
                        </li>


                        <li><a href="" class="{{ ($uri == 'internaltransfer' || $uri == 'transferhistory' || $uri == 'redeemhistory') ? 'active' : '' }} btn-toggle  rounded collapsed dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#home-collapsee" aria-expanded="false"><i class='fas fa-sync-alt'></i>Internal Transfer</a>
                            <div class="Profile-ui collapse " id="home-collapsee">
                                <ul class="btn-toggle-nav list-unstyled fw-normal ">
                                    <li><a href="{{ URL::to('internaltransfer') }}" >Make Transfer</a></li>
                                    <li><a href="{{ URL::to('transferhistory') }}" >Transfer History</a></li>
                                    <li><a href="{{ URL::to('redeemhistory') }}" >Redeem History</a></li>
                                </ul>
                         </div>
                        </li>



                        <li><a href="" class="{{ ($uri == 'useraffiliate' || $uri == 'myreferrals' || $uri == 'downline' || $uri == 'genealogy') ? 'active' : '' }} btn-toggle  rounded collapsed dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#home-collapsetwo" aria-expanded="false"><i class='fas fa-users'></i>Affiliate</a>
                            <div class="Profile-ui collapse " id="home-collapsetwo">
                                <ul class="btn-toggle-nav list-unstyled fw-normal ">
                                    <li><a href="{{ URL::to('useraffiliate') }}">Affiliate Program</a></li>
                                <li><a href="{{ URL::to('myreferrals') }}">My Referral</a></li>
                                <li><a href="{{ URL::to('genealogy') }}">My Genealogy</a></li>
                                <li><a href="{{ URL::to('downline') }}">Downline</a></li>
                                </ul>
                         </div>
                        </li>


                            <li><a href="" class="{{ ($uri == 'Investment' || $uri == 'Investmenthistory') ? 'active' : '' }} btn-toggle  rounded collapsed dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false"><i class='fas fa-landmark'></i>Investment</a>
                                <div class="Profile-ui collapse " id="home-collapse">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal ">
                                        <li><a href="{{ URL::to('Investment') }}" >Make Investment </a></li>
                                        <li><a href="{{ URL::to('Investmenthistory') }}" >Investment History</a></li>
                                    </ul>
                             </div>
                            </li>


                            <li><a href="" class="{{ ($uri == 'instantswap' || $uri == 'instantswaphistory') ? 'active' : '' }} btn-toggle  rounded collapsed dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#home-collapsethree" aria-expanded="false"><i class="fas fa-money-bill"></i>Swap</a>
                                <div class="Profile-ui collapse " id="home-collapsethree">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal ">
                                        <li><a href="{{ URL::to('instantswap') }}" >Instant Swap</a></li>
                                        <li><a href="{{ URL::to('instantswaphistory') }}" >Instant Swap History</a></li>
                                    </ul>
                             </div>
                            </li>


                            <li><a href="" class="{{ ($uri == 'levelcommission' || $uri == 'directcommisson' || $uri == 'roicommisson') ? 'active' : '' }} btn-toggle  rounded collapsed dropdown-toggle" data-bs-toggle="collapse" data-bs-target="#home-collapseone" aria-expanded="false"><i class='fas fa-history'></i>Earning History</a>
                                <div class="Profile-ui collapse " id="home-collapseone">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal ">
                                        <li><a href="{{ URL::to('levelcommission') }}"> Level Commission</a></li>
                                        <li><a href="{{ URL::to('directcommisson') }}"> Direct Commisson</a></li>
                                        <li><a href="{{ URL::to('roicommisson') }}"> Roi Commission</a></li>
                                    </ul>
                             </div>
                            </li>

                            <li><a href="{{ URL::to('profile') }}" class="{{ $uri == 'profile' ? 'active' : '' }}"><i
                                class='fas fa-user-cog'></i>
                            Profile</a></li>


                        <li><a href="{{ URL::to('userActivity') }}" class="{{ $uri == 'userActivity' ? 'active' : '' }}"><i
                            class='fas fa-file-signature'></i>
                            User Ativity</a></li>

                <li><a href="{{ URL::to('logout') }}"><i class="fas fa-user-lock"></i> Log Out</a></li>
            </ul>
        </div>
    </div>
</div>
