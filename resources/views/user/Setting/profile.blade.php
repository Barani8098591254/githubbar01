@include('user.common.header')


<?php if($kyc->fStatus == 0){
    $proof_front_status = 'Not Yet Uploaded';
    $proof_front_color = 'yel-clr';
 }else if($kyc->fStatus == 1){
    $proof_front_status = 'Pending';
    $proof_front_color = 'pnd-clr';
 }else if($kyc->fStatus == 2){
    $proof_front_status = 'Rejected';
    $fReason = $kyc->fReason;
     $proof_front_color = 'red-clr';
 }else if($kyc->fStatus == 3){
    $proof_front_status = 'Approved';
     $proof_front_color = 'grn-clr';
 }?>

 <?php if($kyc->bStatus == 0){
    $proof_back_status = 'Not Yet Uploaded';
    $proof_back_color = 'yel-clr';
 }else if($kyc->bStatus == 1){
    $proof_back_status = 'Pending';
    $proof_back_color = 'pnd-clr';
 }else if($kyc->bStatus == 2){
    $proof_back_status = 'Rejected';
    $back_reject_reason = $kyc->back_reject_reason;
    $proof_back_color = 'red-clr';
 }else if($kyc->bStatus == 3){
    $proof_back_status = 'Approved';
    $proof_back_color = 'grn-clr';
 }?>

<?php if($kyc->sStatus == 0){
    $selfi_status = 'Not Yet Uploaded';
    $selfi_color = 'yel-clr';
 }else if($kyc->sStatus == 1){
    $selfi_status = 'Pending';
    $selfi_color = 'pnd-clr';
 }else if($kyc->sStatus == 2){
    $selfi_status = 'Rejected';
    $selfie_reject_reason = $kyc->selfie_reject_reason;
    $selfi_color = 'red-clr';
 }else if($kyc->sStatus == 3){
    $selfi_status = 'Approved';
    $selfi_color = 'grn-clr';
 }?>





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
                    <div class="transaction-wrapper profile-change">
                        <ul class="nav nav-pills mb-3 justify-content-start" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="KYC nav-link active" id="transaction-tab1" data-bs-toggle="pill"
                                    data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1"
                                    aria-selected="true">Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="transaction-tab2" data-bs-toggle="pill"
                                    data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2"
                                    aria-selected="false">Change Password & TFA</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="transaction-tab3" data-bs-toggle="pill"
                                    data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3"
                                    aria-selected="false">KYC</button>
                            </li>



                        </ul>
                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="tab1" role="tabpanel"
                                aria-labelledby="transaction-tab1">

                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                        <div class="personal-info ">
                                            <h3 class="mb-3">Personal Setting</h3>
                                            <div class="col-lg-12">
                                                <form id="profile-form" class="mt-0 profile-form" method="post" autocomplete="off">
                                                    {{ csrf_field() }}
                                                    <div class="profit-calculator-form">
                                                        <div class="row ">
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label>First Name *</label>
                                                                    <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo @$user->firstname; ?>"
                                                                        placeholder="Enter Your First Name ">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label>Last Name *</label>
                                                                    <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo @$user->lastname; ?>"
                                                                        placeholder="Enter Your Last Name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row ">
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label>Date Of Birth *</label>
                                                                    <input type="date" name="dob" id="dob" class="form-control" value="<?php echo @$user->dob; ?>"
                                                                        placeholder="YYY-MM-DD ">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label>Mobile Number *</label>
                                                                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo @$user->mobile_no; ?>"
                                                                        placeholder="Enter Your Mobile Number">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row ">
                                                            <div class="col-lg-6">
                                                                <div class="form-group mb-4">
                                                                    <label>Address *</label>
                                                                    <input type="text" class="form-control" name="address" id="address" value="<?php echo @$user->address; ?>"
                                                                        placeholder="Enter Your Address ">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 selctcountry">
                                                                <div class="form-group mb-4">
                                                                    <label>Country *</label>

                                                                    <select class="select w-100" aria-label="Default select example" id="country" name="country">
                                                                        <option value="">Select Country </option>
                                                                         @php foreach ($country as $key => $value) { @endphp
                                                                          <option value="<?php echo $value->id; ?>" <?php echo ($value->id == @$user->country) ? 'selected' : ''; ?> ><?php echo $value->name; ?></option>
                                                                         @php } @endphp
                                                                      </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row ">
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>State *</label>
                                                                    <input type="text" class="form-control" name="state" id="state" value ="<?php echo @$user->state; ?>"
                                                                        placeholder="Enter Your State">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label>City *</label>
                                                                    <input type="text" class="form-control" name="city" id="city" value="<?php echo @$user->city; ?>" placeholder="Enter Your City">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" name="profile_btn" id="profile_btn" class="theme-btn  mt-20 profile_btn">Submit<i class="far fa-sign-in"></i></button>
                                                        <button type="button" name="loader" id="loader" class="theme-btn mt-4 " style="display: none;">Loading ...</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        </div>




                                        <div class="col-md-12 col-lg-6">

                                    <div class="personal-info ">
                                        <h3 class="mb-3">Security Pin </h3>
                                        @if(empty($checkWpin->w_pin))
                                        <div class="col-lg-12">
                                            <form id="securitysetting" class="mt-0 securitysetting" name="securitysetting" method="post" autocomplete="off">
                                                {{ csrf_field() }}
                                                <div class="profit-calculator-form">
                                                    <div class="row ">
                                                        <div class="col-lg-12">
                                                            <div class="form-group mb-4">
                                                                <label>Security Pin *</label>
                                                                <input type="password" class="form-control" name="pin" id="pin" value=""
                                                                    placeholder="Please Enter New Security Pin">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group mb-4">
                                                                <label>Confirm Security Pin *</label>
                                                                <input type="password" class="form-control" name="c_pin" id="c_pin" value=""
                                                                    placeholder="Please Enter Confirm Security Pin">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" name="sec_btn" id="sec_btn" class="theme-btn mt-20 sec_btn">Submit<i class="far fa-sign-in"></i></button>
                                                    <button type="button" name="loader" id="loaderss" class="theme-btn mt-4 loaderss" style="display: none;">Loading ...</button>
                                                </div>
                                            </form>
                                        </div>

                                        @else


                                            <div class="col-lg-12">
                                            <form id="c_pin-form" class="mt-0 c_pin-form" name="c_pin-form" method="post" autocomplete="off">
                                                {{ csrf_field() }}
                                                <div class="profit-calculator-form">
                                                    <div class="row ">

                                                        <div class="col-lg-12">
                                                            <div class="form-group mb-4">
                                                                <label>Current Security Pin *</label>
                                                                <input type="password" class="form-control" name="current_pin" id="current_pin" value=""
                                                                    placeholder="Please Enter Current Security Pin">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group mb-4">
                                                                <label>New Security Pin *</label>
                                                                <input type="password" class="form-control" name="pin" id="pin" value=""
                                                                    placeholder="Please Enter New Security Pin">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group mb-4">
                                                                <label>Confirm Security Pin *</label>
                                                                <input type="password" class="form-control" name="c_pin" id="c_pin" value=""
                                                                    placeholder="Please Enter Confirm Security Pin">
                                                            </div>
                                                            <button type="button" style="float:right" name="profile_btn" id="send_email_pin" data-id="<?php echo encrypt_decrypt('encrypt',userId()); ?>"  class="btn sendotppp send_email_pin addressOTPbtn reset_pin">Reset Pin</button>

                                                            <button type="button" style="float:right;display:none" name="profile_btn" id="" class="btn sendotppp addressOTPbtn reset_pin resend-loader">Loading ...</button>
                                                        </div>
                                                    </div>


                                                    <button type="submit" name="c_pin-btn" id="c_pin-btn" class="theme-btn  mt-20 c_pin-btn ">Submit<i class="far fa-sign-in"></i></button>
                                                    <button type="button" name="loader" id="loader" class="theme-btn mt-4"  style="display: none;">Loading ...</button>
                                                </div>
                                            </form>
                                            </div>
                                            @endif

                                    </div>
                                </div>
                                </div>
                            </div>




                            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="transaction-tab2">

                                <div class="row">
                                    <div class="col-md-12 col-lg-6">

                                        <div class="personal-info">

                                            <h3 class="mb-3">Change Password</h3>
                                            <form  id="changepw-form" class="mt-0 changepw-form"  name="changepw-form" autocomplete="off">
                                                {{ csrf_field() }}
                                                <div class="profit-calculator-form">
                                                    <div class="form-group">
                                                        <label>Old Password *</label>
                                                        <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter Current Password">
                                                        <span class="eye-icon" onclick="togglePasswordVisibility('current_password')">
                                                            <span class="icon">
                                                                <i id="eye-icon-current_password" class="fas fa-eye-slash"></i>
                                                            </span>
                                                        </span>
                                                        <label id="current_password-error" class="error" for="current_password"></label>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>New Password *</label>
                                                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter New Password">
                                                            <span class="eye-icon" onclick="togglePasswordVisibility('password')">
                                                                <span class="icon">
                                                                <i id="eye-icon-password" class="fas fa-eye-slash"></i>
                                                                </span>
                                                                </span>
                                                                <label id="password-error" class="error" for="password"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Repeat The New Password *</label>
                                                            <input type="password" name="c_password" id="c_password" class="form-control" placeholder="Confirm Password ">
                                                            <span class="eye-icon" onclick="togglePasswordVisibility('c_password')">
                                                            <span class="icon">
                                                            <i id="eye-icon-c_password" class="fas fa-eye-slash"></i>
                                                            </span>
                                                            </span>
                                                            <label id="c_password-error" class="error" for="c_password"></label>
                                                            </div>
                                                    </div>
                                                    <button type="submit" name="cng-btn" id="cng-btn" class="theme-btn mt-4 cng-btn">Submit <i class="far fa-sign-in"></i></button>
                                                    <button type="buttton" name="kyc-btn" id="kyc-btn" class="theme-btn mt-4 cng-btn loaders" style="display:none">Loading...</button>
                                                </div>

                                            </form>
                                        </div>



                                    </div>
                                    <div class="col-md-12 col-lg-6">

                                        <div class="personal-info">


                                            <h3 class="mb-3">TFA</h3>
                                                <form method="post" id="tfa-form" name="tfa-form" class="mt-0  tfa-form" method="post"
                                                action="{{ url('tfaenable') }}" autocomplete="off">
                                                @csrf


                                                <?php if($user->tfaStatus == 0){ ?>


                                                <div class="profit-calculator-form">
                                                    <div class="form-group mb-4">
                                                        <label>TFA Code</label>
                                                        <input type="password" class="form-control" name="tfa_code" id="tfa_code"
                                                            placeholder="Enter Your Code">
                                                    </div>
                                                    <div class="form-group  mb-4">
                                                        <label>Login Password</label>
                                                        <input type="password" class="form-control" name="password" id="password"
                                                            placeholder="Enter Your Password">
                                                    </div>
                                                    <div class="row align-items-center position-relative">
                                                        <div class="col-lg-8">
                                                            <div class="form-group">
                                                                <label>Secret Key</label>
                                                                <input type="text" class="form-control" name="randcode" id="randcode"
                                                                placeholder="Enter Your Key" value="<?php echo $secretKey; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 qr-code-col">
                                                            <div class="qrimgggg mt-4">
                                                                <?php echo $qrcode;  ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <?php
                                                }else{

                                                    ?>
                                                 <div class="profit-calculator-form">
                                                    <div class="form-group mb-4">
                                                        <label>TFA Code</label>

                                                         <input type="hidden"  class="form-control" name="randcode" value="<?php echo $randcode; ?>" readonly>

                                                        <input type="password" class="form-control" name="tfa_code" id="tfa_code" placeholder="Enter Your Code">
                                                    </div>
                                                    <div class="form-group  mb-4">
                                                        <label>Login Password</label>
                                                        <input type="password" class="form-control" name="password" id="password"
                                                            placeholder="Enter Your Password">
                                                    </div>

                                                    <?php
                                                }
                                                 ?>

                                                    <button type="submit" name="tfa_btn" id="tfa_btn" class="theme-btn mt-4 tfa_btn"><?php echo $user->tfaStatus == 0 ? 'Enable' : 'Disable'; ?></button>

                                                </div>

                                            </form>

                                        </div>
                                    </div>

                                </div>


                            </div>



                            <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="transaction-tab3">
                                <form method="POST" id="kyc-form" action="/upload" name="kyc-form" class="kyc-form" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="kycsec">
                                    <div class="row align-items-center">
                                        <div class="col-md-12 col-lg-5">

                                                <div class="form-group mt-3">
                                                    <label for="exampleInputnumber1" class="mb-2">National ID Proof
                                                        Number*</label>
                                                    <input type="text" class="form-control" id="exampleInputnumber1" name="proof_number" value="<?php echo $kyc->proof_number ?>"
                                                        placeholder="National ID proof number">
                                                </div>

                                        </div>
                                        <div class="col-md-12 col-lg-7">
                                            <div class="termsrule">
                                                <p>1.Enter Your National ID Proof Number </p>
                                                <p>2.Kindly Upload your Files JPEG/JPG/PNG and File Must be Less
                                                    Than 1 MB</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12 col-lg-4">
                                            <h6 class="mb-3">Proof Front* </h6>
                                            <div class="card frontprrof" >
                                                  <input type="file"  name="front" id="proof_front"  class="proof_front"  capture style="display:none"  capture style="display:none" accept="image/png, image/jpg, image/jpeg"/>

                                                @if(isset($kyc->front) && !empty($kyc->front))
                                                    <img src="{{ $kyc->front }}" width="100%" style="max-height: 190px;"alt="Profile Picture"  id="<?php echo ($kyc->fStatus == 2) ? "fntimg" : ""; ?>" class="profilePicture frontimg profilePicture" />
                                                @else
                                                    <img src="{{ URL::to('/') }}/public/assets/user/img/logo/proofimg.png" width="100%" style="max-height: 190px;" class="img-fluid" id="fntimg" />
                                                    <!-- <input type="file" class="form-control" id="front" name="front" capture style="display:none"  capture style="display:none" accept="image/png, image/jpg, image/jpeg"/> -->
                                                @endif
                                            </div>
                                            <?php if($kyc->fStatus  == 0 || $kyc->fStatus  == 2){
                                                $front_submit_btn = '1'; }else{ $front_submit_btn = ''; } ?>




                                            <div class="col-xs-6 text-center">
                                                <span class="block capitalize-font pb-20">
                                                    @if($kyc->fStatus == 3)
                                                        <span class="btn uploadbtnn frontclr" style="color: green">Approved</span>
                                                    @elseif($kyc->fStatus == 2)
                                                        <span class="btn uploadbtnn frontclr" style="color: red">Rejected</span>
                                                        <p>Reason:  {{ $fReason }}</p>
                                                    @elseif($kyc->fStatus == 1)
                                                        <span class="btn uploadbtnn frontclr" style="color:blue">Pending</span>
                                                    @else
                                                        <span class="btn uploadbtnn frontclr">Not yet uploaded</span>
                                                    @endif
                                                </span>
                                            </div>

                                        </div>
                                        <div class="col-md-12 col-lg-4">
                                            <h6 class="mb-3">Proof Back*</h6>
                                            <div class="card">
                                                <input type="file" name="back" id="proof_back" class="proof_back"  capture style="display:none"  capture style="display:none" accept="image/png, image/jpg, image/jpeg"/>
                                                @if(isset($kyc->back) && !empty($kyc->back))
                                                    <img src="{{ $kyc->back }}" width="100%" width="100%" style="max-height: 190px;" alt="Profile Picture" id="<?php echo ($kyc->bStatus == 2) ? "bckimg" : ""; ?>" class="profilePicture backimg" />
                                                @else
                                                    <img src="{{ URL::to('/') }}/public/assets/user/img/logo/proofimg.png" width="100%" style="max-height: 190px;" class="img-fluid" id="bckimg" />
                                                    <!-- <input type="file" class="form-control" id="back" name="back" placeholder="Street" /> -->
                                                @endif


                                            </div>
                                            <?php if($kyc->bStatus  == 0 || $kyc->bStatus  == 2){ $back_submit_btn = '1';  }else { $back_submit_btn = ''; }?>



                                            <div class="col-xs-6 text-center">
                                                <span class="block capitalize-font pb-20">
                                                    @if($kyc->bStatus == 3)
                                                        <span class="btn uploadbtnn backclr" style="color: green">Approved</span>
                                                    @elseif($kyc->bStatus == 2)
                                                        <span class="btn uploadbtnn backclr" style="color: red">Rejected</span>
                                                        <p>Reason:  {{ $back_reject_reason }}</p
                                                    @elseif($kyc->bStatus == 1)
                                                        <span class="btn uploadbtnn backclr" style="color:blue">Pending</span>
                                                    @else
                                                    <span class="btn uploadbtnn backclr">Not yet uploaded</span>
                                                    @endif
                                                </span>
                                            </div>


                                        </div>
                                        <div class="col-md-12 col-lg-4">
                                            <h6 class="mb-3">Selfie*</h6>
                                            <div class="card">
                                                <input type="file" name="selfi" id="selfi" class="selfi"  capture style="display:none"  capture style="display:none" accept="image/png, image/jpg, image/jpeg"/>
                                                @if(isset($kyc->selfi) && !empty($kyc->selfi))
                                                <img src="{{ $kyc->selfi }}" width="100%" style="max-height: 190px;" alt="Profile Picture" id="<?php echo ($kyc->sStatus == 2) ? "sfiimg" : ""; ?>" class="profilePicture selfiimg" />
                                            @else
                                                <img src="{{ URL::to('/') }}/public/assets/user/img/logo/proofimg.png" width="100%" style="max-height: 190px;" id="sfiimg" class="img-fluid" />
                                            @endif


                                            </div>
                                            <?php if($kyc->sStatus  == 0 || $kyc->sStatus  == 2){ $selfi_submit_btn = '1';  }else{ $selfi_submit_btn = ''; } ?>


                                            <div class="col-xs-6 text-center">
                                                <span class="block capitalize-font pb-20">
                                                    @if($kyc->sStatus == 3)
                                                        <span class="btn uploadbtnn selficlr" style="color: green">Approved</span>
                                                    @elseif($kyc->sStatus == 2)
                                                        <span class="btn uploadbtnn selficlr" style="color: red">Rejected</span>
                                                        <p>Reason:  {{ $selfie_reject_reason }}</p>
                                                        @elseif($kyc->sStatus == 1)
                                                        <span class="btn uploadbtnn selficlr" style="color:blue">Pending</span>
                                                    @else
                                                    <span class="btn uploadbtnn selficlr">Not yet uploaded</span>
                                                    @endif
                                                </span>
                                            </div>

                                        </div>
                                    </div>




                                <?php if($front_submit_btn == 1 || $back_submit_btn  == 1 || $selfi_submit_btn == 1){ ?>
                                    <div class="submtibtn mt-4">

                                        <button type="submit"  name="kyc_btn" id="kyc_btn" class="btn submitbttn kyc_btn">Submit</button>
                                        <button type="button" name="kyc_btn" id="kyc_btn" class="btn submitbttn loader" disabled="disabled" style="display: none;">Loding ...</button>

                                    </div>
                               <?php } ?>

                                </div>
                                <div class="termscont">
                                </form>
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
    $('#send_email_pin').click(function(){

    var user_id = $(this).attr("data-id");
    $.ajax({
         type: "POST",
         url: base_url + "send_email_pin",
         data: {pin:user_id},
         dataType: "text",
         cache:false,
         async:true,
        beforeSend: function() {
            // $('#pin-btn').hide();
            $('.send_email_pin').hide();
            $('.resend-loader').show();
        },
        success: function (data) {

          var res = JSON.parse(data);

            if(res.status == 1){

                $('.resend-loader').hide();
                $('.send_email_pin').show();
                toastr.success(res.msg,'Success', {timeOut: 2000});


            }else{

                $('.resend-loader').hide();
                // $('#pin-btn').show();
                $('.send_email_pin').show();
               toastr.error(res.msg, {timeOut: 2000});

            }


        }
    });
});

</script>
