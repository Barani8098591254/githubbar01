@include('admin.common.header')
@include('admin.common.sidebar')

<style>
    label.control-label.col-md-3.oneee {
    padding-right: 235px;
}


.ckeditor-oneeee {
    margin-top: 30px;
    margin-left: 22px;
}
.text-center.button-contact {
    margin-left: 95%;
}

</style>

    <div class="page-wrapper" style="min-height: 478px;">
        <div class="container-fluid">

            <!-- Title -->
            <div class="row heading-bg">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h5 class="txt-dark">{{$title}}</h5>
                </div>

                <!-- Breadcrumb -->
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="index.html">Dashboard</a></li>
                        <li><a href="{{adminBaseurl()}}support"><span>Contact</span></a></li>
                        <li class="active"><span>Replay Contact</span></li>
                    </ol>
                </div>
                <!-- /Breadcrumb -->

            </div>
            <!-- /Title -->




            <div class="panel panel-default card-view">

                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-wrap">
                                    <form action="" class="form-horizontal reply_page" name="reply_page" id="reply_page" method="post" autocomplete="off">
                                       @csrf
                                       <div class="form-body">
                                        <h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-account mr-10"></i>Reply page</h6>
                                        <hr class="light-grey-hr"/>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Name  :</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static">{{$reply->name}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->

                                        </div>
                                        <!-- /Row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">E-Mail  :</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static">{{$reply->email}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>

                                        {{-- <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Phone Number:</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static">{{$reply->phoneno}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div> --}}

                                        <!-- /Row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Subject  :</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static">{{$reply->message}}</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                            <!--/span-->
                                            <!--/span-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Status :</label>
                                                    <div class="col-md-9">
                                                        <?php
                                                        if($reply->status == 1){
                                                        $status = '<span class="label label-success">Replied</span>';
                                                        }elseif($reply->status == 0){
                                                        $status = '<span class="label label-danger">Not Replied</span>';
                                                        }
                                                        ?>
                                                        <?php echo $status ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                       @if($reply->admin_msg)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3">Admin Replay  :</label>
                                                    <div class="col-md-9">
                                                        <p class="form-control-static">{{$reply->message}}</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        @endif
                                    @if($reply->status == 0)
                                    <label class="control-label col-md-3 oneee">Message :</label>
                                            <div class="col-md-12">
                                                <div class="ckeditor-oneeee">
                                               <div class="form-group">
                                                        <textarea class="summernote" name="admin_msg" id="admin_msg" cols="44" rows="2"
                                                       value=""></textarea>


                                       </div>
                                    </div>
                                            </div>

                                    @endif

                                        <div class="form-actions mt-10">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-offset-3 col-md-9">

                                                            <div class="text-center button-contact">
                                                            {{-- <button type="submit" class="btn btn-success  mr-10">Submit</button> --}}
                                                            @if($reply->status == 0)
                                                            <button type="submit" id="login_btn" name="login_btn" class="btn btn-success mt-5">Send <i class="fa fa-spinner fa-spin" id="spin" style="font-size:20px; display:none;"></i></button>
                                                            <button type="button" class="button content__space loader" name="loader" id="loader"
                                                                disabled="" style="display:none"></button>
                                                            @endif
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"> </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>









    @include('admin.common.footer')





<script>
    $(function() {
    $("form[name='reply_page']").validate({


        // using required rules steps 1


        rules: {
            admin_msg: {
                required: true,

            },




            admin_msg: {
                required: true,
                pattern: /^\S+(?: \S+)*$/

            }
        },
        // this is message showing popup validation  step 3


        messages: {


            admin_msg: {
                required: "Please enter admin message",
                pattern: 'One space only allword'
            }

        },


        submitHandler: function (reply_page) {
            $(".btn").attr("disabled", true);
            $("#spin").fadeIn(500);
            reply_page.submit();


        }



    });
});

</script>
