@extends('frontend.layouts.website')
@section('content')

    <section>
        <div class="breadcrumb_part">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb mt-2">
                            <p>Category/ <span>{{ $cate->name }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Category Content -->
    <section class="py-2">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center justify-content-center mb-2">
                    <div class="category_shorts d-flex text-center ">
                        <h5>Sub Category:</h5>
                        <ul class="d-flex">
                            @foreach ($subcategories as $subcategory)
                                <li><a href="#">{{ $subcategory->name }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class=" col-md-3">
                    <div class="filter_sidebar">
                        <div class="card mb-3 p-3">
                            <h6 class="mb-3">PRICE RANGE</h6>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Min:৳<span id="minPrice">50</span></span>
                                <span>Max:৳<span id="maxPrice">1502</span></span>
                            </div>
                            <input type="range" class="form-range range-red" min="50" max="1502" id="priceRange" step="10">
                            <div class="d-flex justify-content-between">
                                <span>50</span>
                                <span>1502</span>
                            </div>
                        </div>

                        <!-- Delivery Time -->
                        <div class="card mb-3 p-3">
                            <h6 class="mb-3 d-flex justify-content-between align-items-center">
                                DELIVERY TIME
                                <span class="text-muted">–</span>
                            </h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="dt1">
                                <label class="form-check-label d-flex justify-content-between w-100" for="dt1">
                                    <span>1-2 hours</span><span class="text-muted">(68)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Express Delivery -->
                        <div class="card mb-3 p-3">
                            <h6 class="mb-3 d-flex justify-content-between align-items-center">
                                EXPRESS DELIVERY
                                <span class="text-muted">–</span>
                            </h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="ex1">
                                <label class="form-check-label d-flex justify-content-between w-100" for="ex1">
                                    <span>Yes</span><span class="text-muted">(0)</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="ex2">
                                <label class="form-check-label d-flex justify-content-between w-100" for="ex2">
                                    <span>No</span><span class="text-muted">(68)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Free Shipping -->
                        <div class="card mb-3 p-3">
                            <h6 class="mb-3 d-flex justify-content-between align-items-center">
                                FREE SHIPPING
                                <span class="text-muted">–</span>
                            </h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="fs1">
                                <label class="form-check-label d-flex justify-content-between w-100" for="fs1">
                                    <span>Yes</span><span class="text-muted">(0)</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="fs2">
                                <label class="form-check-label d-flex justify-content-between w-100" for="fs2">
                                    <span>No</span><span class="text-muted">(68)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="card mb-3 p-3">
                            <h6 class="mb-3 d-flex justify-content-between align-items-center">
                                TAG
                                <span class="text-muted">–</span>
                            </h6>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" id="tag1">
                                <label class="form-check-label d-flex justify-content-between w-100" for="tag1">
                                    <span>Baby Bath Essentials</span><span class="text-muted">(29)</span>
                                </label>
                            </div>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" id="tag2">
                                <label class="form-check-label d-flex justify-content-between w-100" for="tag2">
                                    <span>Infant Bath Products</span><span class="text-muted">(29)</span>
                                </label>
                            </div>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" id="tag3">
                                <label class="form-check-label d-flex justify-content-between w-100" for="tag3">
                                    <span>Baby Hygiene</span><span class="text-muted">(29)</span>
                                </label>
                            </div>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" id="tag4">
                                <label class="form-check-label d-flex justify-content-between w-100" for="tag4">
                                    <span>Baby Skin Care</span><span class="text-muted">(29)</span>
                                </label>
                            </div>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" id="tag5">
                                <label class="form-check-label d-flex justify-content-between w-100" for="tag5">
                                    <span>Baby Bath & Skincare</span><span class="text-muted">(29)</span>
                                </label>
                            </div>
                            <a href="#" class="text-danger small mt-2 d-inline-block">+ See More</a>
                        </div>
                    </div>

                </div>
                <div class="col-md-9">
                    <div class="category_shorts d-flex">
                        <h5>Sort by:</h5>
                        <ul class="d-flex">
                            <li class="active"><a href="#">Default</a></li>
                            <li><a href="#">Best sale</a></li>
                            <li><a href="#">Price asc</a></li>
                            <li><a href="#">Price desc</a></li>
                            <li><a href="#">Newest</a></li>
                        </ul>
                    </div>
                    <div class="category_product">
                        <div class="row">
                            @foreach ($all as $product)


                                <div class="col-6 col-md-4 col-lg-3 mt-3">
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
                                                <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock
                                                </p>
                                            </div>
                                        </div>
                                        <div class="product_prices  d-flex justify-content-between align-items-center">
                                            <div class="product_price">
                                                <p class="old_price">৳70.00</p>
                                                <p class="new_price">৳{{$product->selling_price}}</p>
                                            </div>
                                            <button class="cart_btn">
                                                <i class="bi bi-cart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection