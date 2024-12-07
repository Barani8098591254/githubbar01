
@include('admin.common.header')
@include('admin.common.sidebar')


        <!-- Main Content -->
         <div class="page-wrapper">
            <div class="container-fluid">

                <!-- Title -->
                <div class="row heading-bg">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                      <h5 class="txt-dark">ipwhitelist</h5>
                    </div>
                    <!-- Breadcrumb -->
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                      <ol class="breadcrumb">
                        <li><a href="dashboard">Dashboard</a></li>
                        <li class="active"><span>ipwhitelist</span></li>
                      </ol>
                    </div>
                    <!-- /Breadcrumb -->
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">

                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h6 class="panel-title txt-dark">{{$title}}</h6>
                                </div>
                                <div class="clearfix"></div>
                            </div>



                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table id="datable_1" class="table table-hover display  pb-30" >
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Admin Ip</th>
                                                        <th>Status</th>
                                                        <th>Date On</th>
                                                        <th>Action</th>




                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>Tiger Nixon</td>
                                                        <td>System Architect</td>
                                                        <td>Edinburgh</td>
                                                        <td>61</td>
                                                        <td>2011/04/25</td>


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




@include('admin.common.footer')
