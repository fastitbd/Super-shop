@extends('backend.layouts.master')
@section('section-title', 'Stock')
@section('page-title', 'Product Stock')
@section('action-button')
    <a href="" class="btn add_list_btn " onclick="window.print()">Print</a>
@endsection
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
            <div class="card m-b-30 card_style">
                <div class="card-header ">
                    <h4  style="text-align: center; font-weight:bold; margin-top:5px;font-size:30px">Stock Report</h4>
                    @php
                        $brands = App\Models\Brand::get();
                        $categories = App\Models\Category::get();
                        $produc = App\Models\Product::get();
                    @endphp
                    <form action="{{ route('report.stock') }}" method="GET">
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
                                    <th style="width: 20%">Product</th>
                                    <th>Category</th>
                                    <th>Stock In</th>
                                    <th>Stock Out</th>
                                    <th>Sale Return</th>
                                    <th>Purchase Return</th>
                                    <th>Damage</th>
                                    <th>Available Stock</th>
                                    <th class="header_style_right">Serial Number</th>
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
                                        $return_pur_qty = return_pur_qty($data);
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }} - {{ $data->barcode }}</td>
                                        <td>{{ $data->category?->name }}</td>
                                        <td>{{ $purchased_qty }}</td>
                                        <td>{{ $invoiced_qty }}</td>
                                        <td>{{ $returned_qty }}</td>
                                        <td>{{ $return_pur_qty }}</td>
                                        <td>{{ $damaged_qty }}</td>
                                        <td>{{ $stock_qty }}</td>
                                        <td class="table_data_style_right">
                                            @if($data->has_serial == 1)
                                            @php
                                                $has = App\Models\Product::where('has_serial',1)->where('id',$data->id)->first();
                                                $serials = App\Models\SerialNumber::where('product_id',$data->id)->where('status',1)->get();
                                                
                                            @endphp
                                            @foreach ($serials as $serial)
                                                {{-- @dd($serial)     --}}
                                                <ul>
                                                    <li>{{ $serial->serial }}</li>
                                                </ul>
                                            @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center no_data_style text-danger">No Data Available</td>
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
            $('#resetBtn').click(function(){
                $("#product_id option:first").prop("selected", true).change();
                $("#category_id option:first").prop("selected", true).change();
                $("#brand_id option:first").prop("selected", true).change();
                $("#search_keyword").val('');
            });
        // });
    </script>
@endsection
