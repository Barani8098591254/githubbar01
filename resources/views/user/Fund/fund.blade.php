@include('user.common.header')


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


                         <div class="dashboard-content">

                            <div class="dashboard-widget-wrapper">
                            <div class="row">
                          @if(count($currency) > 0)
                          @foreach($currency as $key => $value)
                            <div class="col-md-6 col-lg-4 mt-4">
                                <div class="dashboard-widget">
                                    <div class="dashboard-widget-content">
                                        <h6>{{$value->symbol}}</h6>
                                        @php $balance = @(get_balance(userId(),$value->id)) ? number_format(get_balance(userId(),$value->id),$value->decimal, '.', '') : number_format('0',$value->decimal, '.', '')  @endphp
                                        <span>{{ $balance }}</span><br>
                                        <span>Equivalent USD : <?php $price = $balance / $value->usdprice; echo  number_format($price,4, '.', ''); ?><span>
                                    </div>
                                    <i class="flaticon-wallet"></i>
                                </div>
                            </div>
                         @endforeach
                         @else
                               <div class="col-md-12 col-lg-12">
                                <div class="dashboard-widget">
                                <div class="dashboard-widget-content">
                                <h6>Currency Not Found</h6>
                            </div>
                            </div>
                            </div>
                         @endif
                            </div>
                            </div>
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
    toastr.success('copied !!!', 'Success', {timeOut: 2000});
}
 </script>
