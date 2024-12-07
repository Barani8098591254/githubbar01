@include('user.common.header')



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


    <div class="contact-area pt-60 pb-60">
        <div class="container">
            <div class="contact-wrapper">
                <div class="row">
                    <div class="col-md-8 align-self-center">
                        <div class="contact-form">
                            <div class="contact-form-header">
                                <h2>Get In Touch</h2>
                                <p>It is a long established fact that a reader will be distracted by the readable
                                    content of a page when looking at its layout. </p>
                            </div>
                            <form class="contact__form form" id="contact-form" name="contact-form"
                                action="{{ url('contactmail') }}" method="post" enctype="multipart/form-data"
                                autocomplete="off">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Enter Your Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Enter Your Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="subject" id="subject"
                                        placeholder="Enter Your Subject">
                                </div>
                                <div class="form-group">
                                    <textarea name="message" id="message" cols="30" rows="5" class="form-control"
                                        placeholder="Write Your Message"></textarea>
                                </div>

                                <button type="submit" name="contact_btn" id="contact_btn" class="theme-btn contact_btn">Send Message <i
                                        class="far fa-paper-plane"></i></button>
                                <button type="button" name="loader" id="loader" class="theme-btn mt-4 loaders"
                                    style="display: none;">Loading ...</button>

                                <div class="col-md-12 mt-3">
                                    <div class="form-messege text-success"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-content">
                            <div class="contact-info">
                                <div class="contact-info-icon">
                                    <i class="fal fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-info-content">
                                    <h5>Office Address</h5>
                                    <p>{{ setting()->contactaddress }}</p>
                                </div>
                            </div>
                            <div class="contact-info">
                                <div class="contact-info-icon">
                                    <i class="fal fa-phone"></i>
                                </div>
                                <div class="contact-info-content">
                                    <h5>Call Us</h5>
                                    <p>91+{{ setting()->contactnumber }}</p>
                                </div>
                            </div>
                            <div class="contact-info">
                                <div class="contact-info-icon">
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="contact-info-content">
                                    <h5>Email Us</h5>
                                    <p><a href="" class="__cf_email__ support"
                                            data-cfemail="d0b9beb6bf90b5a8b1bda0bcb5feb3bfbd">{{ setting()->contactmail }}</a></p>
                                </div>
                            </div>
                            <div class="contact-info">
                                <div class="contact-info-icon">
                                    <i class="fal fa-clock"></i>
                                </div>
                                <div class="contact-info-content">
                                    <h5>Office Open</h5>
                                    <p>Sun - Fri (08AM - 10PM)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d96708.34194156103!2d-74.03927096447748!3d40.759040329405195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4a01c8df6fb3cb8!2sSolomon%20R.%20Guggenheim%20Museum!5e0!3m2!1sen!2sbd!4v1619410634508!5m2!1sen!2s"
                    style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>

</main>

@include('user.common.footer')
