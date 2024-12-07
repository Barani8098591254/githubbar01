@include('admin.common.header')
@include('admin.common.sidebar')



<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <form action="{{URL::to('/')}}/{{env('ADMIN_URL')}}/rejectKycSubmit/{{encrypt_decrypt('encrypt',$kyclist->id)}}" class="kycreject" name="kycreject" id="kycreject" method="post">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 class="modal-title" id="myModalLabel">
              <span id="modelTitle"></span>
            </h5>
          </div>

          <div class="modal-body">
            <input type="hidden" name="type" id="type" class="idType">
            <input type="hidden" name="user_id" id="user_id" value="{{encrypt_decrypt('encrypt',$kyclist->user_id)}}">
            <div class="form-group">
              <label class="control-label mb-10 text-left">Rejected Reason</label>
              <textarea name="reason" id="reason" class="form-control" rows="5"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit front_rejected" id="" name="front_rejected">Submit <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i>
            </button>

            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>




  <!-- Main Content -->
  <div class="page-wrapper">
    <div class="container-fluid">
      <!-- Title -->
      <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h5 class="txt-dark">{{$title}}</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
            <li>
              <a href="{{adminBaseurl()}}dashboard">Dashboard</a>
            </li>
            <li>
              <a href="kyc">
                 <a href="{{adminBaseurl()}}kyc">User KYC</a>
                <span></span>
              </a>
            </li>
            <li class="active">
              <span>{{$title}}</span>
            </li>
          </ol>
        </div>
        <!-- /Breadcrumb -->
      </div>



      <!-- Row -->
    		<!-- Row -->
            <div class="row">
                <div class="col-lg-3 col-xs-12">
                    <div class="panel panel-default card-view  pa-0">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body  pa-0">
                                <div class="profile-box">
                                    <div class="profile-cover-pic">
                                        <div class="fileupload btn btn-default">

                                        </div>
                                        <div class="profile-image-overlay"></div>
                                    </div>
                                    <div class="profile-info text-center">
                                        <div class="profile-img-wrap">

                                            @if(getkycdetails($kyclist->user_id)->profile_pic)
                                            <img class="inline-block mb-10" src="{{getkycdetails($kyclist->user_id)->profile_pic}}" alt="user"/>
                                        @else
                                            <img class="inline-block mb-10" src="{{ URL::to('/') }}/public/assets/admin/dist/img/Profile-Male-PNG.png" alt="user"/>
                                        @endif

                                        {{-- <div class="kyc-heading">
                                        <h6 class="block capitalize-font pb-20">{{encrypt_decrypt('decrypt',$kyclist->email)}}</h6>
                                    </div> --}}

                                        </div>
                                        <h6 class="block capitalize-font pb-20">{{encrypt_decrypt('decrypt',$kyclist->email)}}</h6>
                                        <h5 class="block mt-10 mb-5 weight-500 capitalize-font txt-danger"></h5>
                                        <h6 class="block capitalize-font pb-20"></h6>
                                    </div>
                                    <div class="social-info">
                                        <div class="row">
                                            <div class="col-xs-6 text-center">
                                                <span class="block capitalize-font pb-20">{{$kyclist->proof_number}}</span>
                                                <span class="counts-text block">ID Number</span>
                                            </div>

                                            <div class="col-xs-6 text-center">
                                                <span class="block capitalize-font pb-20">
                                                     @if($kyclist->kyc_status == 3)
                                                    <span class="label label-success">Approved</span>
                                                    @elseif($kyclist->kyc_status == 2)
                                                        <span class="label label-danger">Rejected</span>
                                                    @elseif($kyclist->kyc_status == 1)
                                                        <span class="label label-primary">Pending</span>
                                                    @else
                                                        <span class="label label-warning">Not yet uploaded</span>
                                                    @endif
                                                </span>
                                                <span class="counts-text block">KYC Status</span>
                                            </div>
                                        </div>

                                        <a title="view user" href="{{adminBaseurl()}}Profile/{{encrypt_decrypt('encrypt',$kyclist->user_id)}}"><button class="btn btn-default btn-block btn-outline btn-anim mt-30" data-toggle="modal" data-target=""><i class="fa fa-eye"></i><span class="btn-text">View Profile</span></button></a>

                                        <div id="myModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">

                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-9 col-xs-12">



                    <div class="col-md-12 col-lg-4">
                        <h5>Proof Front</h5><br>
                        <div class="kycimgg">
                            @if($kyclist->fStatus != 0)
                            <img src="{{$kyclist->front}}" alt="default" class="model_img img-responsive"/>
                            @else
                            <img src="{{URL::to('/')}}/public/assets/admin/dist/img/kycverify.png" alt="default" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-responsive"/>
                            @endif
                        </div>


                            @if($kyclist->fStatus == 1)
                            <div class="uploadbtns">
                                <a type="button" class="btn appr adminprofilee" title="Proof Front Approved" href="{{URL::to('/')}}/{{env('ADMIN_URL')}}/approvedKyc/front/{{encrypt_decrypt('encrypt',$kyclist->user_id)}}" class="btn btn-success mr-10 mb-30 admin_profile" id="adminprofilee" name="adminprofilee">Approved <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i></a>

                                <button type="button" title="Proof Front Rejected" class="btn rej admin_profile rejectedPopup" data-toggle="modal" data-target="#myModal" data-head="Proof Front" data-type="front" id="admin_profile" name="admin_profile">Reject</button>
                            </div>
                            @else
                            <div class="uploadbtns rejectedStatus">
                                @if($kyclist->fStatus == 2)
                                 <span class="center text-danger" >Rejected</span>
                                 <span class="">Reason : {{$kyclist->fReason}}</span>
                                @elseif($kyclist->fStatus == 3)
                                 <span class="center text-success" >Approved</span>
                               @endif
                         </div>
                            @endif


                    </div>






                    <div class="col-md-12 col-lg-4">
                        <h5>Proof Back</h5><br>
                        <div class="kycimgg">

                            @if($kyclist->bStatus != 0)
                            <img src="{{$kyclist->back}}" alt="default" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-responsive img-fluid"/>
                            @else
                            <img src="{{URL::to('/')}}/public/assets/admin/dist/img/backsideaaa.png" alt="default" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-responsive img-fluid"/>
                            @endif
                        </div>
                        @if($kyclist->bStatus == 1)

                            <div class="uploadbtns">
                                <a type="button" class="btn appr adminprofilee" title="Proof Back Approved" href="{{URL::to('/')}}/{{env('ADMIN_URL')}}/approvedKyc/back/{{encrypt_decrypt('encrypt',$kyclist->user_id)}}" id="adminprofilee" name="adminprofilee" >Approved <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i> </a>

                                <button type="button" title="Proof Back Rejected" class="btn rej admin_profile rejectedPopup" data-toggle="modal" data-target="#myModal" id="admin_profile" data-head="Proof Back" data-type="back" name="admin_profile">Reject</button>
                            </div>
                           @else
                            <div class="uploadbtns rejectedStatus">
                                @if($kyclist->bStatus == 2)
                                 <span class="center text-danger" >Rejected</span>
                                 <span class="">Reason : {{$kyclist->back_reject_reason}}</span>
                                @elseif($kyclist->bStatus == 3)
                                 <span class="center text-success" >Approved</span>
                               @endif
                             </div>
                           @endif

                    </div>
                    <div class="col-md-12 col-lg-4 ">
                        <h5>Proof Selfi</h5><br>

                        <div class="kycimgg">
                            @if($kyclist->sStatus != 0)
                            <img src="{{$kyclist->selfi}}" alt="default" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-responsive img-fluid"/>
                            @else
                            <img src="{{URL::to('/')}}/public/assets/admin/dist/img/kycverify.png" alt="default" data-toggle="modal" data-target=".bs-example-modal-lg" class="model_img img-responsive img-fluid"/>
                            @endif
                        </div>
                         @if($kyclist->sStatus == 1)
                            <div class="uploadbtns">
                                {{-- <a type="button" class="btn appr adminprofilee" title="Proof Selfi Approved" href="{{URL::to('/')}}/{{env('ADMIN_URL')}}/approvedKyc/selfi/{{encrypt_decrypt('encrypt',$kyclist->user_id)}}" id="adminprofilee" name="adminprofilee">Approved <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i></a> --}}


                                <a type="button" class="btn appr adminprofilee" title="Proof Selfi Approved" href="{{URL::to('/')}}/{{env('ADMIN_URL')}}/approvedKyc/selfi/{{encrypt_decrypt('encrypt',$kyclist->user_id)}}" id="adminprofilee" name="adminprofilee">
                                    <span class="buttonText">Approved</span> <!-- Wrapped the button text in a span -->
                                    <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i>
                                  </a>


                                <button type="button" title="Proof Selfi Reject" class="btn rej admin_profile rejectedPopup" data-toggle="modal" data-target="#myModal" id="admin_profile" data-head="Selfi" data-type="selfi" name="admin_profile">Reject</button>
                            </div>
                           @else
                            <div class="uploadbtns rejectedStatus">
                                @if($kyclist->sStatus == 2)
                                 <span class="center text-danger" >Rejected</span>
                                 <span class="">Reason : {{$kyclist->selfie_reject_reason}}</span>

                                @elseif($kyclist->sStatus == 3)
                                 <span class="center text-success" >Approved</span>
                               @endif
                             </div>
                           @endif

                    </div>
                </div>
                <!-- </div> -->






    @include('admin.common.footer')

    <script type="text/javascript">

        $('.rejectedPopup').click(function(){
            var Heading = $(this).attr("data-head");
            var type = $(this).attr("data-type");

            $('#modelTitle').text(Heading);
            $('.idType').val(type);
        })
    </script>


<script>
    $(document).ready(function() {
      $(".adminprofilee").click(function(event) {
        event.preventDefault(); // Prevent default link behavior

        var link = $(this); // The clicked link
        var buttonText = link.find("span.buttonText"); // Corrected selector for buttonText

        // Disable the link and show the spinner
        link.addClass("disabled"); // Add a class to make it look like a disabled button
        buttonText.hide();
        link.find("i#spin").show(); // Corrected selector for the spinner icon

        // Simulate delay to see the loader in action
        setTimeout(function() {
          // After the delay, you can redirect to the approvedKyc URL
          window.location.href = link.attr("href");
        }, 2000); // Adjust the delay time as needed
      });
    });
    </script>
