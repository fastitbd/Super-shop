@extends('backend.layouts.master')
@section('page-title', 'Invoice Print')
@push('css')
    <style rel="stylesheet">
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature p {
            margin-top: -10px;
        }
        .order-details th {
            font-weight: bold;
        }
        strong {
            font-weight: 800;
        }
        address {
            margin-bottom: 0px;
        }
        .invoice-header {
            width: 100%;
            display: block;
            box-sizing: border-box;
            overflow: hidden;
            border-bottom: 1px dashed rgb(8, 8, 8);
            margin-bottom: 10px;
        }
        .invoice-header address {
            width: 100%;
            text-align: center;
            padding: 5px;
        }
        .logo-area img {
            width: 40%;
            display: inline;
            /*float: left;*/
        }
        .logo-area h1 {
            display: inline;
            float: left;
            font-size: 17px;
            padding-left: 8px;
        }
        .logo-area h4 {
            font-weight: bold;
            font-size: 26px;
        }
        .invoice-header .logo-area {
            width: 100%;
            text-align: center;
            /*padding: 5px;*/
        }
        .bill-date {
            width: 100%;
            overflow: hidden;
            padding: 0 15px;
        }
        .date {
            width: 50%;
            float: right;
            text-align: end;
        }

        .bill-no {
            width: 50%;
            float: left;
        }

        .name,
        .address,
        .saler,
        .time,
        .mobile-no,
        .cus_info {
            width: 100%;
            /* border-left: 1px solid #ccc; */
            /* border-bottom: 1px solid #ccc; */
            /* border-right: 1px solid #ccc; */
            padding: 0 15px;
        }

        .name span,
        .address span,
        .mobile-no span,
        .cus_info span,
        .saler span,
        .time span {
            padding-left: 5px;
            font-weight: 800;
        }

        .sign {
            width: 250px;
            border-top: 1px solid #000;
            float: right;
            margin: 40px 20px 0 0;
            text-align: center;
        }

        .table-bordered {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            border-left: 0px;
            border-right: 0px;
        }

        .table-bordered td,
        .table-bordered th {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            border-left: 0px;
            border-right: 0px;
        }

        .table tbody th {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            border-left: 0px;
            border-right: 0px;
        }

        @media print {
            body * {
                visibility: visible;
                color: #000 !important;
                font-size: 10px !important;
                line-height: 12px;
                font-weight: 800 !important;
            }

            .table-rheader td {
                border-top: 0px;
                padding: 5px !important;
                vertical-align: baseline !important;
            }

            .table-plist td {
                padding: 5px !important;
                text-align: left !important;
                width: 300px !important;
            }

            .table-plist th {
                padding: 5px;
                text-align: left !important;
                width: 300px !important;
            }

            .border-bottom {
                /* border-bottom: 1px dotted #CCC; */
            }

            .print {
                margin-bottom: 0;
            }

            .customers,
            .authorized {
                line-height: 2;
                margin-top: 15px;
            }

            .table-bordered {
                border-top: 1px dashed #000 !important;
                border-bottom: 1px dashed #000 !important;
                border-left: 0px !important;
                border-right: 0px !important;
            }

            .table-bordered td,
            .table-bordered th {
                border-top: 1px dashed #000 !important;
                border-bottom: 1px dashed #000 !important;
                border-left: 0px !important;
                border-right: 0px !important;
            }

            .table tbody th {
                border-top: 1px dashed #000 !important;
                border-bottom: 1px dashed #000 !important;
                border-left: 0px !important;
                border-right: 0px !important;
            }

            .lead {
                margin-top: -43px !important;
                line-height: 2;
            }

        }

        .bill-no,
        .date,
        .saler,
        .time,
        .name,
        .mobile-no,
        .address,
        th,
        td,
        address,
        h4 {
            color: black;
        }

        .saler {
            float: left;
            width: 50%;
        }

        .time {
            float: right;
            text-align: end;
            width: 50%;
        }

        .invoice-contentbar {
            margin: 60px 5px 0 5px;
            padding: 20px;
            margin-bottom: 60px;
            font-family: 'Petrona', serif;
        }

        .table-bordered td.rm-b-t {
            border-top: 1px solid transparent !important;
        }

        .table-bordered td.rm-b-b {
            border-bottom: 1px solid transparent !important;
        }

        .table-bordered td.rm-b-l {
            border-left: 1px solid transparent !important;
        }

        .table-bordered td.rm-b-r {
            border-right: 1px solid transparent !important;
        }
    </style>
    <style>
        .table-rheader td {
            border-top: 0px;
            padding: 5px;
            vertical-align: baseline !important;
        }

        .table-plist td {
            padding: 5px;
            text-align: center !important;
        }

        .table-plist th {
            padding: 5px;
            text-align: center;
            /* background: #ddd; */
        }

        .border-bottom {
            border-bottom: 1px dotted #CCC;
        }
    </style>
@endpush
@section('invoice')
    <div class="invoice-contentbar">
        <div class="row">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-md-7 card card-body print">
                        <div id="print-area">
                            <div class="invoice-header">
                                <div class="logo-area">
                                    @if (get_setting('inv_logo') == 'logo')
                                        <img src="{{ !empty(get_setting('system_logo')) ? url('public/uploads/logo/' . get_setting('system_logo')) : url('public/backend/images/logo.png') }}" style="width: 150px; height: 50px;"
                                            alt="logo">
                                    @elseif (get_setting('inv_logo') == 'name')
                                        <h2 style="font-weight: bold; margin-bottom:0">
                                            {{ empty(get_setting('com_name')) ? '----' : get_setting('com_name') }}</h2>
                                    @else
                                        <img src="{{ !empty(get_setting('system_logo')) ? url('public/uploads/logo/' . get_setting('system_logo')) : url('public/backend/images/logo.png') }}" style="width: 150px; height: 50px;"
                                            alt="logo">
                                        <h2 style="font-weight: bold; margin-bottom:0">
                                            {{ empty(get_setting('com_name')) ? '----' : get_setting('com_name') }}</h2>
                                    @endif
                                </div>
                                <address> Address :
                                    <strong>{{ empty(get_setting('com_phone')) ? '----' : get_setting('com_address') }}</strong>
                                    <br> Phone :
                                    <strong>{{ empty(get_setting('com_phone')) ? '----' : get_setting('com_phone') }}</strong>
                                    <br> Email :
                                    <strong>{{ empty(get_setting('com_email')) ? '----' : get_setting('com_email') }}</strong>
                                    <br>
                                </address>
                            </div>
                            <div class="bill-date">
                                <div class="bill-no"> {{ $invoice->invoice_no }} </div>
                                <div class="date"> Date: <strong>{{ date('d-M-Y', strtotime($invoice->date)) }}</strong>
                                </div>
                            </div>
                            <div class="name"> Name : <span>{{ $invoice->customer->name }}</span>
                            </div>
                            <div class="address"> Address : <span>{{ $invoice->customer->address }}</span>
                            </div>
                            <div class="mobile-no"> Mobile : <span>{{ $invoice->customer->phone }}</span>
                            </div>
                            <table class="table table-bordered table-plist my-3 order-details">
                                <tr>
                                    <th>#SL</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total A.</th>
                                </tr>
                                @foreach ($invoice->invoiceItems as $key => $item)
                                    @php
                                        $product = App\Models\Product::where('id', $item->product_id)
                                            ->with('unit.related_unit')
                                            ->first();
                                        if($product->is_service == 0){
                                            if ($product->unit->related_unit == null) {
                                            $qty = $item->main_qty . ' ' . $product->unit->name;
                                            } else {
                                                $sub_qty = $item->sub_qty == null ? 0 : $item->sub_qty;
                                                $qty =
                                                    $item->main_qty .
                                                    ' ' .
                                                    $product->unit->name .
                                                    ' ' .
                                                    $sub_qty .
                                                    ' ' .
                                                    $product->unit->related_unit->name;
                                            }
                                        }else{
                                            $qty = $item->main_qty . ' ' . $product->unit->name;
                                        }
                                        
                                        $serial = App\Models\SaleSerialNumber::where('invoice_id',$invoice->id)->where('product_id',$product->id)->first();
                                        // dd($serial);
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td style="width: 30%">
                                            {{ $item->product->name }} <br> 
                                            @if($serial)
                                            IMEI: {{ $serial?->serial }} <br>
                                            @endif
                                            Warranty: {{ $item->warranty }} <br>
                                            {{ $item->new_details }}
                                        </td>
                                        <td><small>{{ $qty }}</small></td>
                                        <td>{{ $item->rate }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td>{{ $item->subtotal }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="rm-b-l rm-b-t rm-b-b"></td>
                                    <td class="text-right">Sub Total : </td>
                                    <td>
                                        <strong>{{ $invoice->estimated_amount }} </strong>{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="rm-b-l rm-b-t rm-b-b"></td>
                                    <td class="text-right">Discount : </td>
                                    <td>
                                        @if(gettype($invoice->discount)=== 'string')
                                        <strong> {{ $invoice->discount }}</strong>
                                        @else
                                        <strong> {{ $invoice->discount }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="rm-b-l rm-b-t rm-b-b"></td>
                                    <td class="text-right">Grand Total : </td>
                                    <td>
                                        <strong>{{ $invoice->total_amount }} </strong>{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="rm-b-l rm-b-t rm-b-b"></td>
                                    <td class="text-right">Total Paid : </td>
                                    <td>
                                        <strong>{{ $invoice->total_paid }} </strong>{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}
                                    </td>
                                </tr>
                                @if($invoice->total_due > 0)
                                <tr>
                                    <td colspan="3" class="rm-b-l rm-b-t rm-b-b"></td>
                                    <td class="text-right">Total Due : </td>
                                    <td>
                                        <strong>{{ $invoice->total_due }} </strong>{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}
                                    </td>
                                </tr>
                                @endif
                            </table>
                            <p class="mt-5">NOTE: {{ $invoice->note }}</p>
                            <h6 class="mt-5 text-center">Thank you for Shopping at {{ empty(get_setting('com_name')) ? '----' : get_setting('com_name') }}</h6>
                            <h6 class="text-center">Developed By Fast iT Ltd <br>
                                <span> Call: 01784-159071</span>
                            </h6>
                        </div>
                        <hr>
                        <button class="btn btn-secondary btn-block print_hidden" onclick="print_receipt('print-area')"> <i
                                class="fa fa-print"></i> Print </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // clear localstore
        localStorage.removeItem('pos-items');

        function print_receipt(divName) {
            let printDoc = $('#' + divName).html();
            let originalContents = $('body').html();
            $("body").html(printDoc);
            window.print();
            $('body').html(originalContents);
        }
    </script>
@endpush
