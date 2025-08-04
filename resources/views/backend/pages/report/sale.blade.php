@extends('backend.layouts.master')
@section('section-title', 'Report')
@section('page-title', 'Sale Report')

@push('css')
<style>
    @media print{
        table,table th,table td {
            color:black !important;
        }

        #h-hide {
            display: none;
        }
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body card_style mb-2" style="margin-top: -5px;" id="h-hide">
                <form action="{{ route('report.sale') }}">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <select class="select2" name="category_id">
                                <option selected value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <select class="select2" name="product_id">
                                <option selected value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" @isset($oneProduct) @if($product->id == $oneProduct->id) selected @endif @endisset>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="date" name="start_date" class="form-control" value="{{ (isset($sdate))?date('Y-m-d', strtotime($sdate)):''; }}">
                        </div>
                        <div class="form-group col-md-4">
                            <input type="date" name="end_date" class="form-control" value="{{ (isset($edate))?date('Y-m-d', strtotime($edate)):''; }}">
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="form-group col-12">
                            <button class="btn add_list_btn" type="submit">
                                    <i class="fa fa-sliders"></i> Filter
                            </button>
                            <a href="{{ route('report.sale') }}" class="btn add_list_btn_reset">Reset</a>
                            <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card m-b-30 print_area card_style">
                <div class="card-header">
                    <h4 style="text-align: center; font-weight:bold; margin-top:25px;font-size:30px">Sale Report ({{ (isset($sdate))?date('m-d-Y', strtotime($sdate)):''; }} - {{ (isset($edate))?date('m-d-Y', strtotime($edate)):''; }})</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (isset($invoiceItem))
                        <table class="table">
                        <thead>
                            <tr class="header_bg">
                                <th class="header_style_left">SL.</th>
                                <th>Date</th>
                                <th>Invoice No</th>
                                <th>Product</th>
                                <th>Product Category</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Sub Total</th>
                                <th>Discount</th>
                                <th class="header_style_right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sub_total = 0;
                            @endphp
                            @forelse($invoiceItem as $key => $data)
                            @php
                                $items = App\Models\InvoiceItem::where('invoice_id',$data->id)->get();
                                // if ($data->product->unit->related_unit  == null) {
                                //     $main_qty = $data->main_qty;
                                //     $qty = $main_qty.' '.$data->product->unit->name;
                                // } else {
                                //     //purchase
                                //     $main_qty = $data->main_qty;
                                //     $pur_total_main = (float)($main_qty*$data->product->unit->related_value);
                                //     $sub_qty = $data->sub_qty;
                                //     $pur_total_qty = (float)($pur_total_main+$sub_qty);
                                //     $total_qty = $pur_total_qty;
                                //     $check = $total_qty/$data->product->unit->related_value;
                                //     if (is_integer($check)) {
                                //         $data['stock_qty'] = $check.' '.$data->product->unit->name.' 0 '.$data->product->unit->related_unit->name;
                                //     } else {
                                //         $main_value = floor($check)*$data->product->unit->related_value;
                                //         $sub_value = $total_qty-$main_value;
                                //         $qty = floor($check).' '.$data->product->unit->name.' '.$sub_value.' '.$data->product->unit->related_unit->name;
                                //     }
                                // }
                                $sub_total += $data->total_amount;
                                // dd($sub_total)
                            @endphp
                            <tr>
                                <td class="table_data_style_left">{{ $key+1 }}</td>
                                <td>{{ date('m-d-Y', strtotime($data->date)) }}</td>
                                <td>{{ $data->invoice_no }}</td>
                                <td>
                                    @foreach ($items as $item)
                                        <ul>
                                            <li>{{ $item->product?->name }}</li>
                                        </ul>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($items as $item)
                                        <ul>
                                            <li>{{ $item->product?->category?->name }}</li>
                                        </ul>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($items as $item)
                                        @if($item->product->unit?->related_unit == null)
                                        <ul>
                                            <li>{{ $item->main_qty.' '.$item->product->unit?->name }}</li>
                                        </ul>
                                        @else
                                        <ul>
                                            <li>{{ $item->main_qty.' '.$item->product->unit->name .' '. $item->sub_qty.' '.$item->product->unit->related_unit->name }}</li>
                                        </ul>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($items as $item)
                                        <ul>
                                            <li>{{ $item->rate }}</li>
                                        </ul>
                                    @endforeach
                                </td>
                                <td>{{ number_format($data->estimated_amount, 2) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                <td>{{ number_format($data->discount_amount, 2) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                <td class="table_data_style_right">{{ number_format($data->total_amount, 2) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-danger no_data_style">No Data Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfooter>
                            <tr class="header_bg" style="font-size: 20px; font-width: 700; font-family:sans-serif">
                                <td class="header_style_left" colspan="6"></td>
                                <td colspan="2"> <strong class="text-white"> Total Price: </strong></td>
                                <td class="header_style_right text-white" colspan="2"><strong> {{number_format($sub_total,2)}} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }} </strong></td>
                            </tr>
                        </tfooter>
                        </table>
                        @else
                        <div class="col-md-12" style="padding-bottom: 30px;">
                            <div class="alert alert-danger text-center" role="alert"> Please Select Start and End Month</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
