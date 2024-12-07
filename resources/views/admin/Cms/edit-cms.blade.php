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
                    <li><a href="cms"><span>Cms</span></a></li>
                    <li class="active"><span>Edit Cms</span></li>
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
                                        <form action="{{URL::to('/')}}/{{env('ADMIN_URL')}}/updatecms" name="updatecms" id="updatecms" method="post">
                                            @csrf

                                            <div class="form-group">
                                                <label class="control-label mb-10">Name</label>
                                                <input type="text" placeholder="" name="name" id="name" class="form-control" value="{{$cms->title}}">
                                            </div>


                                            <input type="hidden" name="cmsid" value="{{encrypt_decrypt('encrypt',$cms->id)}}">


                                            <div class="form-group">
                                                <label class="control-label mb-10">Status</label>
                                                <select class="form-control valid" name="status" id="status" data-placeholder="Choose a Category" tabindex="1" aria-invalid="false" name="status" id="status">
                                                    <option value="1" name="status" id="status" <?php echo ($cms->status == 1) ? 'selected' : '' ?> >Active
                                                    </option>
                                                    <option value="0" name="status" id="status" <?php echo ($cms->status == 0) ? 'selected' : '' ?> >Inactive
                                                    </option>
                                                </select>
                                            </div>



                                            <div class="form-group">
                                                <label class="control-label mb-10">Description</label>
                                                <textarea class="summernote" name="description" id="description">{{$cms->description}}</textarea>


                                            </div>

                                        <button type="" class="btn btn-success mr-10" id="btn-submit">Submit <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i></button>


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




<script>
       $(function () {
        $("form[name='updatecms']").validate({



            // using required rules steps 1


            rules: {
                name: {
                    required: true,
                },
                status: "required",
                description: "required",

                // using required + option rules step 2

                name: {

                    required: true,
                    pattern: /^\S+(?: \S+)*$/

                },


                status: {
                required: true,
                    },


                    description: {
                    required: true,
                    pattern: /^\S+(?: \S+)*$/

                }
            },
            // this is message showing popup validation  step 3


            messages: {
                name: {

                    required: "Please enter Name",
                    pattern: 'One Space will be allowed',



                },


                status:
                {
                    required: "Select your correct status",


                },



                description:
                {
                    required: "Please enter your description",

                }

            },

            submitHandler: function (set) {
                $("#btn-submit").attr("disabled", true);
                $("#spin").fadeIn(500);
                $("#loader").fadeIn(500);

                // Simulate delay to see the loader in action
                setTimeout(function () {
                    set.submit();
                }, 2000);
            }
        });
    });

</script>
