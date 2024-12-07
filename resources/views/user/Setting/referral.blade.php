@include('user.common.header')



<style>
    .dashboard-widget.price {
    padding: 42px;
}
</style>


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

                            <div class="unique">
                                <h4>{{ $title }}</h4>

                            </div>
                        </div>
                        <div class="dashboard-referral mt-5">
                            <div class="dashboard-card">
                                <h3>Your Referral Link</h3>
                                <div class="dashboard-referral-link">

                                    <p class="copy-link"><?php echo @$referralLink; ?></p>


                                    <!-- <p class="copy-link">https://example.com/hyiptox/user-referral.html</p> -->
                                    <button type="button" onclick="copyValue('{{ @$referralLink }}');"
                                        class="copy-btn copy_notifys"><i class="far fa-copy"></i> Copy
                                        Link</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="col-md-6 mb-4">
                                    <div class="form-group mt-0">
                                        <label class="">Your Plan</label>
                                        <select class="select w-100 form-control" id="selectedPlanId" name="selectedPlanId">
                                            <option value="">Select Option</option>
                                            @php foreach ($plan as $key => $value) { @endphp
                                                <option value="<?php echo $value->id; ?>" ><?php echo $value->name; ?></option>
                                               @php } @endphp
                                        </select>
                                    </div>
                                </div>




                            </div>
                        </div>






                        <div class="row">

                            <div class="col-md-3 col-lg-6 mt-5 ">
                                <div class="dashboard-widget p-5">
                                    <div class="dashboard-widget-content">
                                        <h5>Total Direct Referrals</h5>
                                        <span class="withtitle" id="currency-balance"></span>
                                        <h5 class="text-center"><?php echo $referralCount; ?></h5>

                                    </div>
                                    <i class="flaticon-world"></i>
                                </div>
                            </div>


                            <div class="col-md-3 col-lg-6 mt-5 ">
                                <div class="dashboard-widget p-5">
                                    <div class="dashboard-widget-content">
                                        <h5>Total Direct Referrals</h5>
                                        <span class="withtitle" id="currency-balance"></span>
                                        <h5 class="text-center"><?php echo $directRef['direct_commission']; ?> %</h5>
                                        <h5 class="text-center" id="directCommission"></h5>



                                    </div>
                                    <i class="flaticon-world"></i>
                                </div>
                            </div>

                            <div id="levelCommissionContainer" class="row"></div>




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



<script>
    $(document).ready(function () {
    $('.select[name="selectedPlanId"]').on('change', function () {
        var selectedPlanId = $(this).val();
        var dataString = { id: selectedPlanId, plan_id: selectedPlanId };

        $.ajax({
            url: base_url + "fetch-level-commissions",
            type: 'POST',
            data: dataString,
            cache: false,
            async: true,
            beforeSend: function () {
                // Add any loading indicators or actions here
            },
            success: function (data) {
                if (data.error) {
                    toastr.error(data.error, { timeOut: 2000 });
                } else {
                    // Assuming level commission data is available in data.levelsData
                    // You can update your UI with this information
                    updateLevelCommissionUI(data.levelsData);
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    // Function to update UI with level commission data
    function updateLevelCommissionUI(levelsData) {
        var html = '';
        if (levelsData.length > 0) {
            levelsData.forEach(function (level) {
                html += '<div class="col-md-3 col-lg-6 mt-5">' +
                            '<div class="dashboard-widget price text-center">' +
                                '<div class="dashboard-widget-content price">' +
                                    '<a href="#" class="button">Unit ' + level.level + '</a>' +
                                    '<h5>' + level.commission + ' %</h5>' +
                                    '<p class="tertiary"> Team Profit Sharing for Unit ' + level.level + '</p>' +
                                '</div>' +
                                '<i class="flaticon-world"></i>' +
                            '</div>' +
                        '</div>';
            });

        }
        $('#levelCommissionContainer').html(html);
    }
});

</script>


