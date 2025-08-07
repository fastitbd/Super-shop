@extends('backend.layouts.master')
@section('section-title', 'Product')
@section('page-title', 'Add Product')

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
                    <div>
                        <form class="row g-3 needs-validation" method="POST" action="{{ route('product.store') }}"
                            enctype="multipart/form-data" novalidate>
                            @csrf
                            
                            {{-- Product name --}}
                            <div class="mt-2 col-md-6">
                                <label for="name" class="frm_lbl">Name *</label>
                                <input type="text" onfocus="this.select()" autofocus class="form-control" name="name"
                                    placeholder="Enter Name">
                                <div class="errors">{{ $errors->has('name') ? $errors->first('name') : '' }}</div>
                            </div>
                              {{-- Category --}}
                              <div class="mt-2 col-sm-6 col-md-6 ">
                                <div class="row">
                                    <div class="col-md-11 col-10" style="margin-right: -6px">
                                        <label for="unit_id" class="frm_lbl">Category *</label>
                                      <select class="select2" name="category_id" id="categoryId">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                        <div class="errors">
                                            {{ $errors->has('category_id') ? $errors->first('category_id') : '' }}</div>
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-2 m-0 p-0">
                                        <label class="form-label font-weight-bold"></label>
                                        <div class="" style="margin-top: 10px">
                                            {{-- <button type="button" class="btn btn-primary"></button> --}}
                                            <button data-toggle="modal" type="button" data-target="#addModal1"
                                                class="btn extra_btn">
                                                <i class="feather icon-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{--Sub Category --}}
                              <div class="mt-2 col-sm-6 col-md-6 ">
                                <div class="row">
                                    <div class="col-md-11 col-10" style="margin-right: -6px">
                                        <label for="unit_id" class="frm_lbl">Sub Category *</label>
                                       <select class="select2" name="subcategory_id" id="subCategoryId">
                                            <option value="">Select Sub Category</option>
                                        </select>
                                        <div class="errors">
                                            {{ $errors->has('category_id') ? $errors->first('category_id') : '' }}</div>
                                    </div>
                                    <div class="col-sm-1 col-md-1 col-2 m-0 p-0">
                                        <label class="form-label font-weight-bold"></label>
                                        <div class="" style="margin-top: 10px">
                                            
                                            <button type="button" class="btn extra_btn" data-toggle="modal" data-target="#exampleModal">
                                               <i class="feather icon-plus"></i>
                                                </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                             {{-- Brand --}}
                             <div class="mt-2 col-sm-6 col-md-6 " >
                                <div class="row">
                                    <div class="col-md-11 col-10" style="margin-right: -6px">
                                        <label for="brand_id" class="frm_lbl">Brand</label>
                                        <select class="select2" name="brand_id" id="brandId">
                                            <option selected value="">Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value={{ $brand->id }}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1 col-2 m-0 p-0">
                                        <label class="font-weight-bold"></label>
                                        <div class="" style="margin-top: 10px">
                                            {{-- <button type="button" class="btn btn-primary"></button> --}}
                                            <button data-toggle="modal" type="button" data-target="#addModal"
                                                class="btn extra_btn">
                                                <i class="feather icon-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                {{-- Unit --}}
                                <div class="mt-2 col-sm-6 col-md-3 ">
                                <label for="unit_id" class="frm_lbl">Main Unit</label>
                                <select class="select2 main_unit" name="unit_id">
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                                {{-- Unit --}}
                                <div class="mt-2 col-sm-6 col-md-3 ">
                                <label for="unit_id" class="frm_lbl">Sub Unit</label>
                                <select name="sub_unit_id" id="" class="form-control sub_unit">
                                    <option value="">No Related Unit Found</option>
                                </select>
                            </div>
                               {{-- Purchase Price --}}
                               <div class="mt-2 col-sm-6 col-md-6">
                                <label for="purchase_price" class="frm_lbl ">Purchase Price</label>
                                <input type="number" class="form-control" name="purchase_price" id="purchase_price">
                                <div class="errors">
                                    {{ $errors->has('purchase_price') ? $errors->first('purchase_price') : '' }}
                                </div>
                            </div>

                                {{--Sale Price --}}
                                <div class="mt-2 col-sm-6 col-md-6">
                                <label for="after_discount_price" class="frm_lbl "> after Discount Price *</label>
                                <input type="number" class="form-control" name="after_discount_price" id="after_discount_price">
                                <div class="errors">
                                    {{ $errors->has('after_discount_price') ? $errors->first('after_discount_price') : '' }}
                                </div>
                            </div>

                            {{-- Discount --}}
                            <div class="mt-2 col-sm-6 col-md-6">
                                <label for="discount" class="frm_lbl">Discount (%)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="discount" id="discount" step="0.01" placeholder="Enter discount">

                                </div>
                                <div class="errors">
                                    {{ $errors->has('discount') ? $errors->first('discount') : '' }}
                                </div>
                            </div>
                              {{--Sale Price --}}
                                <div class="mt-2 col-sm-6 col-md-6">
                                <label for="selling_price" class="frm_lbl ">Sale Price *</label>
                                <input type="number" class="form-control" name="selling_price" id="selling_price">
                                <div class="errors">
                                    {{ $errors->has('selling_price') ? $errors->first('selling_price') : '' }}
                                </div>
                               
                            </div>

                            {{-- Product barcode  --}}
                            <div class="mt-2  col-md-6">
                                <label for="barcode" class="frm_lbl">Bar Code</label>
                                <input type="text" class="form-control" placeholder="Enter Barcode" name="barcode">
                                <div class="errors">{{ $errors->has('barcode') ? $errors->first('barcode') : '' }}</div>
                            </div>

                            {{-- Unit --}}
                            <div class="mt-2 col-sm-6 col-md-6 ">
                                <div class="form-group">
                                    <label class="frm_lbl" for="">Low Stock Quantity</label>
                                    <div class="opening_stocks form-row" style="padding-left: 5px; padding-right:5px;">
                                        <input type="text" name="main_qty" value="" class="form-control col"
                                            placeholder="Pices">
                                    </div>
                                </div>
                            </div>
                            {{-- variation --}}
                            @if(env('APP_SC') == 'yes')
                                <div class="mt-2 col-md-6 " >
                                    <div class="row">
                                        <div class="col-md-11 col-10" style="margin-right: -6px">
                                            <label for="size" class="frm_lbl">Size </label>
                                            <select class="select2" name="size[]" multiple>
                                                {{-- <option value="" selected>Select Size</option> --}}
                                                @foreach($sizes as $size)
                                                    <option value="{{ $size->id }}">{{ $size->size }}</option>
                                                @endforeach
                                            </select>
                                            <div class="errors">{{ $errors->has('size') ? $errors->first('size') : '' }}</div>
                                        </div>
                                        <div class="col-md-1 col-2 m-0 p-0">
                                            <label class="frm_lbl font-weight-bold"></label>
                                            <div class="" style="margin-top: 7px">
                                                {{-- <button type="button" class="btn btn-primary"></button> --}}
                                                {{-- <button data-toggle="modal" type="button" data-target="#sizeModal"
                                                    class="btn extra_btn">
                                                            <i class="feather icon-plus"></i> 
                                                </button> --}}

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn extra_btn" data-toggle="modal" data-target="#addSizeModal">
                                                    <i class="feather icon-plus"></i> 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 col-sm-6 col-md-6 " >
                                    <div class="row">
                                        <div class="col-md-11 col-10" style="margin-right: -6px">
                                            <label for="color" class="frm_lbl ">Color </label>
                                            <select class="select2" name="color[]" multiple>
                                                {{-- <option value="" selected>Select Color</option> --}}
                                                @foreach($colors as $color)
                                                    <option value="{{ $color->id }}"> {{ $color->color }}</option>
                                                @endforeach
                                            </select>
                                            <div class="errors">{{ $errors->has('color') ? $errors->first('color') : '' }}</div>
                                        </div>
                                        <div class="col-md-1 col-2 m-0 p-0">
                                            <label class="form-label font-weight-bold"></label>
                                            <div class="" style="margin-top: 10px">
                                                <button type="button" class="btn extra_btn" data-toggle="modal" data-target="#addColorModal">
                                                    <i class="feather icon-plus"></i> 
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
           
                            {{-- has serial --}}
                            @if (env('APP_IMEI') == 'yes')
                                <div class="mt-2 col-md-6">
                                    <div class="form-group">
                                        <label for="">Has IMEI?</label>
                                        <div class=" form-row" style="padding-left: 5px; padding-right:5px;">
                                            {{-- <input type="text" name="has_serial" value=""  placeholder="Pices"> --}}
                                            <select name="has_serial" id="" class="form-control col">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- status --}}
                            <div class="col-sm-6 col-md-6 mt-2" style="margin-right: -6px">
                                <label for="status" class="frm_lbl ">Status *</label>
                                <select class="select2" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                                <div class="errors">{{ $errors->has('status') ? $errors->first('status') : '' }}</div>
                            </div>
                            
                            <div class="mt-2 col-md-6  ">
                                <label for="description" class="frm_lbl">Description</label>
                                <textarea class="form-control" name="description" placeholder="Write Here" rows="2"></textarea>
                            </div>

                            {{-- Image --}}
                            <div class="mt-2 col-md-6 ">
                                <label for="image" class="frm_lbl ">Product
                                    Images</label>
                                <input class="form-control image-uploadify" type="file" name="images"
                                    accept="image/*" onchange="readURL(this);">
                            </div>

                            <div class="mt-2 col-md-6 " >
                                <img id="image" style="border-radius: 25px" src="{{ asset('backend/images/no_images.png') }}" width="120px"
                                    height="80px" />
                            </div>

                            <div class="mt-3 text-center col-12">
                                <button  class=" save-btn" type="submit" > Save </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Add Category Modal --}}
    <form action="#" id="categoryForm" method="POST">
        @csrf
        <x-another-modal title="Add Category" sizeClass="modal-md">
            <x-input label="Category Name *" type="text" name="name" placeholder="Enter Category Name" required />
            <x-input label="Category Order" type="number" name="order_by" placeholder="Enter Category order" />
            <x-input label="Category Image" type="file" name="images" />
            
        </x-another-modal>
    </form>

        {{-- Add Sub Category Modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Sub Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('subCategory.store') }}" method="POST">
    @csrf
    <div class="modal-content">
        <!-- modal-header, modal-body -->

        
        <div class="form-group">
            <label for="sub_name">Sub Category Name *</label>
            <input type="text" name="name" id="sub_name" class="form-control" required>
        </div>

 

        <div class="form-group">
            <label for="order_by">Order By</label>
            <input type="number" name="order_by" id="order_by" class="form-control">
        </div>

        <!-- modal-footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</form>

      </div>
    
    </div>
  </div>
</div>


    {{-- Add Brand Modal --}}
    <form action="#" id="brandForm" method="POST">
        @csrf
        <x-add-modal title="Add Brand" sizeClass="modal-md">
            <x-input label="Brand Name:" type="text" name="name" placeholder="Enter Brand Name" required />
        </x-add-modal>
    </form>
    {{-- Add size Modal --}}
    <form action="#" id="brandForm" method="POST">
        @csrf
        <x-add-modal title="Add Brand" sizeClass="modal-md">
            <x-input label="Brand Name:" type="text" name="name" placeholder="Enter Brand Name" required />
        </x-add-modal>
    </form>


    <!-- size Modal -->
    <div class="modal fade" id="addSizeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('size.store') }}" method="POST" id="addSizeForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Size</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label ml-3" > Size </label>
                            <input type="text" class="form-control" name="size_name" placeholder="Size Name">
                        </div>
                        <div id="sizeError" class="text-danger"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn"  style="padding: 3px 20px; background: #f04438;color:white; border-radius:25px" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn" style="padding: 3px 20px; background: #12b76a;color:white; border-radius:25px;margin-right: 5px;border:none">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- color Modal -->
    <div class="modal fade" id="addColorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('color.store') }}" method="POST" >
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Color</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label ml-3" > Color </label>
                            <input type="text" class="form-control" name="color_name" placeholder="Color Name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn"  style="padding: 3px 20px; background: #f04438;color:white; border-radius:25px" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn" style="padding: 3px 20px; background: #12b76a;color:white; border-radius:25px;margin-right: 5px;border:none">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


{{-- Mobile view  start--}}
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image')
                        .attr('src', e.target.result)
                        .width(120)
                        .height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

@push('js')

{{-- <script>
    $('#addSizeForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            alert(response.message); // Show success message
            $('#addSizeModal').modal('hide'); // Hide the modal
        },
        error: function (xhr) {
            // Display validation error
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                if (errors.size) {
                    $('#size').addClass('is-invalid');
                    $('#size').after(`<small class="text-danger">${errors.size[0]}</small>`);
                }
            }
        },
    });
}); --}}


{{-- // $('#addSizeForm').on('submit', function (e) {
//     e.preventDefault(); // Prevent default form submission

//     const form = $(this);
//     const actionUrl = form.attr('action');
//     const sizeInput = $('#size');
//     const errorMessage = sizeInput.next('.text-danger');

//     // Clear any previous error message
//     sizeInput.removeClass('is-invalid');
//     if (errorMessage.length) {
//         errorMessage.remove(); // Remove previous error message
//     }

//     $.ajax({
//         url: actionUrl,
//         method: 'POST',
//         data: form.serialize(),
//         success: function (response) {
//             alert(response.message); // Show success message
//             $('#addSizeModal').modal('hide'); // Hide modal
//             form.trigger('reset'); // Reset the form
//         },
//         error: function (xhr) {
//             // Check if the status is 422 (validation error)
//             if (xhr.status === 422) {
//                 const errors = xhr.responseJSON.errors;
//                 if (errors.size) {
//                     // Add error class and display error message
//                     sizeInput.addClass('is-invalid');
//                     sizeInput.after(`<small class="text-danger">${errors.size[0]}</small>`);
//                 }
//             } else {
//                 alert('An unexpected error occurred. Please try again.');
//             }
//         },
//     });
// }); --}}


{{-- </script> --}}

{{-- <script>
    $(document).ready(function () {
        // Attach change event listeners for both price fields
        $('#purchase_price, #selling_price').on('change', function () {
            var purchasePrice = parseFloat($('#purchase_price').val()) || 0;
            var sellingPrice = parseFloat($('#selling_price').val()) || 0;

            // Check if purchase price is greater than selling price
            if (purchasePrice > sellingPrice) {
                $('#price_error').show(); // Show error message
                $('#submitBtn').attr('disabled', true); // Disable submit button
            } else {
                $('#price_error').hide(); // Hide error message
                $('#submitBtn').attr('disabled', false); // Enable submit button
            }
        });
    });
</script> --}}
    <script>
        //category modal ajax code
        $(document).ready(function () {
            $('#categoryForm').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: "{{ route('category.store') }}", // Define the route for submission
                    method: 'POST',
                    data: $(this).serialize(), // Serialize form data
                    success: function (response) {
                        // Reload the table data dynamically
                        $('#addModal1').modal('hide');
                        // Clear form
                        $('#categoryForm')[0].reset();

                        // Add the new customer to the dropdown without appending manually
                        // Reset and reload the dropdown
                        $('#categoryId').load(location.href + ' #categoryId>*');

                    },
                    error: function (xhr) {
                        // Handle validation errors or server errors here
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

<script>
$(document).ready(function () {
    // Submit form via AJAX
    $('#subCategoryForm').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let actionUrl = form.attr('action');
        let formData = form.serialize();

        $.ajax({
            type: 'POST',
            url: actionUrl,
            data: formData,
            success: function (response) {
                // Add new option to select
                let newOption = new Option(response.name, response.id, false, false);
                $('#subCategoryId').append(newOption).trigger('change');

                // Reset and hide modal
                form[0].reset();
                $('#addModal12').modal('hide');

                // Optional: show success toast
                toastr.success('Sub Category added successfully!');
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function (key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('Something went wrong.');
                }
            }
        });
    });
});
</script>


    <script>
        //Brand modal ajax code
        $(document).ready(function () {
            $('#brandForm').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: "{{ route('brand.store') }}", // Define the route for submission
                    method: 'POST',
                    data: $(this).serialize(), // Serialize form data
                    success: function (response) {
                        // Reload the table data dynamically
                        $('#addModal').modal('hide');
                        // Clear form
                        $('#brandForm')[0].reset();

                        // Add the new customer to the dropdown without appending manually
                        // Reset and reload the dropdown
                        $('#brandId').load(location.href + ' #brandId>*');

                    },
                    error: function (xhr) {
                        // Handle validation errors or server errors here
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        $('.main_unit').change(function(){
            $('.sub_unit').html('<option value="">No Related Unit Found</option>');
            var main_unit_id=$(this).find(':selected').val();
            var main_unit_text=$(this).find(':selected').text();

            let url = "{{ route('product-unit', 'my_id') }}".replace('my_id', main_unit_id);

            $.ajax({
                url: url,
                method: 'GET',
                success: function (data) {
                    if(data){
                        var sub_value='<option value="">Select Unit</option><option value="'+data.related_unit_id+'">'+data.related_unit.name+'</option>';
                        $('.sub_unit').html(sub_value);

                        // Opening Stock
                        var opening_stock="";
                        opening_stock+=`<input type="text" name="main_qty" value="" class="form-control col" placeholder="${main_unit_text}">`;
                        $('.opening_stocks').html(opening_stock);
                    }else{
                        $('.sub_unit').html('<option value="" selected>No Related Unit Found</option>');
                        // opening Stock

                        var opening_stock=`<input type="text" name="main_qty" value="" class="form-control col" placeholder="${main_unit_text}">`;
                        $('.opening_stocks').html(opening_stock);
                    }
                }
            });
        });

        $('.sub_unit').change(function(){
            var sub_unit_id=$(this).find(':selected').val();
            var sub_unit_text=$(this).find(':selected').text();

            var main_unit_id=$('.main_unit').find(':selected').val();
            var main_unit_text=$('.main_unit').find(':selected').text();
            var opening_stock='';
            if(sub_unit_id==""){
                opening_stock=`<input type="text" name="main_qty" value="" class="form-control col" placeholder="${main_unit_text}">`;
            }else{
                opening_stock+=`<input type="text" name="main_qty" value="" class="form-control col" placeholder="${main_unit_text}" style="margin-right:5px;">`;
                opening_stock+=`<input type="text" name="sub_qty" value="" class="form-control col" placeholder="${sub_unit_text}">`;
            }

            $('.opening_stocks').html(opening_stock);

        });
    </script>
    <script>
    $(document).ready(function () {
        $('#categoryId').on('change', function () {
            var categoryId = $(this).val();

            if (categoryId) {
                $.ajax({
                    url: '/get-subcategories/' + categoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#subCategoryId').empty();
                        $('#subCategoryId').append('<option value="">Select Sub Category</option>');

                        $.each(data, function (key, value) {
                            $('#subCategoryId').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#subCategoryId').empty().append('<option value="">Select Sub Category</option>');
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const discountInput = document.getElementById('discount');
        const afterDiscountPriceInput = document.getElementById('after_discount_price');
        const sellingPriceInput = document.getElementById('selling_price');

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

            sellingPriceInput.value = sellingPrice.toFixed(0); // Show 2 decimal places
        }

        discountInput.addEventListener('input', calculateSellingPrice);
        afterDiscountPriceInput.addEventListener('input', calculateSellingPrice);
    });
</script>



@endpush
