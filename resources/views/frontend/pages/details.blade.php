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
                        <img style="width:40%;" src="{{ asset("uploads/products/" . $product->images) }}" class="img-fluid mt-3" alt="Shero Biscuit">
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
                            <h4 style="font-size:17px; font-weight: 600;">{{ $product->name }}</h4>
                            <h5 style="font-size:15px; font-weight: 500;">{{ $product->category->name }}</h5>
                            <h4 class="details_price">৳{{ $product->selling_price }} <span>{{ $product->unit->name }}</span></h4>

                            
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
                        @foreach ($featureproduct as $product)
                            <div class="product_card">
                                  <div class="product_image">
                                           <a href="{{ url('/product/details/' . $product->slug) }}">
                                            <img src="{{ asset("uploads/products/" . $product->images) }}" alt="Product">
                                            <div class="product_image_overly">
                                                <i class="fa-solid fa-heart-circle-plus"></i>
                                            </div>
                                            @if(!empty($product->discount) && $product->discount > 0)
                                                <div class="product_offer">
                                                    <p>save <span>{{ $product->discount }}%</span></p>
                                                </div>
                                            @endif
                                            </a>
                                        </div>
                            <div class="product_body">
                                <div class="product_code">
                                    <p>CODE: <span>{{$product->barcode}}</span></p>
                                </div>
                                <div class="product_name">
                                    <a href="{{ url('/product/details/' . $product->slug) }}">
                                        <p>{{$product->name}}</p>
                                    </a>
                                    
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
                                </div>
                            </div>
                             <div class="product_prices d-flex justify-content-between align-items-center">
                                            @if (!empty($product->discount) && $product->discount > 0)
                                                <div class="product_price">
                                                    <p class="old_price">৳{{ $product->after_discount_price }}</p> {{-- What customer pays --}}
                                                    <p class="new_price">৳{{ $product->selling_price }}</p> {{-- Original price --}}
                                                </div>
                                            @else
                                                <div class="product_price">
                                                    <p class="new_price">৳{{ $product->selling_price }}</p>
                                                </div>
                                            @endif

                                            <button class="cart_btn">
                                                <i class="bi bi-cart"></i>
                                            </button>
                                        </div>

                        </div>
                        @endforeach
  
                    </div>
                </div>
            </div>
        </div>
    </section> 
@endsection