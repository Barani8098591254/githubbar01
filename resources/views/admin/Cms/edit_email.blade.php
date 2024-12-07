@include('admin.common.header')

@include('admin.common.sidebar')

<div class="page-wrapper" style="min-height: 523px;">
    <div class="container-fluid">

        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">{{$title}}</h5>
            </div>

            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="dashboard">Dashboard</a></li>
                    <li><a href="email"><span>Email</span></a></li>
                    <li class="active"><span>{{$title}}</span></li>
                </ol>
            </div>
            <!-- /Breadcrumb -->

        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{$title}}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="row mt-40">
                                <div class="col-md-12">
                                    <div class="form-wrap">
                                        <form action="#">
                                            <div class="form-group">
                                                <label class="control-label mb-10">Phone</label>
                                                <input type="text" placeholder="" data-mask="" class="form-control">
                                            </div>



                                            <div class="form-group">
                                                <label class="control-label mb-10">subject</label>
                                                <input type="text" placeholder="" data-mask="" class="form-control">
                                            </div>




                                            <div class="form-group">
                                                <label class="control-label mb-10">Description</label>
                                                <div class="summernote"></div>
                                        </div>

                                        <button type="" class="btn btn-success mr-10" id="btn-submit">Submit</button>


                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->




@include('admin.common.footer')

