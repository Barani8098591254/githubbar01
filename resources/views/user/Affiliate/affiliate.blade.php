@include('user.common.header')


<main class="main">

    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">Affiliate</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{ URL::to('/') }}"><i class="far fa-home"></i> Home</a></li>
                <li class="active">Affiliate</li>
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

                            <div class="unique">
                                <h4>{{ $title }}</h4>

                            </div>
                        </div>


                        <div class="row">

                             <div class="col-lg-8">
                                <div class="dashboard-referral mt-5">
                                    <div class="dashboard-card">
                                        <h3>Your Referral Link</h3>
                                        <div class="dashboard-referral-link">

                                            <span><input type="text" name="copy_txt" id="inputField" class="form-control form--control w-75" placeholder="Your Affiliate Link" value="<?php echo @$referralLink; ?>" readonly> <button type="button" onclick="copyValue('{{ @$referralLink }}');"
                                                class="copy-btn copy_notifys"><i class="far fa-copy"></i> Copy
                                                Link</button>
                                           </span>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-3 col-lg-4 mt-5 ">
                                <div class="dashboard-widget p-5">
                                    <div class="dashboard-widget-content">
                                        <h5>Total Direct Referrals</h5>
                                        <span class="withtitle" id="currency-balance"></span>
                                        <h5><?php echo $referralCount; ?></h5>

                                    </div>
                                    <i class="flaticon-world"></i>
                                </div>
                            </div>



                        </div>
                    </div>


                    <div class="level">
                        <div class="row">

                            <div class="col-md-3 col-lg-4 mt-5 ">
                                <div class="dashboard-widget p-5">
                                    <div class="dashboard-widget-content">
                                        <h5>Total Direct Referrals</h5>
                                        <span class="withtitle" id="currency-balance"></span>
                                        <h5><?php echo $directRef['direct_commission']; ?> %</h5>

                                    </div>
                                    <i class="flaticon-world"></i>
                                </div>
                            </div>



                        <?php

                        if(count($levelsData) > 0) {

                            foreach ($levelsData as $key => $level) {

                                echo '<div class="col-md-3 col-lg-4 mt-5"">
                                        <div class="dashboard-widget price">
                                            <div class="dashboard-widget-content price">
                                            <a href="#" class="button">Unit '.$level['level'].'</a>
                                            <h5>'.$level['commission'].' %</h5>
                                            <p class="tertiary"> Team Profit Sharing for Unit '.$level['level'].'</p>
                                        </div>
                                        <i class="flaticon-world"></i>

                                        </div>
                                    </div>';
                            }

                        }

                        ?>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>



@include('user.common.footer')

<script>
    function copyValue(value) {
        console.log("copy");
        var textArea = document.createElement("textarea");
        textArea.value = value;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        toastr.success('copied !!!', 'Success', {
            timeOut: 2000
        });
    }
</script>


