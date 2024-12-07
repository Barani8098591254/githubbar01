<footer class="footer-area">
    <div class="footer-widget">
        <div class="container">
            <div class="row footer-widget-wrapper pt-60 pb-50">
                <div class="col-md-6 col-lg-4">
                    <div class="footer-widget-box about-us">
                        <a href="{{ URL::to('/') }}" class="footer-logo">
                            <img src="{{ URL::to('/') }}/public/assets/user/img/logo/footer-logo-biovus.webp" alt="">
                        </a>
                        <p class="mb-20">
                            We are many variations of passages available but the majority
                            in some form by injected humour.
                        </p>
                        <div class="footer-contact">
                            <ul>
                                <li><i class="far fa-map-marker-alt"></i>{{ setting()->contactaddress }}</li>
                                <li><a href="void:javascript(0)"><i
                                            class="far fa-phone"></i>91+{{ setting()->contactnumber }}</a></li>
                                <li><a href="void:javascript(0)"><i class="far fa-envelope"></i><span
                                            class="__cf_email__">{{ setting()->contactmail }}</span></a> </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Quick Links</h4>
                        <ul class="footer-list">
                            <li><a href="{{ URL::to('aboutus') }}"><i class="fas fa-caret-right"></i> About Us</a></li>
                            <li><a href="{{ URL::to('investPlan') }}"><i class="fas fa-caret-right"></i> Plan</a></li>
                            <li><a href="{{ URL::to('affiliates') }}"><i class="fas fa-caret-right"></i> Affiliate</a></li>
                            <li><a href="{{ URL::to('contactus') }}"><i class="fas fa-caret-right"></i> Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">Investment Plan</h4>

                        <ul class="footer-list">
                            <li><a href="{{ URL::to('termsofservice') }}"><i class="fas fa-caret-right"></i> Terms Of
                                    Service</a></li>
                            <li><a href="{{ URL::to('privacyPolicy') }}"><i class="fas fa-caret-right"></i> Privacy
                                    policy</a></li>
                            <li><a href="{{ URL::to('refundPolicy') }}"><i class="fas fa-caret-right"></i> Refund
                                    Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="footer-widget-box list">
                        <h4 class="footer-widget-title">social media</h4>
                        <ul class="footer-social">
                            <li><a href="{{ setting()->fblink }}"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="{{ setting()->instainlink }}"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="{{ setting()->twitterlink }}"><img class="twitter-x"
                                        src="{{ URL::to('/') }}/public/assets/user/img/logo/twitter-x-icon.png"></a>
                            </li>
                            <li><a href="{{ setting()->telegramlink }}"><i class="fab fa-telegram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="copyright-text">
                        {{ setting()->copyright }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>


<a href="#" id="scroll-top"><i class="far fa-long-arrow-up"></i></a>



<script src="{{ URL::to('/') }}/public/assets/user/js/jquery-3.6.0.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/user/js/modernizr.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/user/js/bootstrap.bundle.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/user/js/imagesloaded.pkgd.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/user/js/jquery.magnific-popup.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/user/js/isotope.pkgd.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/user/js/jquery.appear.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/user/js/jquery.easing.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/user/js/owl.carousel.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/user/js/counter-up.js"></script>
<script src="{{ URL::to('/') }}/public/assets/user/js/jquery.nice-select.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/user/js/wow.min.js"></script>
<script src="{{ URL::to('/') }}/public/assets/user/js/main.js"></script>


<script>
    var base_url = "{{ url('/') }}/";
</script>
<script type="text/javascript">
    var base_urls = "<?php echo URL::to('/'); ?>";
</script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>


<script src="{{ URL::to('/') }}/public/assets/user/bower_components/datatables/media/js/jquery.dataTables.min.js">
</script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<?php if($js_file != ''){ ?>
<script src="{{ URL::to('/') }}/public/assets/user/customs_js/<?php echo $js_file ? $js_file : ''; ?>.js?<?php echo time(); ?>"></script>
<?php } ?>





<script type="text/javascript">
    @if (session('success'))
        toastr.success('{{ session('success') }}', 'Success', {
            timeOut: 2000
        });
    @endif

    @if (session('error'))
        toastr.error('{{ session('error') }}', {
            timeOut: 2000
        });
    @endif

    @if (session('primary'))
        toastr.primary('{{ session('primary') }}', {
            timeOut: 2000
        });
    @endif

    @if (session('message'))
        toastr.message('{{ session('message') }}', {
            timeOut: 2000
        });
    @endif

    @if (session('info'))
        toastr.info('{{ session('info') }}', {
            timeOut: 2000
        });
    @endif


    @if (!empty($errors->all()))
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}")
        @endforeach
    @endif
</script>

<script type="text/javascript">
    $("#profilePic").click(function() {
        $("#profilePicture").trigger('click');
    });

    $(document).on('change', '.profilePicture', function() {
        $('#profilePic')[0].src = (window.URL ? URL : webkitURL).createObjectURL(this.files[0]);
        var name = document.getElementById("profilePicture").files[0].name;
        var form_data = new FormData();

        form_data.append("file", document.getElementById('profilePicture').files[0]);

        $.ajax({
            url: base_url + "profile_pic",
            method: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                // $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
            },
            success: function(data) {

                var res = JSON.parse(data);

                if (res.status == 1) {
                    toastr.success(res.msg, 'Success', {
                        timeOut: 2000
                    });
                } else {
                    toastr.error(res.msg, {
                        timeOut: 2000
                    });

                }

            }
        });


    });
</script>

</body>

</html>
