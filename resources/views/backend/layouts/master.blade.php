<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="My Software">
    <meta name="keywords" content="admin, software">
    <meta name="author" content="Atrytech Information Technology">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ get_setting('com_name') }} | @yield('page-title')</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="{{ (!empty(get_setting('system_icon')))?url('public/public/uploads/logo/'.get_setting('system_icon')):url('backend/images/no_images.png') }}">
    <!-- Start css -->

    <!-- Slick css -->
    <link href="{{ asset('backend') }}/plugins/slick/slick.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend') }}/css/all.min.css">
    <link href="{{ asset('backend') }}/plugins/slick/slick-theme.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/plugins/select2/select2.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/css/bootstrap-fileupload.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/css/icons.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/css/flag-icon.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/css/style.css" rel="stylesheet" type="text/css">
    <!-- Summernote css -->
    <link href="{{ asset('backend') }}/plugins/summernote/summernote-bs4.css" rel="stylesheet">
    <!-- iziToast css -->
    <link href="{{ asset('backend') }}/plugins/iziToast/css/iziToast.css" rel="stylesheet">
    <!-- toggle css -->
    <link href="{{ asset('backend') }}/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
    <!-- End css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <!-- Start script -->
    <link href="{{ asset('backend') }}/css/jquery-ui.css" rel="stylesheet" type="text/css">
    <script src="{{ asset('backend') }}/js/jquery.min.js"></script>
    <script src="{{ asset('backend') }}/js/jquery-ui.js"></script>
    <!-- End script -->
    @stack('css')
</head>

<body class="vertical-layout">
    <div id="containerbar" class="main-container">
        @php
            $route = Route::currentRouteName();
        @endphp
        @include('backend.layouts.includes.sidebar')
        <div class="rightbar">
            @include('backend.layouts.includes.header')
            @if ($route == 'invoice.create' ||$route == 'purchase.imei-print' || $route == 'due.invoice.print' || $route == 'used.create' || $route == 'return.create' || $route == 'damage.create' || $route == 'invoice.exchange' || $route == 'inv.edit' || $route == 'invoice.print' || $route == 'purchase.print')
                @yield('invoice')
            @else
                @if ($route != 'dashboard')
                    @include('backend.layouts.includes.breadcrumb')
                @endif
                <div class="contentbar">
                    @yield('content')
                </div>
            @endif
            @include('backend.layouts.includes.footer')
        </div>
    </div>
    <!-- Start js -->
    <script src="{{ asset('backend') }}/js/popper.min.js"></script>
    <script src="{{ asset('backend') }}/js/custom.js"></script>
    <script src="{{ asset('backend') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('backend') }}/js/modernizr.min.js"></script>
    <script src="{{ asset('backend') }}/js/detect.js"></script>
    <script src="{{ asset('backend') }}/js/jquery.slimscroll.js"></script>
    <script src="{{ asset('backend') }}/js/vertical-menu.js"></script>
    <!-- Slick js -->
    <script src="{{ asset('backend') }}/plugins/slick/slick.min.js"></script>

    <!-- Select2 js -->
    <script src="{{ asset('backend') }}/plugins/select2/select2.min.js"></script>

    <!--select2-->
    <script>
        jQuery(document).ready(function() {
            // Select2
            jQuery(".select2").select2({
                width: '100%'
            });
        });
    </script>

    <!-- Summernote js -->
    <script src="{{ asset('backend') }}/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Core js -->
    <script src="{{ asset('backend') }}/js/core.js"></script>
    <script src="{{ asset('backend') }}/js/bootstrap-fileupload.js"></script>
    <script src="{{ asset('backend') }}/js/status-update.js"></script>
    <!-- toggle js -->
    <script src="{{ asset('backend') }}/js/bootstrap-toggle.min.js"></script>
    <!-- iziToast js -->
    <script src="{{ asset('backend') }}/plugins/iziToast/js/iziToast.js"></script>
    @include('vendor.lara-izitoast.toast')
    <!-- End js -->
    @stack('js')
</body>

</html>
