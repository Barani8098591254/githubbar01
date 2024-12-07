<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/dist/js/jquery.slimscroll.js"></script>
<script src="{{ URL::to('/') }}/public/assets/admin/dist/js/init.js"></script>
<script src="{{URL::to('/')}}/public/assets/admin/dist/patternlock/patternLock.js"></script>

<script src="{{URL::to('/')}}/public/assets/admin/Js/admin-additional.js?"<?php echo time(); ?>></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{URL::to('/')}}/public/assets/admin/Js/admin.js?<?php echo time(); ?>"></script>

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
