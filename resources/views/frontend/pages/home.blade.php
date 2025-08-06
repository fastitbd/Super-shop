@extends('frontend.layouts.website')
@section('content')


<section>
        <div class="banner_category">
            <div class="container">
                <div class="row">
<div class="col-6 col-md-3">
    <div class="side_category">
        <ul class="list_unstyled mt-3">
            @php
    use App\Models\Category;
        $categories = Category::with('subcategories')->where('status',1)->get();
    @endphp
            @foreach($categories as $category)
                <li>
                    <a class="d-flex" href="#">
                        <img src="{{ asset('uploads/category/' . $category->images) }}" 
                             alt="{{ $category->name }}" 
                             style="width: 30px; height: 30px; border-radius: 15%;">
                        <span>{{ $category->name }}</span>
                    </a>
                    
                    @if($category->subcategories->count() > 0)
                        <ul class="sub_category">
                            @foreach($category->subcategories as $sub)
                                <li><a href="#">{{ $sub->name }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>


                    <div class="col-12 col-md-9">
                        <div class="banner_part">
                            <div class="row">
                                <div class="col-12">
                                    @php
                                      $allbanner = App\Models\Banner::orderBy('id', 'ASC')->get();
                                    @endphp
                                    <div class="banner_image owl-carousel">
                                        @foreach ($allbanner as $banner)
                                         <div class="item"><img src="{{ asset('uploads/banner/' . $banner->images) }}" alt="Banner 1"></div>
                                        @endforeach
                                       
                                    
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-3">
                                 @php
                                      $allcategory = App\Models\Category::orderBy('id', 'ASC')->get();
                                    @endphp 
                                <div class="banner_cart_slider owl-carousel">
                                    @foreach ($allcategory as $category )
                                    <div class="banner_card">
                                        <div class="banner_card_image">
                                            <img src="{{ asset('uploads/category/' . $category->images) }}" alt="">
                                        </div>
                                        <div class="card-body mt-2 mb-2" style="margin: 0px 15px;">
                                            <button class="btn btn-warning w-100">{{ $category->name }}</button>
                                        </div>
                                    </div>
                                    @endforeach
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
                @php
                $categories = App\Models\Category::where('status',1)->orderBy('id', 'ASC')->get();
                @endphp

                @foreach ($categories as $categori)
                  @php
                  $all_product=App\Models\Product::where('status',1)->where('category_id',$categori->id)->orderBy('id','asc')->get();
                  @endphp
                @if ($all_product->count() > 0)
                <div class="common_heading text-center">
                    <h5>{{ $categori->name }}</h5>
                </div>
                <div class="row">
                    <div class="product_slider owl-carousel">
                      @foreach ($all_product as $product)
                        <div class="product_card">
                            <div class="product_image">
                                <img src="{{ asset("uploads/products/" . $product->images) }}" alt="Product">
                                <div class="product_image_overly">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                </div>
                                  @if(!empty($product->discount) && $product->discount > 0)
                                    <div class="product_offer">
                                        <p>save <span>{{ $product->discount }}%</span></p>
                                    </div>
                                @endif
                            </div>
                            <div class="product_body mt-1">
                                <div class="product_code">
                                    <p>CODE: <span>{{$product->barcode}}</span></p>
                                </div>
                                <div class="product_name">
                                    <p>{{$product->name}}</p>
                                </div>
                                <div class="product_stock">
                                    <p class="text-success small mb-2"><i class="bi bi-check-circle"></i> In stock</p>
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
                        @endforeach



                   
                    </div>
                </div>
                @endif
                @endforeach
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
