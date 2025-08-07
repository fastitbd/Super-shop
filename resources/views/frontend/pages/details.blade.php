@extends('frontend.layouts.website')
@section('content')

    <section>
        <div class="product_details">
            <div class="container my-4">
                <div class="row">
                    <!-- Product Title -->
                    <div class="col-12 mb-3">
                        <h4>{{ $product->name }}</h4>
                    </div>


                    <div class="col-md-6 col-12 mb-3 text-center">
                        <img src="{{ asset("uploads/products/" . $product->images) }}" class="img-fluid" alt="Shero Biscuit">
                    </div>

                    <!-- Right: Product Details -->
                    <div class="col-md-6 col-12">
                        <div class="Product_right border p-3 rounded shadow-sm">
                            <div class="Product_right_top mb-2 d-flex align-items-center justify-content-between">
                                <div class="Product_right_top_review d-flex">
                                    <div class="star">
                                        <ul class="d-flex">
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                        </ul>
                                    </div>
                                    <a href="#">Write a review</a>
                                </div>
                                <div>
                                    <small>CODE: <strong>{{ $product->barcode }}</strong></small>
                                </div>
                            </div>
                            <h4 class="details_price">৳{{ $product->selling_price }} <span>Per Piece</span></h4>
                            <p class="text-success"><i class="bi bi-check-circle"></i> In stock</p>

                            <!-- Quantity and Cart -->
                            <div class="d-flex align-items-center mb-3 mt-4">
                                <div class="input-group me-2" style="width: 120px;">
                                    <button class="btn btn-outline-secondary" type="button">-</button>
                                    <input type="text" class="form-control text-center" value="1">
                                    <button class="btn btn-outline-secondary" type="button">+</button>
                                </div>

                            </div>

                            <!-- Add to Cart -->
                            <button class="btn btn-primary w-100 mb-3">
                                <i class="bi bi-cart-plus"></i> Add to cart
                            </button>

                            <!-- Wishlist & Compare -->
                            <div class="d-flex justify-content-between mb-3">
                                <a href="#"><i class="bi bi-heart"></i> Add to wish list</a>
                                <a href="#"><i class="bi bi-bar-chart"></i> Compare</a>
                            </div>

                            <!-- Shipping Info -->
                            <div>
                                <p><i class="bi bi-geo-alt"></i> Shipping time and rates: <strong>Dhaka</strong></p>
                                <p><i class="bi bi-truck"></i> Shipping: about within 90 minutes, from <strong>৳49.00</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section>
        <div class="details_discription">
            <div class="container ">
               <div class="details_discription_item my-4">
                   
         
                <!-- Tabs Nav -->
                <ul class="nav nav-tabs" id="productTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Reviews</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq" type="button" role="tab">FAQ</button>
                    </li>
                </ul>

                <!-- Tabs Content -->
                <div class="tab-content p-3 border border-top-0" id="productTabContent">
                    <!-- Description -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <p><strong>{{ $product->name }}</p>
                        <p><strong>Item code:</strong> {{ $product->barcode }}</p>
                        <p><strong>Brand:</strong> Bisk Club</p>
                        <p><strong>Net weight:</strong> 40gm</p>
                        <p><strong>Product type:</strong> Biscuit</p>

                        <p class="text-warning mt-4 mb-1 fw-bold">Return/cancellation:</p>
                        <p class="text-warning">
                            No change will be applicable which are already delivered to customer. If product quality or quantity problem found then customer can return/cancel their order on delivery time with presence of delivery person.
                        </p>

                        <p class="text-warning mt-3 fw-bold">Note:</p>
                        <p class="text-warning">Product delivery duration may vary due to product availability in stock.</p>
                    </div>

                    <!-- Reviews -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <p>No reviews yet.</p>
                    </div>

                    
                    <div class="tab-pane fade" id="faq" role="tabpanel">
                        <p>Frequently Asked Questions will be listed here.</p>
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
                    <h5>Possibly you may be interested</h5>
                </div>
                <div class="row">
                    <div class="product_slider owl-carousel">
                        <div class="product_card">
                            <div class="product_image">
                                <img src="images/product/alu.png" alt="Product">
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
                                <img src="images/product/tel.png" alt="Product">
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
                                <img src="images/product/chini.png" alt="Product">
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
                                <img src="images/product/chal.png" alt="Product">
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
                                <img src="images/product/solt.png" alt="Product">
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
                                <img src="images/product/dim.png" alt="Product">
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
                                <img src="images/product/alu.png" alt="Product">
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
                                <img src="images/product/alu.png" alt="Product">
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
                                <img src="images/product/alu.png" alt="Product">
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
                                <img src="images/product/alu.png" alt="Product">
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
                                <img src="images/product/alu.png" alt="Product">
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
@endsection