
<!-- /Row -->
</div>

<!-- Footer -->
<footer class="footer container-fluid pl-30 pr-30">
    <div class="row">
        <div class="col-sm-12">
            <p>2017 &copy; Philbert. Pampered by Hencework</p>
        </div>
    </div>
</footer>
<!-- /Footer -->

</div>
<!-- /Main Content -->






<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" ></script>
<script src="{{ URL::to('/') }}/public/assets/admin/Js/jquery.validate.min.js?1"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/dist/js/dataTables-data.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/jquery.counterup/jquery.counterup.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/dist/js/jquery.slimscroll.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/moment/min/moment.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/dist/js/simpleweather-data.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/dist/js/dropdown-bootstrap-extended.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/chart.js/Chart.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/raphael/raphael.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/morris.js/morris.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/switchery/dist/switchery.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/switchery/dist/switchery.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/dist/js/init.js"></script>
<script src="{{URL::to('/')}}/public/assets/admin/vendors/bower_components/summernote/dist/summernote.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/dist/js/summernote-data.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/assests/js/patternlock/patternLock.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/dist/js/isotope.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/dist/js/lightgallery-all.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/dist/js/froogaloop2.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/dist/js/gallery-data.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/Js/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{URL::to('/')}}/public/assets/admin/Js/validate.min.js"></script>
<script src="{{URL::to('/')}}/public/assets/admin/Js/additional-methods.min.js?1"></script>
<script src="{{URL::to('/')}}/public/assets/admin/Js/admin-additional.js"></script>
<?php if($js_file != ''){ ?>
    <script src="{{URL::to('/')}}/public/assets/admin/customs_js/<?php echo ($js_file) ? $js_file : '' ?>.js?<?php echo time(); ?>"></script>
<?php } ?>

<script src="{{URL::to('/')}}/public/assets/admin/vendors/validation.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/Js/additional-methods.min.js"></script>
<script src="{{URL::to('/')}}/public/assets/admin/vendors/admin.js"></script>




<script type="text/javascript">
    var base_url = "<?php echo URL::to('/').'/'.env('ADMIN_URL', ''); ?>";
</script>





<script type="text/javascript">
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
</script>


<?php if($js_file != ''){ ?>
<script src="{{URL::to('/')}}/public/assets/admin/customs_js/<?php echo ($js_file) ? $js_file : '' ?>.js?<?php echo time(); ?>"></script>
<?php } ?>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script type="text/javascript">
    @if(session('success'))
    toastr.success('{{session("success")}}', 'Success', {timeOut: 2000});
    @endif

    @if(session('error'))
    toastr.error('{{session("error")}}',{timeOut: 2000});
    @endif

    @if(session('primary'))
    toastr.primary('{{session("primary")}}', {timeOut: 2000});
    @endif

    @if(session('message'))
    toastr.message('{{session("message")}}', {timeOut: 2000});
    @endif

    @if(session('info'))
    toastr.info('{{session("info")}}', {timeOut: 2000});
    @endif


    @if (!empty($errors->all()))
           @foreach ($errors->all() as $error)
               toastr.error("{{$error}}")
           @endforeach
    @endif
</script>




</html>
