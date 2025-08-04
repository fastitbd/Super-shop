@extends('backend.layouts.master')
@section('section-title', 'Service')
@section('page-title', 'Add Service')

@if (check_permission('product.index'))
    @section('action-button')
        <a href="{{ route('product.index') }}" class="btn add_list_btn">
            <i class="mr-2 feather icon-list"></i>
            All Service
        </a>
    @endsection
@endif

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <div class="border rounded">
                        <form class="row g-3 needs-validation" method="POST" action="{{ route('service.store') }}"
                            enctype="multipart/form-data" novalidate>
                            @csrf
                            
                            {{-- Product name --}}
                            <div class="mt-2 col-md-6">
                                <label for="name" class="form-label fw-bold">Name *</label>
                                <input type="text" onfocus="this.select()" autofocus class="form-control" name="name"
                                    placeholder="Enter Name">
                                <div class="errors">{{ $errors->has('name') ? $errors->first('name') : '' }}</div>
                            </div>

                            {{-- Product barcode  --}}
                            <div class="mt-2 col-md-6">
                                <label for="barcode" class="form-label fw-bold">Barcode</label>
                                <input type="text" class="form-control" placeholder="Enter Barcode" name="barcode">
                                <div class="errors">{{ $errors->has('barcode') ? $errors->first('barcode') : '' }}</div>
                            </div>

                            <div class="mt-2 col-md-6">
                                <label for="selling_price" class="form-label fw-bold">Price *</label>
                                <input type="number" class="form-control" name="selling_price">
                                <div class="errors">
                                    {{ $errors->has('selling_price') ? $errors->first('selling_price') : '' }}</div>
                            </div>
                            {{-- status --}}

                            <div class="col-md-6 mt-2" style="margin-right: -6px">
                                <label for="status" class="form-label fw-bold">Status *</label>
                                <select class="select2" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                                <div class="errors">{{ $errors->has('status') ? $errors->first('status') : '' }}</div>
                            </div>
                            <div class="mt-2 col-md-12  ">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control" name="description" rows="2"></textarea>
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
    {{-- Add Category Modal --}}
    <form action="#" id="categoryForm" method="POST">
        @csrf
        <x-another-modal title="Add Category" sizeClass="modal-md">
            <x-input label="Category Name *" type="text" name="name" placeholder="Enter Category Name" required />
        </x-another-modal>
    </form>

    {{-- Add Brand Modal --}}
    <form action="#" id="brandForm" method="POST">
        @csrf
        <x-add-modal title="Add Brand" sizeClass="modal-md">
            <x-input label="Brand Name:" type="text" name="name" placeholder="Enter Brand Name" required />
        </x-add-modal>
    </form>



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
    <script>
        //category modal ajax code
        $(document).ready(function() {
            $('#categoryForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: "{{ route('category.store') }}", // Define the route for submission
                    method: 'POST',
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        // Reload the table data dynamically
                        $('#addModal1').modal('hide');
                        // Clear form
                        $('#categoryForm')[0].reset();

                        // Add the new customer to the dropdown without appending manually
                        // Reset and reload the dropdown
                        $('#categoryId').load(location.href + ' #categoryId>*');

                    },
                    error: function(xhr) {
                        // Handle validation errors or server errors here
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script>
        //Brand modal ajax code
        $(document).ready(function() {
            $('#brandForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: "{{ route('brand.store') }}", // Define the route for submission
                    method: 'POST',
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        // Reload the table data dynamically
                        $('#addModal').modal('hide');
                        // Clear form
                        $('#brandForm')[0].reset();

                        // Add the new customer to the dropdown without appending manually
                        // Reset and reload the dropdown
                        $('#brandId').load(location.href + ' #brandId>*');

                    },
                    error: function(xhr) {
                        // Handle validation errors or server errors here
                        console.error(xhr.responseText);
                    }
                });
            });
        });
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
@endpush
