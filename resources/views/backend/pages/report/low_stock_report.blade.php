@extends('backend.layouts.master')
@section('section-title', 'Stock')
@section('page-title', 'Product Stock')
{{-- @section('action-button')
    <a href="" class="btn btn-primary " onclick="window.print()">Print</a>
@endsection --}}
@push('css')
<style>
    @media print{
        table,table th,table td {
            color:black !important;
        }

        .h-hide {
            display: none;
        }
    }
</style>
@endpush
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card card_style m-b-30">
                <div class="card-header ">
                    
                    @php
                        $brands = App\Models\Brand::get();
                        $categories = App\Models\Category::get();
                        $produc = App\Models\Product::get();
                    @endphp
                    <form action="{{ route('report.low.stock') }}" method="GET">
                        <div class="row h-hide">

                            <div class="col-md-3 mt-3">
                                <input type="text" class="form-control" id="search_keyword" name="search_keyword" value="{{ $keyword }}" placeholder="Barcode or Product Name">
                            </div>  
                            <div class="col-md-3 mt-3">
                                <select class="select2" name="product_id" id="product_id" data-provide="selectpicker"
                                data-live-search="true" data-size="10">
                                    <option value="">Select Product</option>
                                    @foreach ($produc as $product)
                                        <option value="{{ $product->id }}" 
                                            {{ $product_id == $product->id ? 'SELECTED' : '' }} >
                                            {{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3 mt-3">
                                <select name="category_id" id="category_id" class="select2" data-provide="selectpicker"
                                data-live-search="true" data-size="10">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category_id == $category->id ? 'SELECTED' : '' }}
                                            >{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-3">
                                <select name="brand_id" id="brand_id" class="select2" data-provide="selectpicker"
                                data-live-search="true" data-size="10">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $brand_id == $brand->id ? 'SELECTED' : '' }}
                                            >{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 h-hide">
                            <div class="col-md-12 col-12 d-flex justify-content-center">
                                <a href="{{ route('report.stock') }}" class="btn btn-md mx-1 text-light add_list_btn_reset" id="">Reset</a>
                                <button type="submit" class="btn btn-md add_list_btn mx-1">Filter</button>
                                <a href="" class="btn add_list_btn " onclick="window.print()">Print</a>
                            </div>
                        </div>
                    </form>
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <h4 style="text-align: center; font-weight:bold; margin-top:5px;font-size:30px">Low Stock Report</h4>
                        <table id="alltableinfo" class="table table-striped text-center">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">#SL</th>
                                    <th style="width: 25%">Product</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th class="header_style_right">Available Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sl = 1; // Initialize the serial number
                                @endphp
                                @forelse($products as $key => $data)
                                    @php
                                        $stock_qty = product_stock($data);
                                        $stock = product_stock_check($data) * $data->purchase_price;
                                    @endphp
                                    @if($data->unit->related_unit_id == null)
                                        @if($stock_qty < $data->main_qty )
                                            <tr>
                                                <td class="table_data_style_left"> 
                                                    {{ $sl++ }}
                                                </td>
                                                <td>{{ $data->name }} - {{ $data->barcode }}</td>
                                                <td>{{ $data->category->name }}</td>
                                                <td>{{ ($data->brand_id==NULL)?"No Brand":$data->brand->name }}</td>
                                                <td class="table_data_style_right">{{ $stock_qty }}</td> <!-- Shows the stock quantity -->
                                            </tr>
                                        @endif
                                    @else
                                        @if($stock_qty < $data->main_qty )
                                            <tr>
                                                <td class="table_data_style_left"> {{ $sl++ }}</td>
                                                <td>{{ $data->name }} - {{ $data->barcode }}</td>
                                                <td>{{ $data->category->name }}</td>
                                                <td>{{ ($data->brand_id==NULL)?"No Brand":$data->brand->name }}</td>
                                                <td class="table_data_style_right">{{ $stock_qty }}</td> <!-- Shows the stock quantity -->
                                            </tr>
                                        @endif
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center text-danger no_data_style">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // $(doucment).ready(function(){
            $('#resetBtn').click(function(){
                $("#product_id option:first").prop("selected", true).change();
                $("#category_id option:first").prop("selected", true).change();
                $("#brand_id option:first").prop("selected", true).change();
                $("#search_keyword").val('');
            });
        // });
    </script>
@endsection
