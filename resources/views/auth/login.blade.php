<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="My Software">
    <meta name="keywords" content="admin, software">
    <meta name="author" content="Atrytech Information Technology">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ get_setting('com_name') }} | Log in</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="{{ (!empty(get_setting('system_icon')))?url('public/uploads/logo/'.get_setting('system_icon')):url('backend/images/no_images.png') }}">
    <!-- Start css -->

    <!-- Slick css -->
    <link href="{{ asset('backend') }}/plugins/slick/slick.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/plugins/slick/slick-theme.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/plugins/select2/select2.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/css/bootstrap-fileupload.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/css/icons.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/css/flag-icon.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/css/style.css" rel="stylesheet" type="text/css">
    <!-- Summernote css -->
</head>

<body class="vertical-layout">
    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-bg">
        <!-- Start Container -->
        <div class="container">
            <div class="auth-box login-box">
                <!-- Start row -->
                <div class="row no-gutters align-items-center justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-6 col-lg-5">
                        <!-- Start Auth Box -->
                        <div class="auth-box-right">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="form-head">
                                            <a href="index.html" class="logo">
                                                <img class="img-fluid" src="{{ (!empty(get_setting('system_logo')))?url('public/public/uploads/logo/'.get_setting('system_logo')):url('backend/images/fastLogo.jpeg') }}" alt="{{ (empty(get_setting('com_name'))?'----':get_setting('com_name')) }}">
                                            </a>
                                        </div>
                                        <h4 class="text-primary my-4">Log in !</h4>
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email" autofocus placeholder="Enter Email here" value="{{ env('APP_MODE') == 'demo'?"admin@fastit.com":"" }}" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password here" value="{{ env('APP_MODE') == 'demo'?"12345678":"" }}" required>
                                        </div>
                                        <button type="submit" class="btn save_btn btn-lg btn-block font-18" autoFocus>Log in</button>
                                    </form>
                                    @if (env('APP_MODE')=='demo')
                                    <div class="login-or">
                                        <h6 class="text-muted">OR</h6>
                                    </div>
                                    <p class="mb-0 mt-3 text-center" style="font-size: 25px; font-weight: bold; font-family: cursive;">CALL FOR ORDER</p>
                                    <p class="mb-0 mt-3 text-center"><span style="font-size: 20px; font-weight: bold; font-family: cursive;">01784-159071</span</p>
                                    @endif
                                    </div>
                            </div>
                        </div>
                        <!-- End Auth Box -->
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Containerbar -->

    <!-- Start js -->
    <script src="{{ asset('backend') }}/js/popper.min.js"></script>
    <script src="{{ asset('backend') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('backend') }}/js/modernizr.min.js"></script>
    <script src="{{ asset('backend') }}/js/detect.js"></script>
    <script src="{{ asset('backend') }}/js/jquery.slimscroll.js"></script>
    <!-- Slick js -->
</body>

</html>
