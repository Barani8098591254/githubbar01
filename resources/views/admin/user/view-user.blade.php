@include('admin.common.header')

<style>
    span.counter {
    font-size: 16px;
}
td.date-trim {
    white-space: nowrap;
}



</style>
@include('admin.common.sidebar')

      <!-- Main Content -->
       <div class="page-wrapper">



<div class="row pa-30">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">User Management</h5>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{admin_url()}}dashboard">Dashboard</a></li>
                <li><a href="{{ URL::to('/') .'/'. env('ADMIN_URL') . '/usersList/' }}">User List</a></li>
                <li class="active"><span>User Profile</span></li>

            </ol>
        </div>
    </div>
        <!-- /Breadcrumb -->



        <div class="container-fluid pt-25">

            <!-- Row -->
            <div class="row">
                <div class="col-lg-3 col-xs-12">
                    <div class="panel panel-default card-view  pa-0">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body  pa-0">
                                <div class="profile-box">
                                    <div class="profile-cover-pic">

                                        <div class="profile-image-overlay"></div>
                                    </div>
                                    <div class="profile-info text-center">
                                        <div class="profile-img-wrap">
                                            <img class="inline-block mb-10" src="https://res.cloudinary.com/dyeyiicvo/image/upload/v1694587787/user1_tr03bn.png" alt="user"/>

                                        </div>
                                        <h5 class="block mt-10 mb-5 weight-500 capitalize-font txt-danger">{{$userDetails->username}}</h5>
                                        <div class="heading">
                                            <h6 class="block capitalize-font pb-20">{{encrypt_decrypt('decrypt',$userDetails->email)}}</h6>
                                        </div>
                                    </div>
                                    <div class="social-info">
                                        <div class="row">
                                            <div class="col-xs-6 text-center">
                                                <span class="counts block head-font"><span class="counter">{{ date('d M Y ',strtotime($userDetails->created_at))}}</span></span>
                                                <span class="counts-text block">Registration Date</span>
                                            </div>

                                            <div class="col-xs-6 text-center">
                                                <span class="counts block head-font"><span class="counter">{{($userDetails->referralId) ? $userDetails->referralId : '--'}}</span></span>
                                                <span class="counts-text block">ReferrerId </span>
                                            </div>
                                        </div>
                                        <div id="myModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h5 class="modal-title" id="myModalLabel">Edit Profile</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Row -->
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="">
                                                                    <div class="panel-wrapper collapse in">
                                                                        <div class="panel-body pa-0">
                                                                            <div class="col-sm-12 col-xs-12">
                                                                                <div class="form-wrap">
                                                                                    <form action="#">
                                                                                        <div class="form-body overflow-hide">
                                                                                            <div class="form-group">
                                                                                                <label class="control-label mb-10" for="exampleInputuname_1">Name</label>
                                                                                                <div class="input-group">
                                                                                                    <div class="input-group-addon"><i class="icon-user"></i></div>
                                                                                                    <input type="text" class="form-control" id="exampleInputuname_1" placeholder="willard bryant">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="control-label mb-10" for="exampleInputEmail_1">Email address</label>
                                                                                                <div class="input-group">
                                                                                                    <div class="input-group-addon"><i class="icon-envelope-open"></i></div>
                                                                                                    <input type="email" class="form-control" id="exampleInputEmail_1" placeholder="xyz@gmail.com">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="control-label mb-10" for="exampleInputContact_1">Contact number</label>
                                                                                                <div class="input-group">
                                                                                                    <div class="input-group-addon"><i class="icon-phone"></i></div>
                                                                                                    <input type="email" class="form-control" id="exampleInputContact_1" placeholder="+102 9388333">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="control-label mb-10" for="exampleInputpwd_1">Password</label>
                                                                                                <div class="input-group">
                                                                                                    <div class="input-group-addon"><i class="icon-lock"></i></div>
                                                                                                    <input type="password" class="form-control" id="exampleInputpwd_1" placeholder="Enter pwd" value="password">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="control-label mb-10">Gender</label>
                                                                                                <div>
                                                                                                    <div class="radio">
                                                                                                        <input type="radio" name="radio1" id="radio_1" value="option1" checked="">
                                                                                                        <label for="radio_1">
                                                                                                        M
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <div class="radio">
                                                                                                        <input type="radio" name="radio1" id="radio_2" value="option2">
                                                                                                        <label for="radio_2">
                                                                                                        F
                                                                                                        </label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="control-label mb-10">Country</label>
                                                                                                <select class="form-control" data-placeholder="Choose a Category" tabindex="1">
                                                                                                    <option value="Category 1">USA</option>
                                                                                                    <option value="Category 2">Austrailia</option>
                                                                                                    <option value="Category 3">India</option>
                                                                                                    <option value="Category 4">UK</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-actions mt-10">
                                                                                            <button type="submit" class="btn btn-success mr-10 mb-30">Update profile</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">Save</button>
                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
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
                    <div class="panel panel-default card-view pa-0">
                        <div class="panel-wrapper collapse in">
                            <div  class="panel-body pb-0">
                                <div  class="tab-struct custom-tab-1">
                                    <ul role="tablist" class="nav nav-tabs nav-tabs-responsive" id="myTabs_8">
                                        <li class="active" role="presentation"><a  data-toggle="tab" id="profile_tab_8" role="tab" href="#profile_8" aria-expanded="false"><span>profile</span></a></li>
                                        <li  role="presentation" class="next"><a aria-expanded="true"  data-toggle="tab" role="tab" id="follo_tab_8" href="#follo_8"><span>User Balance</span></a></li>
                                        <li role="presentation" class=""><a  data-toggle="tab" id="photos_tab_8" role="tab" href="#photos_8" aria-expanded="false"><span>User Address</span></a></li>
                                        <li role="presentation" class=""><a  data-toggle="tab" id="earning_tab_8" role="tab" href="#earnings_8" aria-expanded="false"><span>Direct Referral</span></a></li>

                                        <li role="presentation" class=""><a  data-toggle="tab" id="earning_tab_9" role="tab" href="#earnings_9" aria-expanded="false"><span>Downline</span></a></li>

                                    </ul>
                                    <div class="tab-content" id="myTabContent_8">
                                        <div  id="profile_8" class="pa-30 tab-pane fade active in" role="tabpanel">
                                            <div class="panel-wrapper collapse in">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-wrap">
                                                                <form class="form-horizontal" role="form">
                                                                    <div class="form-body">
                                                                        <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Person's Info</h6>
                                                                        <hr class="light-grey-hr">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">First Name  :</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">{{($userDetails->first_name) ? $userDetails->first_name : '--'}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">Last Name  :</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">{{($userDetails->last_name) ? $userDetails->last_name : '--'}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                        </div>
                                                                        <!-- /Row -->
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">User Name  :</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">{{($userDetails->username) ? $userDetails->username : '--'}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">Date of Birth :</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">{{($userDetails->dob) ? $userDetails->dob : '--'}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->

                                                                        </div>
                                                                        <!-- /Row -->
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">ReferralId  :</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">{{($userDetails->referrerId) ? $userDetails->referrerId : '--'}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">Email Status :</label>
                                                                                    <div class="col-md-9">
                                                                                         <p class="form-control-static">
                                                                                        <?php if($userDetails->is_verify == '1'){ ?>
                                                                                            <span class="text-success">Verified</span>
                                                                                            <?php }else{ ?>
                                                                                            <span class="text-danger">Not Verified</span>
                                                                                            <?php } ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                            <!--/span-->
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">ReferrerId :</label>
                                                                                    <div class="col-md-9">

                                                                                        <p class="form-control-static">{{($userDetails->referralId) ? $userDetails->referralId : '--'}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">Acc Status :</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">
                                                                                        <?php if($userDetails->is_active == '1'){ ?>
                                                                                            <span class="text-success">Verified</span>
                                                                                            <?php }else{ ?>
                                                                                            <span class="text-danger">Not Verified</span>
                                                                                            <?php } ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                            <!--/span-->
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">Mobile NO :</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">{{($userDetails->mobile_no) ? $userDetails->mobile_no : '--'}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">Email Id :</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">{{encrypt_decrypt('decrypt',$userDetails->email)}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- /Row -->

                                                                        <div class="seprator-block"></div>

                                                                        <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account-box mr-10"></i>address</h6>
                                                                        <hr class="light-grey-hr">
                                                                        <div class="row">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">City :</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">{{($userDetails->city) ? $userDetails->city : '--'}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">State  :</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">{{($userDetails->state) ? $userDetails->state : '--'}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                        </div>
                                                                        <!-- /Row -->
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">Post Code  :</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">{{($userDetails->PostCode) ? $userDetails->PostCode : '--'}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">Country :</label>
                                                                                    <div class="col-md-9">
                                                                                        <p class="form-control-static">{{($userDetails->country) ? $userDetails->country : '--'}}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!--/span-->
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>







                                        <div  id="follo_8" class="tab-pane fade pa-15" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="followers-wrap">
                                                        <ul class="followers-list-wrap">
                                                            <form id="example-advanced-form" action="#">
                                                                <div class="table-wrap">
                                                                    <div class="table-responsive">
                                                                        <table class="table display product-overview dataTable" id="datable_1">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center">S.no</th>
                                                                                    <th>Name </th>
                                                                                    <th>Symbol</th>
                                                                                    <th>Balance</th>
                                                                                </tr>

                                                                            <tbody>


                                                                                @php $i = 1; @endphp
                                                                                @foreach ($userBalance as $value)
                                                                                @php $decimal = ($value->type == 0) ? 2 : 8; @endphp
                                                                                <tr>
                                                                                    <td class="text-center">{{$i}}</td>
                                                                                    <td >{{$value->name}}</td>
                                                                                    <td>{{$value->symbol}}</td>
                                                                                    {{-- <td>{{(get_balance(encrypt_decrypt('decrypt',$userId),$value->id)) ? number_format(get_balance($userId,$value->id),$decimal) : number_format('0.0000000',$decimal)}}</td> --}}

                                                                                    {{-- <td>{{(get_balance($userId,$value->id)) ? number_format(get_balance($userId,$value->id),$value->decimal) : number_format('0.0000000'),$value->decimal}}</td> --}}


                                                                                    <td>
                                                                                        {{ (get_balance($userId, $value->id) ? number_format(get_balance($userId, $value->id), $value->decimal) : number_format(0, $value->decimal)) }}
                                                                                    </td>



                                                                                </tr>

                                                                                @php $i++; @endphp
                                                                                @endforeach
                                                                            </tbody>

                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div  id="photos_8" class="tab-pane fade" role="tabpanel">
                                            <div class="col-md-12 pb-20">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <form id="example-advanced-form" action="#">
                                                            <div class="table-wrap">
                                                                <div class="table-responsive">
                                                                    <table class="table display product-overview dataTable" id="datable_2">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center">S.no</th>
                                                                                <th>Currency</th>
                                                                                <th>Address</th>
                                                                                <th>Tag</th>
                                                                                <th>Date Time</th>

                                                                            </tr>
                                                                        </thead>

                                                                        <tbody>


                                                                            @php $i = 1; @endphp
                                                                            @foreach ($userAddress as $address)
                                                                            <tr>
                                                                                <td class="text-center">{{$i}}</td>
                                                                                <td>{{$address->currency}}</td>
                                                                                <td >{{$address->address}}</td>
                                                                                <td >---</td>
                                                                                <td class="date-trim">{{date('d,M Y H:i a',strtotime($address->created_at))}}</td>
                                                                            </tr>


                                                                        </tbody>
                                                                        @php $i++; @endphp
                                                                        @endforeach
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div  id="earnings_8" class="tab-pane fade" role="tabpanel">
                                            <div class="col-md-12 pb-20">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <form id="example-advanced-form" action="#">
                                                            <div class="table-wrap">
                                                                <div id="datable_1_wrapper" class="dataTables_wrapper">
                                                                <div class="dataTable display product-overview table">
                                                                    <table id="datable_3" class="table table-hover display  pb-30 dataTable display product-overview table" >
                                                                        <thead>
                                                                            <tr>
                                                                                <th>S.No</th>
                                                                                <th>UserName</th>
                                                                                <th>userEmail</th>
                                                                                <th>User ReferralId</th>
                                                                                <th>Date Time</th>

                                                                            </tr>
                                                                        </thead>


                                                                        <tbody>


                                                                            @php $i = 1; @endphp
                                                                           @foreach ($userReferral as $referral)
                                                                            <tr>
                                                                            <td class="text-center">{{$i}}</td>
                                                                            <td>{{ $referral->username }}</td>
                                                                            <td> {{ encrypt_decrypt("decrypt",$referral->email) }} </td>
                                                                            <td> {{ $referral->referralId }} </td>
                                                                            <td class="date-trim">{{date('d,M Y H:i a',strtotime($referral->created_at))}}</td>
                                                                            </tr>


                                                                        </tbody>
                                                                        @php $i++; @endphp
                                                                        @endforeach
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>

                                         <div  id="earnings_9" class="tab-pane fade" role="tabpanel">
                                            <div class="col-md-12 pb-20">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <form id="example-advanced-form" action="#">
                                                            <div class="table-wrap">
                                                                <div id="datable_1_wrapper" class="dataTables_wrapper">
                                                                <div class="dataTable display product-overview table">
                                                                    <table id="datable_3" class="table table-hover display  pb-30 dataTable display product-overview table" >
                                                                        <thead>
                                                                            <tr>
                                                                                <th>S.No</th>
                                                                                <th>UserName</th>
                                                                                <th>userEmail</th>
                                                                                <th>User ReferralId</th>
                                                                                <th>Date Time</th>

                                                                            </tr>
                                                                        </thead>


                                                                        <tbody>


                                                                            @php $i = 1; @endphp
                                                                           @foreach ($downline as $referral)
                                                                            <tr>
                                                                            <td class="text-center">{{$i}}</td>
                                                                            <td>{{ $referral->username }}</td>
                                                                            <td> {{ encrypt_decrypt("decrypt",$referral->email) }} </td>
                                                                            <td> {{ $referral->referralId }} </td>
                                                                            <td class="date-trim">{{date('d,M Y H:i a',strtotime($referral->created_at))}}</td>
                                                                            </tr>


                                                                        </tbody>
                                                                        @php $i++; @endphp
                                                                        @endforeach
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>


                                            <div  id="earnings_10" class="tab-pane fade" role="tabpanel">
                                            <div class="col-md-12 pb-20">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <form id="example-advanced-form" action="#">
                                                            <div class="table-wrap">
                                                                <div id="datable_10_wrapper" class="dataTables_wrapper">
                                                                <div class="dataTable display product-overview table">
                                                                    <table id="datable_10" class="table table-hover display  pb-30 dataTable display product-overview table" >
                                                                        <thead>
                                                                            <tr>
                                                                                <th>S.No</th>
                                                                                <th>UserName</th>
                                                                                <th>userEmail</th>
                                                                                <th>User ReferralId</th>
                                                                                <th>Date Time</th>

                                                                            </tr>
                                                                        </thead>


                                                                        <tbody>


                                                                            @php $i = 1; @endphp
                                                                           @foreach ($downline as $referral)
                                                                            <tr>
                                                                            <td class="text-center">{{$i}}</td>
                                                                            <td>{{ $referral->username }}</td>
                                                                            <td> {{ encrypt_decrypt("decrypt",$referral->email) }} </td>
                                                                            <td> {{ $referral->referralId }} </td>
                                                                            <td class="date-trim">{{date('d,M Y H:i a',strtotime($referral->created_at))}}</td>
                                                                            </tr>


                                                                        </tbody>
                                                                        @php $i++; @endphp
                                                                        @endforeach
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>


                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>





@include('admin.common.footer')


<script>
    $(document).ready(function () {
        $('#datable_3').DataTable({
            "searching": true // Enable searching
        });
    });
   </script>


<script>
    $(document).ready(function () {
        $('#datable_2').DataTable();
    });
</script>

<script>
    $(document).ready(function () {
        $('#datable_10').DataTable({
            
        });
    });
    </script>
