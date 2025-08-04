@extends('backend.layouts.master')
@section('section-title', 'Product')
@section('page-title', 'Product List')
@if (check_permission('product.create'))
    @section('action-button')
        <a href="{{ route('product.create') }}" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Product
        </a>
    @endsection
@endif
@push('css')
<style>
    @media print {
        @page {
        size: auto;
        }

        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Roboto,sans-serif;
        }

        .print_area {
            position: absolute;
            top: 0;
            width: 100%;
        }

        .print_area * {
            visibility: visible !important;
        }
    }
    .table-responsive{
        overflow-x: auto;
    }
</style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <form action="{{ route('product.index') }}" method="GET">
                        @php
                            $categories = App\Models\Category::get();
                            $produc = App\Models\Product::where('is_service',0)->get();
                        @endphp
                        <div class="row">
                            
                            <div class="col-md-3 mt-3">
                                <input type="text" class="form-control" name="barcode" placeholder="Enter Barcode" value="{{ $barcode }}" />
                            </div>
                            
                            <div class="col-md-3 mt-3">
                                <select name="product_id" id="" class="select2" >
                                    <option value="">All Product</option>
                                    @foreach ($produc as $item)
                                        <option value="{{ $item->id }}"{{ ($product_id == $item->id)?'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-3">
                                <select name="category_id" id="" class="select2">
                                    <option value="">All Category</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}"{{ ($category_id == $item->id)?'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-3">
                                <button type="submit" class="btn add_list_btn">Filter</button>
                                <a href="{{ route('product.index') }}" class="btn add_list_btn_reset">Reset</a>
                                <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-2" style="background: #f2f2f2;padding-top: 3px">
                        <div class="col-md-12 text-right">
                            @php 
                            $total_product = App\Models\Product::where('is_service',0)->count();
                            @endphp
                            <h5><strong>Total Product : {{$total_product}} </strong> </h5>
                            
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table id="datatable-buttons" class="table table-striped">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">#SL</th>
                                    <th>Name</th>
                                    <th>Barcode</th>
                                    <th>Category</th>
                                    <!-- <th>Brand</th> -->
                                    <th>Cost</th>
                                    <th>Price</th>
                                    <!-- <th>Status</th> -->
                                    <th></th>
                                    <th class="header_style_right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $data)
                                    @php
                                        $count_inv = App\Models\InvoiceItem::where('product_id', $data->id)->count();
                                        $count_pur = App\Models\PurchaseItem::where('product_id', $data->id)->count();
                                        
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->barcode }}</td>
                                        <td>{{ $data->category->name }}</td>
                                        <!-- <td>{{ ($data->brand_id==NULL)?"No Brand":$data->brand->name }}</td> -->
                                        <td>{{ $data->purchase_price }}</td>
                                        <td>{{ $data->selling_price }}</td>
                                        <!-- <td>
                                            @if($data->status == 1 )
                                                Active
                                            @endif
                                            @if($data->status == 0)
                                                Deactive
                                            @endif
                                        </td> -->
                                        <td>
                                            <a href="#" class="btn generated_barcode"
                                                data-name="{{ $data->name }}" data-code="{{ $data->barcode }}"
                                                data-price="{{ $data->selling_price }}">
                                                <i class="fa fa-barcode"></i>
                                            </a>
                                        </td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @if (check_permission('product.edit'))
                                                        <a href="{{ route('product.edit', $data->id) }}"
                                                            class="dropdown-item text-primary">
                                                            <i class="feather icon-edit"></i> Edit
                                                        </a>
                                                    @endif
                                                    {{-- delete --}}
                                                    @if (check_permission('product.destroy'))
                                                        @if ($count_inv<1 && $count_pur<1)
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#deleteModal-{{ $data->id }}"
                                                                class="dropdown-item text-danger {{ $data->id == 1 ? 'disabled' : '' }}">
                                                                <i class="feather icon-trash"></i> Delete
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- delete modal --}}
                                    <form action="{{ route('product.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        <x-delete-modal title="Product" id="{{ $data->id }}" />
                                    </form>

                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center no_data_style text-danger">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $products->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bar_code_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" id="barcode-page">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success delete" onclick="print_barcode()"><i class="fa fa-print"></i>
                        Print</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    function setFilterType($this) {
        var filterType = $($this).val();
        $('.generated_barcode').attr('data-size', filterType);
    }

    $(document).on('click', '#modal_cancel', function() {
        $("#bar_code_modal").modal('hide');
        $('.generated_barcode').attr('data-size', '');
    });

    $(document).on('click', '.generated_barcode', function() {
        let name = $(this).attr('data-name');
        let code = $(this).attr('data-code');
        let price = $(this).attr('data-price');
        var variation = $(this).attr('data-size');
        let pro_barcode = "{{ get_setting('pro_barcode') }}";

        // Convert price to formatted string with commas and decimals
        const formattedPrice = new Intl.NumberFormat('en-US', {
            useGrouping: true,
            // style: 'currency',
            // currency: 'USD', // Change to your desired currency if needed
            minimumFractionDigits: 2
        }).format(price);

        let url = "{{ route('product-barcode', 'value') }}".replace('value', code);

        $.get(url, (data) => {
            let company = "{{ $com->value }}";
            let vat = "{{ $vat->value }}";
            if(vat == 1){
                vat_status = " + Including VAT";
            }else{
                vat_status = " ";
            }

            let barcode = '';
            if (pro_barcode == 'a4') {
                barcode += `<div class="text-center p-4 print_area" id="barcode">
                    <table class="table table-bordered">`;
                        for (let i = 0; i < 10; i++) {
                            barcode += `<tr>`;
                            for (let j = 0; j < 3; j++) {
                                barcode +=
                                `<td>
                                    <p style="margin-bottom:2px; line-height:9px; margin-top:5px; font-size: 15px; color:black;text-transform:uppercase;!important"><strong>${company}</strong></p>
                                    ${data}
                                    <p style="margin-bottom:2px; line-height:9px; margin-top:3px; font-size: 9px; color:black;"><strong>${name}</strong></p>
                                    <p style="margin-bottom:2px; line-height:9px; margin-top:3px; font-size: 9px; color:black;"><strong> Price: ${formattedPrice} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></p>
                                </td>`;
                            }
                            barcode += `</tr>`;
                        }
                    barcode += `
                    </table>
                </div>`;
            } else if (pro_barcode == 'single') {
                barcode += `<div class="text-center p-4 print_area" id="barcode" style="padding:0 !important">
                    <table class="table" style="margin-bottom:0 !important;">
                        <tr>
                            <td style="border-top:0 !important;padding:0;">
                            <p style="font-family: Arial, sans-serif;line-height:9px;margin-bottom:2px; font-size: 13px;margin-top:12px; font-weight: 500; text-transform: uppercase;  color: black;"><strong>${company}</strong></p>
                            ${data}
                            <p style="margin-bottom:0px; line-height:9px; margin-top:2px; font-size: 6px; color:black;"><strong>${code}</strong></p>
                            <p style="margin-bottom:2px; line-height:9px; margin-top:0px; font-size: 9px; color:black;"><strong>${name}</strong></p>
                            <p style="margin-bottom:2px; line-height:9px; margin-top:5px; font-size: 12px; color:black;"><strong><span style="font-size: 8px; color:black;">{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }} </span> ${formattedPrice}<span style="font-size: 8px; color:black;"> ${vat_status}</span></strong></p>
                            </td>
                        </tr>
                    </table>
                </div>`;
            }
            $("#barcode-page").html(barcode);
        });
        $("#bar_code_modal").modal('show');
    });
</script>


    <script>
        //  Print Barcode
        //  Print Barcode
        function print_barcode(id) {
            $("#bar_code_modal").modal('hide');
            $(".modal-backdrop").remove();
            $(".modal").css('display', 'none');

            let mainDocBody = $('.main-container').html();
            let printDoc = $("#barcode-page").html();
            $(".main-container").html(printDoc);
            $("body").attr('style', '');
            window.print();
            window.location.reload();
            $(".main-container").html(mainDocBody);
    }
    </script>
@endpush
