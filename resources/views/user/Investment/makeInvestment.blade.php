@include('user.common.header')
<style type="text/css">
input[type="checkbox"]:not(:checked) {
  /* Explicit Unchecked Styles */
  border: 1px solid #FF0000; // Only apply border to unchecked state
}
</style>

<main class="main">

    <div class="site-breadcrumb">
        <div class="container">
            <h2 class="breadcrumb-title">{{$title}}</h2>
            <ul class="breadcrumb-menu">
                <li><a href="{{URL::to('/')}}"><i class="far fa-home"></i> Home</a></li>
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
                                    <h4>{{$title}}</h4>

                                </div>
                        </div>
                        <div class="row m-4">
                            @php
                            // Define an array of colors
                            $colors = ['plan-color-1', 'plan-color-2', 'plan-color-3', 'plan-color-5','plan-color-6','plan-color-7','plan-color-8'];
                        @endphp

                        @foreach ($planList as $index => $data)
                            @php
                                // Get the color for the current plan based on the index
                                $colorClass = $colors[$index % count($colors)];
                            @endphp
                            <div class="col-md-6 col-lg-3">
                                <div class="plan-item {{ $colorClass }}">
                                    <h4 class="plan-title">{{$data['name']}}</h4>
                                    <div class="plan-rate">
                                        <h6 class="plan-price">$ {{number_format($data['price'],2)}}</h6>
                                        {{-- <span class="plan-price-type">ROI for Daily</span> --}}
                                    </div>
                                    <div class="plan-item-list">
                                        <ul>
                                            <li>Today ROI <?php echo $data['roi_commission']; ?> %</li>
                                            <li>Monthly ROI 5% to upto 15%</li>
                                        </ul>
                                    </div>
                                    <?php if(userId()){
                                        $link = URL::to('/Investment');
                                    }else{
                                        $link = URL::to('/signup');

                                    } ?>
<a href="{{ URL::to('/').'/confirmInvestment/'.encrypt_decrypt('encrypt', $data['id']) }}" class="plan-btn">Invest Now</a>
</div>
                            </div>
                        @endforeach

                        </div>
                        <span class="fetchPlan"></span>
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
    toastr.success('copied !!!', 'Success', {timeOut: 2000});
}


$(document).on('click','.getplans',function(){

    var id = $(this).attr("data-id");
    var check = $(".mycheckbox"+id).is(":checked");

    if(check){

        var dataString = {currencyId: id}
        $.ajax({
            url: base_url + "getPlanDetails",
            type: "POST",
            data: dataString,
            cache:false,
            async:true,
            beforeSend: function() {
                $('.sendOtp').hide();
                $('.otpLoading').show();

            },
            success: function(response) {

                $('.fetchPlan').html(response);
                $(".getplans").prop('checked', false);
                $(".mycheckbox"+id).prop('checked', true);
                // if (response.status == 1) {
                //    toastr.success(response.msg, 'Success', {timeOut: 2000});
                //    $('.sendOtp').show();
                //    $('.otpLoading').hide();

                // } else {
                //    toastr.error(response.msg, {timeOut: 2000});
                //    $('.sendOtp').show();
                //    $('.otpLoading').hide();
                // }
            }
        });

    }else{
        $('.fetchPlan').html("");


    }

})
 </script>
