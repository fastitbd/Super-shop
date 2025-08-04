<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fast Super Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset("frontend") }}/css/all.min.css">
    <link rel="stylesheet" href="{{ asset("frontend") }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset("frontend") }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset("frontend") }}/css/style.css">
</head>

<body>
    <header>
        <div class="header_part d-none d-md-block" style="padding: 5px 0px; background-color: #DEB887;">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="logu_lg">
                            <a class="" href="#">
                                <img src="{{ asset("frontend") }}/images/logu.png" alt="" style="width: 100%; height: 100%;">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="header_content mt-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="mobile_search">
                                            <form class="d-flex search_bars" role="search">
                                                <input class="form_controls" type="search" placeholder="Search" aria-label="Search" />
                                                <button class="btn" type="submit">Search</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="header_icon d-flex text-end justify-content-end">
                                            <div class="h_icons">
                                                <ul class="d-flex">
                                                    <li><a href="#"><i class="fa-solid fa-heart-circle-plus"></i></a></li>
                                                    <li><a href="#"><i class="fa-solid fa-cart-shopping"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="h_login">
                                                <a href="#">Login</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="nav_mobile d-block d-md-none" style="background: #DEB887;">
            <div class="container-sm">
                <div class="row">
                    <div class="col-4">
                        <div class="logo" style="width: 150px; height: 50px;">
                            <img src="{{ asset("frontend") }}/images/logu.png" alt="" style="width: 100%; height: 100%;">
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="head_mobile_right">
                            <div class="header_icon_mobile d-flex text-end justify-content-end">
                                <div class="h_icons_mobile">
                                    <ul class="d-flex">
                                        <li><a href="#"><i class="fa-solid fa-heart-circle-plus"></i></a></li>
                                        <li><a href="#"><i class="fa-solid fa-cart-shopping"></i></a></li>
                                        <li><a href="#"><i class="fa-regular fa-circle-user"></i><span>Login</span></a></li>

                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <div class="col-4 d-flex align-items-center">
                            <!-- Sidebar Toggle Button (hamburger icon) -->
                            <button class="btn text-white d-md-none me-2" id="toggleSidebar" style="font-size: 24px;">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                        </div>

                    </div>
                    <div class="col-10">
                        <div class="mobile_search mt-2 mb-2">
                            <form class="d-flex search_bar" role="search">
                                <input class="form_control" type="search" placeholder="Search" aria-label="Search" />
                                <button class="btn" type="submit" style="background: #242C8E;">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

     @yield('content')
    <footer>
        <div class="footer_part">
            <footer class="bg-light pt-5">
                <div class="container pb-3">
                    <div class="row text-center text-md-start">

                        <!-- Logo & Contact -->
                        <div class="col-md-3 mb-4">
                            <img src="{{ asset("frontend") }}/images/logu.png" alt="Logo" class="mb-2" style="max-width: 100px;">
                            <h6 class="fw-bold">Always Here for You</h6>
                            <p class="mb-1 small">Call Us: 16469 (9am–9pm, Everyday)</p>
                            <p class="mb-1 small">Email: info.fastit@gmail.com</p>
                            <p class="small">FASTIT E-COMMERCE LIMITED</p>
                        </div>

                        <!-- Information -->
                        <div class="col-6 col-md-2 mb-4">
                            <h6 class="fw-bold">Information</h6>
                            <ul class="list-unstyled small">
                                <li><a href="#" class="text-decoration-none text-dark">Office Address</a></li>
                                <li><a href="#" class="text-decoration-none text-dark">Shipping & returns</a></li>
                                <li><a href="#" class="text-decoration-none text-dark">About us</a></li>
                                <li><a href="#" class="text-decoration-none text-dark">Terms & Condition</a></li>
                            </ul>
                        </div>

                        <!-- Customer Service -->
                        <div class="col-6 col-md-2 mb-4">
                            <h6 class="fw-bold">Customer Service</h6>
                            <ul class="list-unstyled small">
                                <li><a href="#" class="text-decoration-none text-dark">Contact Us</a></li>
                            </ul>
                        </div>

                        <!-- My Account -->
                        <div class="col-6 col-md-2 mb-4">
                            <h6 class="fw-bold">My Account</h6>
                            <!-- Add more items if needed -->
                        </div>

                        <!-- Payment & Social -->
                        <div class="col-md-3 mb-4 text-md-end text-center">
                            <h6 class="fw-bold">Pay With</h6>
                            <div class="d-flex justify-content-center justify-content-md-end flex-wrap gap-2 mb-3">
                                <img src="{{ asset("frontend") }}/images/visa.png" alt="Visa" style="height: 24px;">
                                <img src="{{ asset("frontend") }}/images/mastercard.png" alt="Mastercard" style="height: 24px;">
                                <img src="{{ asset("frontend") }}/images/bkash.jpg" alt="bKash" style="height: 24px;">
                                <!-- Add more payment icons -->
                            </div>
                            <h6 class="fw-bold">Follow Us</h6>
                            <div class="d-flex justify-content-center justify-content-md-end gap-2">
                                <a href="#"><i class="bi bi-facebook fs-4 text-primary"></i></a>
                                <a href="#"><i class="bi bi-youtube fs-4 text-danger"></i></a>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Copyright -->
                <div class="bg-white text-center py-3 border-top">
                    <small>Copyright © FastIt 2025</small>
                </div>
            </footer>

        </div>
    </footer>

    <script>
        const toggleButton = document.getElementById('toggleSidebar');
        const sidebar = document.querySelector('.side_category');

        toggleButton.addEventListener('click', function() {
            sidebar.classList.toggle('show-sidebar');
        });

    </script>



    <script src="{{ asset("frontend") }}/js/jquery-3.7.1.min.js"></script>
    <script src="{{ asset("frontend") }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset("frontend") }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset("frontend") }}/js/custom.js"></script>
</body>
