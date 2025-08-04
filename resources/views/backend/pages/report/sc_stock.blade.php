@extends('backend.layouts.master')
@section('section-title', 'Stock')
@section('page-title', 'Product Stock')
@section('action-button')
    <a href="" class="btn add_list_btn " onclick="window.print()">Print</a>
@endsection
@push('css')
    <style>
        @media print {

            table,
            table th,
            table td {
                color: black !important;
            }

            .h-hide {
                display: none;
            }
        }


        table .table_vari_bg tr{
            background: #000ce2 !important;
            color: rgb(255, 255, 255);
            font-weight: 800;
        }
        th, td {
            /* border: 1px solid black; Border for table cells */
            /* padding: 10px; */
            /* text-align: center; */
        }
    </style>

<style>
    /* Style for the main table rows (striped) */
    .table-striped tbody tr:nth-child(odd) {
        background-color: #dcdcdc; /* Light gray for odd rows */
    }
    .table-striped tbody tr:nth-child(even) {
        background-color: #ffffff; /* White for even rows */
    }

    /* Style for the nested variation table */
    .table-striped tbody tr:nth-child(odd) table tbody tr {
        background-color: #dcdcdc; /* Match odd row color */
    }
    .table-striped tbody tr:nth-child(even) table tbody tr {
        background-color: #ffffff; /* Match even row color */
    }

    /* Optional: Add borders to differentiate nested table */
    .table-striped table {
        width: 100%;
        border: 1px solid #ddd;
    }
    .table-striped table th,
    .table-striped table td {
        padding: 5px;
        text-align: left;
    }
</style>

@endpush
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-header ">
                    <h4 style="text-align: center; font-weight:bold; margin-top:5px;font-size:30px"><strong>Stock Report</strong></h4>
                    @php
                        $brands = App\Models\Brand::get();
                        $categories = App\Models\Category::get();
                        $produc = App\Models\Product::get();
                    @endphp
                    <form action="{{ route('report.stock') }}" method="GET">
                        <div class="row h-hide">
                            <div class="col-md-3 mt-3">
                                <input type="text" class="form-control" id="search_keyword" name="search_keyword"
                                    value="{{ $keyword }}" placeholder="Barcode or Product Name">
                            </div>
                            <div class="col-md-3 mt-3">
                                <select class="select2" name="product_id" id="product_id" data-provide="selectpicker"
                                    data-live-search="true" data-size="10">
                                    <option value="">Select Product</option>
                                    @foreach ($produc as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $product_id == $product->id ? 'SELECTED' : '' }}>
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
                                            {{ $category_id == $category->id ? 'SELECTED' : '' }}>{{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-3">
                                <select name="brand_id" id="brand_id" class="select2" data-provide="selectpicker"
                                    data-live-search="true" data-size="10">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $brand_id == $brand->id ? 'SELECTED' : '' }}>
                                            {{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 h-hide">
                            <div class="col-md-12 col-12 d-flex justify-content-center">
                                <a href="{{ route('report.stock') }}" class="btn btn-md mx-1 text-white add_list_btn_reset"
                                    id="">Reset</a>
                                <button type="submit" class="btn btn-md add_list_btn mx-1">Filter</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped text-center">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">#SL</th>
                                    <th style="width: 25%">Product</th>
                                    <th>Category</th>
                                    <th>Stock In</th>
                                    <th>Stock Out</th>
                                    <th>Return</th>
                                    <th>Damage</th>
                                    <th class="header_style_right">Available Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $data)
                                    @php
                                        $purchased_qty = purchased_qty($data);
                                        $invoiced_qty = invoiced_qty($data);
                                        $stock_qty = product_stock($data);
                                        $returned_qty = returned_qty($data);
                                        $damaged_qty = damaged_qty($data);
                                        
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }} - {{ $data->barcode }}</td>
                                        <td>{{ $data->category?->name }}</td>
                                        <td>{{ $purchased_qty }}</td>
                                        <td>{{ $invoiced_qty }}</td>
                                        <td>{{ $returned_qty }}</td>
                                        <td>{{ $damaged_qty }}</td>
                                        <td class="table_data_style_right">
                                            {{-- @dd($data->); --}}
                                            
                                            @if ($data->product_variations->count() > 0)
                                            
                                                <table>
                                                    <thead class="table_vari_bg">
                                                        <tr>
                                                            <th class="table_data_style_left">Variation</th>
                                                            <th class="table_data_style_right">Stock</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $var_total = 0;
                                                        @endphp
                                                        @foreach ($data->product_variations as $variation)
                                                        @php
                                                            $var_total += variation_stock($variation->id) ;
                                                        @endphp
                                                            <tr>
                                                                <td class="table_data_style_left">{{ $variation->size?->size }} - {{ $variation->color?->color }}</td>
                                                                <td class="table_data_style_right">
                                                                    {{ variation_stock($variation->id) }} Pics
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td>Total Qty =</td>
                                                            <td>{{ $var_total }} Pics</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            @else
                                                {{ $stock_qty }}
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center text-danger no_data_style">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination justify-content-center">
                        {{ $products->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // $(doucment).ready(function(){
        $('#resetBtn').click(function() {
            $("#product_id option:first").prop("selected", true).change();
            $("#category_id option:first").prop("selected", true).change();
            $("#brand_id option:first").prop("selected", true).change();
            $("#search_keyword").val('');
        });
        // });
    </script>
@endsection
