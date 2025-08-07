@extends('backend.layouts.master')
@section('section-title', 'Edit Product')
@section('page-title', 'Product Edit')

@if (check_permission('product.update'))
    @section('action-button')
        <a href="{{ route('product.index') }}" class="btn add_list_btn">
            <i class="mr-2 feather icon-list"></i>
            All Product
        </a>
    @endsection
@endif

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <div class="">
                        <form class="row g-3 needs-validation" method="POST"
                            action="{{ route('product.update', $data->id) }}" enctype="multipart/form-data">
                            @csrf
                            {{-- Product name --}}
                            <div class="mt-2 col-md-6">
                                <label for="name" class="form-label fw-bold">Product Name *</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter product name"
                                    value="{{ $data->name }}">
                                <div class="errors">{{ $errors->has('name') ? $errors->first('name') : '' }}</div>
                            </div>

                            {{-- Product barcode  --}}
                            <div class="mt-2 col-md-6">
                                <label for="barcode" class="form-label fw-bold">Product Barcode</label>
                                <input type="text" class="form-control" placeholder="Enter product barcode"
                                    name="barcode" value="{{ $data->barcode }}">
                                <div class="errors">{{ $errors->has('barcode') ? $errors->first('barcode') : '' }}</div>
                            </div>

                            {{-- Category --}}
                            <div class="mt-2 col-md-6">
                                <label for="unit_id" class="form-label fw-bold">Category *</label>
                                <select class="select2" name="category_id">
                                    <option selected value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value={{ $category->id }}
                                            {{ $category->id == $data->category_id ? 'selected' : '' }}>{{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="errors">{{ $errors->has('category_id') ? $errors->first('category_id') : '' }}
                                </div>
                            </div>

                            {{-- Brand --}}
                            <div class="mt-2 col-md-6">
                                <label for="brand_id" class="form-label fw-bold">Brand</label>
                                <select class="select2" name="brand_id">
                                    <option selected value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $brand->id == $data->brand_id ? 'selected' : '' }}>{{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @if ($data->unit->related_unit_id == null)
                                {{-- Unit --}}
                                <div class="mt-2 col-md-3">
                                    <label for="unit_id" class="form-label fw-bold">Main Unit</label>
                                    <select class="select2 main_unit" name="unit_id">
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ $unit->id == $data->unit_id ? 'selected' : '' }}>{{ $unit->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Unit --}}
                                <div class="mt-2 col-md-3">
                                    <label for="unit_id" class="form-label fw-bold">Sub Unit</label>
                                    <select name="sub_unit_id" id="" class="form-control sub_unit">
                                        <option value="">No Related Unit Found</option>
                                    </select>
                                </div>


                                {{-- Unit --}}
                                <div class="mt-2 col-md-6">
                                    <div class="form-group">
                                        <label for="">Low Stock Quantity</label>
                                        <div class="opening_stocks form-row" style="padding-left: 5px; padding-right:5px;">
                                            <input type="text" name="main_qty" value="{{$data->main_qty}}" class="form-control col"
                                                placeholder="Pices">
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Unit --}}
                                <div class="mt-2 col-md-3">
                                    <label for="unit_id" class="form-label fw-bold">Main Unit</label>
                                    <select class="select2 main_unit" name="unit_id">
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ $unit->id == $data->unit_id ? 'selected' : '' }}>{{ $unit->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Unit --}}
                                <div class="mt-2 col-md-3">
                                    <label for="unit_id" class="form-label fw-bold">Sub Unit</label>
                                    <select name="sub_unit_id" id="" class="form-control sub_unit">
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ ($unit->id == $data->unit->related_unit_id) ? 'selected' : '' }}>
                                                {{ $unit->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                {{-- Unit --}}
                                <div class="mt-2 col-md-3">
                                    <div class="form-group">
                                        <label for="">Low Stock Quantity</label>
                                        <div class="opening_stocks form-row" style="padding-left: 5px; padding-right:5px;">
                                            <input type="text" name="main_qty" value="{{$data->main_qty}}" class="form-control col"
                                                placeholder="Pices">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 col-md-3">
                                    <div class="form-group">
                                        <label for=""></label>
                                        <div class="opening_stocks form-row" style="padding-left: 5px; padding-right:5px;">
                                            <input type="text" name="sub_qty" value="{{$data->sub_qty}}" class="form-control col"
                                                placeholder="Pices">
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(env('APP_SC') == 'yes')
                                <div class="col-md-6 mt-2" style="margin-right: -6px">
                                    <label for="size" class="form-label fw-bold">Size </label>
                                    <select class="select2" name="size[]" multiple>
                                        {{-- <option value="" selected>Select Size</option> --}}
                                        @foreach($sizes as $size)
                                            <option value="{{ $size->id }}" {{ in_array($size->id, $selectedSizeIds) ? 'selected' : '' }}>{{ $size->size }}</option>
                                        @endforeach
                                    </select>
                                    <div class="errors">{{ $errors->has('size') ? $errors->first('size') : '' }}</div>
                                </div>
                                <div class="col-md-6 mt-2" style="margin-right: -6px">
                                    <label for="color" class="form-label fw-bold">Color </label>
                                    <select class="select2" name="color[]" multiple>
                                        {{-- <option value="" selected>Select Color</option> --}}
                                        @foreach($colors as $color)
                                            <option value="{{ $color->id }}"  {{ in_array($color->id, $selectedColorIds) ? 'selected' : '' }}> {{ $color->color }}</option>
                                        @endforeach
                                    </select>
                                    <div class="errors">{{ $errors->has('color') ? $errors->first('color') : '' }}</div>
                                </div>
                            @endif

                            {{-- Price --}}
                            <div class="mt-2 col-md-6">
                                <label for="purchase_price" class="form-label fw-bold">Purchase Price *</label>
                                <input type="text" class="form-control" name="purchase_price"
                                    value="{{ $data->purchase_price }}">
                                <div class="errors">
                                    {{ $errors->has('purchase_price') ? $errors->first('purchase_price') : '' }}</div>
                            </div>

                                          {{--Sale Price --}}
                                <div class="mt-2 col-sm-6 col-md-6">
                                <label for="after_discount_price" class="frm_lbl "> after Discount Price *</label>
                                <input type="number" class="form-control" name="after_discount_price" id="after_discount_price" value="{{ $data->after_discount_price }}">
                                <div class="errors">
                                    {{ $errors->has('after_discount_price') ? $errors->first('after_discount_price') : '' }}
                                </div>
                            </div>
                            <div class="mt-2 col-sm-6 col-md-6">
                                <label for="discount" class="frm_lbl">Discount (%)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="discount" id="discount" step="0.01" placeholder="Enter discount" value="{{ $data->discount }}">

                                </div>
                                <div class="errors">
                                    {{ $errors->has('discount') ? $errors->first('discount') : '' }}
                                </div>
                            </div>
                            <div class="mt-2 col-md-6">
                                <label for="selling_price" class="form-label fw-bold">Sale Price *</label>
                               <input type="text" class="form-control" name="selling_price"
       value="{{ $data->selling_price }}" readonly>

                                <div class="errors">
                                    {{ $errors->has('selling_price') ? $errors->first('selling_price') : '' }}</div>
                            </div>

                            {{-- Discount --}}

                            {{-- status --}}
                            <div class="col-md-6 mt-2" style="margin-right: -6px">
                                <label for="status" class="form-label fw-bold">Status *</label>
                                <select class="select2" name="status">
                                    <option value="1" {{ ($data->status == 1) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ ($data->status == 0) ? 'selected' : '' }}>Deactive</option>
                                </select>
                                <div class="errors">{{ ($errors->has('status'))?$errors->first('status'):''; }}</div>
                            </div>

                            {{-- Description --}}
                            <div class="mt-2 col-md-6">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control" name="description" rows="3">{{ $data->description }}</textarea>
                            </div>

                            {{-- Image --}}
                            <div class="mt-2 col-md-6">
                                <label for="image" class="form-label fw-bold">Product
                                    Images</label>
                                <input class="form-control image-uploadify" type="file" name="images"
                                    accept="image/*" onchange="readURL(this);">
                            </div>

                            <div class="mt-2 col-md-6">
                                <img id="image"
                                    src="{{ !empty($data->images) ? asset('uploads/products/' . $data->images) : asset('backend/images/no_images.png') }}"
                                    width="120px" style="border-radius: 25px" height="80px" />
                                <input type="hidden" name="old_image" value="{{ $data->images }}">
                            </div>

                            <div class="mt-3 text-center col-12">
                                <button class="btn save_btn" type="submit"> Save </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image')
                        .attr('src', e.target.result)
                        .width(80)
                        .height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script>
        $('.main_unit').change(function() {
            $('.sub_unit').html('<option value="">No Related Unit Found</option>');
            var main_unit_id = $(this).find(':selected').val();
            var main_unit_text = $(this).find(':selected').text();

            let url = "{{ route('product-unit', 'my_id') }}".replace('my_id', main_unit_id);

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    if (data) {
                        var sub_value = '<option value="">Select Unit</option><option value="' + data
                            .related_unit_id + '">' + data.related_unit.name + '</option>';
                        $('.sub_unit').html(sub_value);

                        // Opening Stock
                        var opening_stock = "";
                        opening_stock +=
                            `<input type="text" name="main_qty" value="" class="form-control col" placeholder="${main_unit_text}">`;
                        $('.opening_stocks').html(opening_stock);
                    } else {
                        $('.sub_unit').html('<option value="" selected>No Related Unit Found</option>');
                        // opening Stock

                        var opening_stock =
                            `<input type="text" name="main_qty" value="" class="form-control col" placeholder="${main_unit_text}">`;
                        $('.opening_stocks').html(opening_stock);
                    }
                }
            });
        });

        $('.sub_unit').change(function() {
            var sub_unit_id = $(this).find(':selected').val();
            var sub_unit_text = $(this).find(':selected').text();

            var main_unit_id = $('.main_unit').find(':selected').val();
            var main_unit_text = $('.main_unit').find(':selected').text();
            var opening_stock = '';
            if (sub_unit_id == "") {
                opening_stock =
                    `<input type="text" name="main_qty" value="" class="form-control col" placeholder="${main_unit_text}">`;
            } else {
                opening_stock +=
                    `<input type="text" name="main_qty" value="" class="form-control col" placeholder="${main_unit_text}" style="margin-right:5px;">`;
                opening_stock +=
                    `<input type="text" name="sub_qty" value="" class="form-control col" placeholder="${sub_unit_text}">`;
            }

            $('.opening_stocks').html(opening_stock);

        });
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const discountInput = document.getElementById('discount');
        const afterDiscountPriceInput = document.getElementById('after_discount_price');
        const sellingPriceInput = document.querySelector('input[name="selling_price"]');

        function calculateSellingPrice() {
            const afterDiscount = parseFloat(afterDiscountPriceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;

            let sellingPrice = 0;

            if (discount > 0) {
                const discountAmount = afterDiscount * (discount / 100);
                sellingPrice = afterDiscount - discountAmount;
            } else {
                sellingPrice = afterDiscount;
            }

            sellingPriceInput.value = sellingPrice.toFixed(2);
        }

        // Calculate on input change
        discountInput.addEventListener('input', calculateSellingPrice);
        afterDiscountPriceInput.addEventListener('input', calculateSellingPrice);

        // 🔁 Recalculate once on page load (for edit form)
        calculateSellingPrice();
    });
</script>


@endsection
