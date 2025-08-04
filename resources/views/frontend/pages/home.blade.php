@extends('frontend.layouts.website')
@section('content')


<section>
        <div class="banner_category">
            <div class="container">
                <div class="row">
                    <div class="col-6 col-md-3">
                        <div class="side_category">
                            <ul class="list_unstyled mt-3">
                                <li><a class="d-flex" href="#">
                                        <img src="{{ asset("frontend") }}/images/food.svg.jpg" alt="" style="width: 30px; height: 30px; border-radius: 15%;">
                                        <span>Food</span>
                                    </a>
                                    <ul class="sub_category">
                                        <li><a href="#">Rice & Grains</a></li>
                                        <li><a href="#">Snacks</a></li>
                                        <li><a href="#">Cooking Essentials</a></li>
                                    </ul>
                                </li>
                                <li><a class="d-flex" href="#">
                                        <img src="{{ asset("frontend") }}/images/baby.svg" alt="" style="width: 30px; height: 30px; border-radius: 15%;">
                                        <span>Baby Care</span>
                                    </a>
                                    <ul class="sub_category">
                                        <li><a href="#">Diapers</a></li>
                                        <li><a href="#">Wipes</a></li>
                                        <li><a href="#">Diaper Rash Cream</a></li>
                                        <li><a href="#">Changing Mats</a></li>
                                        <li><a href="#">Baby Bottles</a></li>
                                        <li><a href="#">Breast Pumps</a></li>
                                        <li><a href="#">Baby Shampoo & Body Wash</a></li>
                                        <li><a href="#">Towels & Washcloths</a></li>
                                    </ul>
                                </li>
                                <li><a class="d-flex" href="#">
                                        <img src="{{ asset("frontend") }}/images/home.svg" alt="" style="width: 30px; height: 30px; border-radius: 15%;">
                                        <span>Home Cleaning</span>
                                    </a>
                                    <ul class="sub_category">
                                        <li><a href="#">Floor Cleaners</a></li>
                                        <li><a href="#">Surface Cleaners</a></li>
                                        <li><a href="#">Bathroom Cleaners</a></li>
                                        <li><a href="#">Dishwashing Liquids</a></li>
                                        <li><a href="#">Toilet Cleaners</a></li>
                                        <li><a href="#">Bathroom Sprays</a></li>
                                        <li><a href="#">Air Purifiers</a></li>
                                        <li><a href="#">Window Wipes</a></li>
                                    </ul>
                                </li>
                                <li><a class="d-flex" href="#">
                                        <img src="{{ asset("frontend") }}/images/pet.avif" alt="" style="width: 30px; height: 30px; border-radius: 15%;">
                                        <span>Pet Care</span>
                                    </a></li>
                                <li><a class="d-flex" href="#">
                                        <img src="{{ asset("frontend") }}/images/beauty.png" alt="" style="width: 30px; height: 30px; border-radius: 15%;">
                                        <span>Beauty And Health</span>
                                    </a></li>
                                <li><a class="d-flex" href="#">
                                        <img src="{{ asset("frontend") }}/images/fashion.jpg" alt="" style="width: 30px; height: 30px; border-radius: 15%;">
                                        <span>Fashion And Lifestyle</span>
                                    </a></li>
                                <li><a class="d-flex" href="#">
                                        <img src="{{ asset("frontend") }}/images/home.svg" alt="" style="width: 30px; height: 30px; border-radius: 15%;">
                                        <span>Home And Kitchen</span>
                                    </a></li>
                                <li><a class="d-flex" href="#">
                                        <img src="{{ asset("frontend") }}/images/stationery.avif" alt="" style="width: 30px; height: 30px; border-radius: 15%;">
                                        <span>Stationeries</span>
                                    </a></li>
                                <li><a class="d-flex" href="#">
                                        <img src="{{ asset("frontend") }}/images/toys.jpg" alt="" style="width: 30px; height: 30px; border-radius: 15%;">
                                        <span>Toys And Sports</span>
                                    </a>
                                    <ul class="sub_category">
                                        <li><a href="#">Playsets</a></li>
                                        <li><a href="#">Figures</a></li>
                                        <li><a href="#">Battle Toys</a></li>
                                        <li><a href="#">STEM Kits</a></li>
                                        <li><a href="#">Dolls</a></li>
                                        <li><a href="#">Sound Toys</a></li>
                                    </ul>
                                </li>
                                <li><a class="d-flex" href="#">
                                        <img src="{{ asset("frontend") }}/images/gadget.jpg" alt="" style="width: 30px; height: 30px; border-radius: 15%;">
                                        <span>Gadget</span>
                                    </a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-md-9">
                        <div class="banner_part">
                            <div class="row">
                                <div class="col-12">
                                    <div class="banner_image owl-carousel">
                                        <div class="item"><img src="{{ asset("frontend") }}/images/banner1.jpg" alt="Banner 1"></div>
                                        <div class="item"><img src="{{ asset("frontend") }}/images/banner2.jpg" alt="Banner 2"></div>
                                        <div class="item"><img src="{{ asset("frontend") }}/images/banner1.jpg" alt="Banner 3"></div>
                                        <div class="item"><img src="{{ asset("frontend") }}/images/banner2.jpg" alt="Banner 4"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="banner_cart_slider owl-carousel">

                                    <div class="banner_card">
                                        <div class="banner_card_image">
                                            <img src="{{ asset("frontend") }}/images/egg.webp" alt="">
                                        </div>
                                        <div class="card-body mt-2 mb-2" style="margin: 0px 15px;">
                                            <button class="btn btn-warning w-100">Eggs</button>
                                        </div>
                                    </div>
                                    <div class="banner_card">
                                        <div class="banner_card_image">
                                            <img src="{{ asset("frontend") }}/images/tea.jpg" alt="">
                                        </div>
                                        <div class="card-body mt-2 mb-2" style="margin: 0px 15px;">
                                            <button class="btn btn-warning w-100">Tea</button>
                                        </div>
                                    </div>
                                    <div class="banner_card">
                                        <div class="banner_card_image">
                                            <img src="{{ asset("frontend") }}/images/softdrink.webp" alt="">
                                        </div>
                                        <div class="card-body mt-2 mb-2" style="margin: 0px 15px;">
                                            <button class="btn btn-warning w-100">Softdrinks</button>
                                        </div>
                                    </div>
                                    <div class="banner_card">
                                        <div class="banner_card_image">
                                            <img src="{{ asset("frontend") }}/images/frozen.jpg" alt="">
                                        </div>
                                        <div class="card-body mt-2 mb-2" style="margin: 0px 15px;">
                                            <button class="btn btn-warning w-100">Frozeen</button>
                                        </div>
                                    </div>
                                    <div class="banner_card">
                                        <div class="banner_card_image">
                                            <img src="{{ asset("frontend") }}/images/coffie.jpg" alt="">
                                        </div>
                                        <div class="card-body mt-2 mb-2" style="margin: 0px 15px;">
                                            <button class="btn btn-warning w-100">
                                                Coffee </button>
                                        </div>
                                    </div>
                                    <div class="banner_card">
                                        <div class="banner_card_image">
                                            <img src="{{ asset("frontend") }}/images/Ice%20Cream.jpg" alt="">
                                        </div>
                                        <div class="card-body mt-2 mb-2" style="margin: 0px 15px;">
                                            <button class="btn btn-warning w-100">Ice Cream</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section>
        <div class="product_part">
            <div class="container mt-5">
                <div class="common_heading text-center">
                    <h5>Exclusive Deals</h5>
                </div>
                <div class="row">
                    <div class="product_slider owl-carousel">
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/tel.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Pusti Soybean Oil 5 Litre</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳970.00</p>
                                    <p class="new_price">৳922.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chini.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Daily Shopping Loose Sugar- 1kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chal.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Aromatic Chinigura Premium Rice 1Kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>

                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/solt.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/dim.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>




                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section>
        <div class="product_part">
            <div class="container mt-5">
                <div class="common_heading text-center">
                    <h5>Everyday Essentials</h5>
                </div>
                <div class="row">
                    <div class="product_slider owl-carousel">
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/tel.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Pusti Soybean Oil 5 Litre</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳970.00</p>
                                    <p class="new_price">৳922.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chini.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Daily Shopping Loose Sugar- 1kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chal.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Aromatic Chinigura Premium Rice 1Kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>

                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/solt.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/dim.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>




                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section>
        <div class="product_part">
            <div class="container mt-5">
                <div class="common_heading text-center">
                    <h5>Dairy & Breads</h5>
                </div>
                <div class="row">
                    <div class="product_slider owl-carousel">
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>

                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/tel.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Pusti Soybean Oil 5 Litre</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳970.00</p>
                                    <p class="new_price">৳922.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chini.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Daily Shopping Loose Sugar- 1kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chal.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Aromatic Chinigura Premium Rice 1Kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>

                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/solt.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/dim.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section>
        <div class="product_part">
            <div class="container mt-5">
                <div class="common_heading text-center">
                    <h5>Grocery Items</h5>
                </div>
                <div class="row">
                    <div class="product_slider owl-carousel">
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/tel.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Pusti Soybean Oil 5 Litre</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳970.00</p>
                                    <p class="new_price">৳922.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chini.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Daily Shopping Loose Sugar- 1kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chal.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Aromatic Chinigura Premium Rice 1Kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>

                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/solt.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/dim.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>




                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<section>
        <div class="middle_banner">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-5">
                        <div class="middle_banner_one">
                            <img src="{{ asset("frontend") }}/images/middle-banner1.jpeg" alt="">
                        </div>
                        <div class="middle_banner_one">
                            <img src="{{ asset("frontend") }}/images/middle-banner2.jpeg" alt="">
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="middle_banner_two">
                            <img src="{{ asset("frontend") }}/images/middle-banner3.jpeg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section>
        <div class="product_part">
            <div class="container mt-5">
                <div class="common_heading text-center">
                    <h5>Frozen Snacks</h5>
                </div>
                <div class="row">
                    <div class="product_slider owl-carousel">
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/tel.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Pusti Soybean Oil 5 Litre</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳970.00</p>
                                    <p class="new_price">৳922.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chini.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Daily Shopping Loose Sugar- 1kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chal.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Aromatic Chinigura Premium Rice 1Kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>

                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/solt.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/dim.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>




                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section>
        <div class="product_part">
            <div class="container mt-5">
                <div class="common_heading text-center">
                    <h5>Sip & Crunch Showcase</h5>
                </div>
                <div class="row">
                    <div class="product_slider owl-carousel">
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/tel.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Pusti Soybean Oil 5 Litre</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳970.00</p>
                                    <p class="new_price">৳922.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chini.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Daily Shopping Loose Sugar- 1kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chal.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Aromatic Chinigura Premium Rice 1Kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>

                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/solt.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/dim.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>




                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section>
        <div class="product_part">
            <div class="container mt-5">
                <div class="common_heading text-center">
                    <h5>Hygiene & Home Safety Picks</h5>
                </div>
                <div class="row">
                    <div class="product_slider owl-carousel">
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/tel.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Pusti Soybean Oil 5 Litre</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳970.00</p>
                                    <p class="new_price">৳922.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chini.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>Daily Shopping Loose Sugar- 1kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/chal.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Aromatic Chinigura Premium Rice 1Kg</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>

                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/solt.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/dim.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>




                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("frontend") }}/images/product/alu.png" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                <div class="product_offer">
                                    <p>save <span>10%</span> </p>
                                </div>
                            </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>5000000023</span></p>
                                </div>
                                <div class="product_name">
                                    <p>PRAN Haleem Mix- 200gm</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                            <div class="product_prices  d-flex justify-content-between align-items-center">
                                <div class="product_price">
                                    <p class="old_price">৳70.00</p>
                                    <p class="new_price">৳60.00</p>
                                </div>
                                <button class="cart_btn">
                                    <i class="bi bi-cart"></i>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container my-5">
            <div class="row g-4">

                <!-- Stay Connected -->
                <div class="col-md-6">
                    <div class="bg-light p-4 text-center h-100 rounded">
                        <h5 class="fw-semibold">Stay Connected</h5>
                        <small class="text-muted">Exclusive offers</small>
                        <p class="text-muted mb-3">Subscribe to our news and get updated about exclusive offers!</p>
                        <form class="d-flex flex-column flex-sm-row justify-content-center align-items-stretch gap-2">
                            <input type="email" class="form-control" placeholder="E-mail">
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>

                <!-- Get Social -->
                <div class="col-md-6">
                    <div class="bg-light p-4 text-center h-100 rounded">
                        <h5 class="fw-semibold">Get social</h5>
                        <p class="text-muted mb-1">Join us in the group</p>
                        <p class="text-muted">and be the first to know all promotions and offers!</p>
                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                            <a href="#" class="social-icon"><i class="bi bi-whatsapp"></i></a>
                            <a href="#" class="social-icon"><i class="bi bi-tiktok"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>


@endsection
