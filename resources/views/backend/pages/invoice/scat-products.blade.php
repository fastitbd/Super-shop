<div class="row">
    @forelse($products as $product)
        @php
            $stock_qty = product_stock($product);
        @endphp
        <!-- Start col -->
        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 ">
            <div class="product-bar productcss m-b-30 product d-none d-md-block" data-value="{{ $product->id }}">
                <div class="product-head">
                    <a href="#"><img
                            src="{{ (!empty($product->images)) ? url('public/uploads/products/' . $product->images) : url('public/backend/images/no_images.png') }}"
                            class="img-fluid" style="height: 125px;"></a>
                </div>
                <div class="product-body py-3" style="height: 145px">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h6 class="mt-1 mb-3">{{ $product->name }}</h6>
                        </div>
                        <div class="col-12 text-center">
                            <small class="font-weight-bold">{{ $product->selling_price }}</small>
                            {{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                        </div>
                        <div class="col-12">
                            <div class="text-center">
                                <small class="stock">Stock : {{ $stock_qty }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->

            <div class="category_item d-block d-md-none">
                <div class="product_part">
                    <div id="mproducts">
                        <table class="pro_tble">
                            <thead>
                                <tr class="tbl_heading">
                                    <th class="product_name text-start">Image</th>
                                    <th class="product_name text-start">Name</th>
                                    <th class="product_price text-start">Price</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="table_tr" >
                                    <td colspan="3">
                                        <div class="product-bar productcsss product row" data-value="{{ $product->id }}">

                                            <div class="product-head col-3">
                                                <a href="#"><img src="{{ (!empty($product->images)) ? url('public/uploads/products/' . $product->images) : url('public/backend/images/no_images.png') }}" class="img-fluid" style="height:40px; width: 40px;"
                                                        alt="product"></a>
                                            </div>
                                            <div class="product-body col-5 ">
                                                <div class="row">
                                                    <div class="col-12 text-start">
                                                        <h6 class="" style="font-size: 12px;">
                                                        {{ $product->name }}
                                                        </h6>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="text-left">
                                                            <small style="font-size: 10px;" class="stock">Stock :
                                                            {{ $stock_qty }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4 text-center" style="padding: 4px 2px;">
                                                <small style="font-size: 14px;" class="">{{ $product->selling_price }}</small>
                                                {{ empty(get_setting('com_currency')) ?: get_setting('com_currency') }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!--  -->
        </div>
        <!-- End col -->
    @empty
        <div class="col-md-12" style="padding-bottom: 30px;">
            <div class="alert alert-danger text-center" role="alert"> Products not available!</div>
        </div>
    @endforelse
</div>