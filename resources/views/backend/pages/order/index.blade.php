@extends('backend.layouts.master')
@section('section-title', 'Invoice')
@section('page-title', 'Invoice List')
@if (check_permission('invoice.create'))
    @section('action-button')
        <a href="{{ route('invoice.create') }}" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Invoice
        </a>
    @endsection
@endif
@push('css')
    <style>
        @media print {
            body {
                margin: 0;
            }

            #printableArea {
                width: 75mm;
                height: 100mm;
                border: 1px solid black;
                /* Ensure border is visible when printing */
                padding: 10mm;
                box-sizing: border-box;
            }
        }


        .dropdown-menu {
            position: absolute !important;
            z-index: 9999;
        }

        .parent-container {
            overflow: visible !important;
        }
    </style>

    <style>
        @media print {
            body {
                font-size: 14px !important;
            }

            .container {
                width: 100% !important;
            }

            /* প্রতিটি ইনভয়েস নতুন পৃষ্ঠায় থাকবে */
            .print_part2 {
                page-break-before: always;
            }

            /* Modal প্রিন্ট হওয়ার সময় লুকাবে */
            .modal,
            .modal-backdrop {
                display: none !important;
            }

            /* টেবিল ও এলিমেন্ট কাটা পড়া ঠেকাতে */
            .list-item {
                page-break-inside: avoid;
            }

            /* লোগোর আকার ঠিক করা */
            .logo_part img {
                max-width: 100px !important;
                height: auto !important;
            }
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <form action="{{ route('online.orderlist') }}" method="GET">
                        @php
                            $customers = App\Models\Customer::get();
                            $products = App\Models\Product::select('id', 'name', 'barcode')->get();
                        @endphp
                        <div class="row h-hide">
                            <div class="col-md-3 col-12 mt-3">
                                <input type="date" class="form-control" name="startDate" value="{{ $startDate }}" />
                            </div>
                            <div class="col-md-3 col-12 mt-3">
                                <input type="date" class="form-control" name="endDate" value="{{ $endDate }}" />
                            </div>
                            <div class="col-md-3 col-12 mt-3">
                                <input type="text" placeholder="Enter Invoice No" name="invoice_no"
                                    value="{{ $invoice_no }}" class="form-control">
                            </div>
                            <div class="col-md-3 col-12 mt-3">
                                <select name="product_id" id="" class="select2">
                                    <option value="">Select Product</option>
                                    @foreach ($products as $item)
                                        <option value="{{ $item->id }}" {{ $product_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-12 mt-3">
                                <select name="customer_id" id="" class="select2">
                                    <option value="">Select Customer</option>
                                    @foreach ($customers as $item)
                                        <option value="{{ $item->id }}" {{ $customer_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }} {{ $item->phone }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-12 mt-3">
                                <select name="courier" id="" class="select2">
                                    <option value="">Select Courier</option>
                                    <option value="Pathao">Pathao</option>
                                    <option value="Stead Fast">Stead Fast</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 h-hide d-flex justify-content-between">
                            <div class="col-md-12">
                                <button type="submit" class="btn add_list_btn">Filter</button>
                                <a href="{{ route('online.orderlist') }}" class="btn add_list_btn_reset">Reset</a>
                                <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                            </div>
                        </div>
                    </form>
                    <button type="button" class="btn btn-primary mt-3" onclick="printSelectedInvoices()">Print
                        Label</button>
                    <!-- <button type="button" class="btn btn-primary mt-3" id="acceptBtn">
                            Accept
                        </button> -->

                 <button type="button" id="acceptBtn" class="btn btn-primary mt-3"> Accept Order </button>
                    <button type="button" class="btn btn-primary mt-3" onclick="">
                        Cancel
                    </button>

                    <div class="table-responsive mt-2">
                       
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead class="header_bg">
                                    <tr class="text-center">
                                        <th class="header_style_left"><input type="checkbox" id="selectAll"></th>
                                        <th> #SL </th>
                                        <th> Date </th>
                                        <th> Invoice No </th>
                                        <th> Customer </th>
                                        <th> Product Item(s) </th>
                                        <th> Delivery Charge </th>
                                        <th> Total Amount </th>
                                        <th> Total Paid </th>
                                        <th> Total Due </th>
                                        <th> Courier </th>
                                        <th> Status </th>
                                        <th> Create By </th>
                                        <th class="header_style_right"> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_paid = 0;
                                        $total_amt = 0;
                                        $total_due = 0;
                                    @endphp
                                    @forelse($invoices as $key => $data)
                                        @php
                                            $total_paid += $data->total_paid;
                                            $total_amt += $data->total_amount;
                                            $total_due += $data->total_due;
                                            $inv_items = App\Models\InvoiceItem::where('invoice_id', $data->id)->get();
                                            // $status=Enan\PathaoCourier\Facades\PathaoCourier::VIEW_ORDER($data->consignment_id)['data'];
                                        @endphp

                                        <tr class="text-center">
                                            <td class="table_data_style_left">
                                                <input type="checkbox" class="invoiceCheckbox"
                                                    name="seletedRows[{{ $data->id }}]" value="{{ $data->id }}">

                                            </td>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->date }}</td>
                                            <td>{{ $data->invoice_no }}</td>
                                            <td>{{ $data->customer?->name }} - {{ $data->customer?->phone }}</td>
                                            <td>
                                                @foreach ($inv_items as $item)
                                                    <ul>
                                                        <li>
                                                            @if ($data->status == 2)
                                                                {{ $item->product?->name }} @if (env('APP_SC') == 'yes')
                                                                    ({{ $item->product_variation?->size?->size }}-{{ $item->product_variation?->color?->color }})
                                                                @endif
                                                            @else
                                                                {{ $item->product?->name }} 
                                                                @if ($item->is_return == 1)
                                                                    <span class="badge bg-danger">Return</span>
                                                                @endif 
                                                                @if (env('APP_SC') == 'yes')
                                                                    (qty:{{ $item->main_qty }})
                                                                  
                                                                @endif
                                                            @endif
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            </td>
                                            <td>{{ $data->delivery_charge }}</td>
                                            <td>{{ $data->total_amount }}</td>
                                            <td>{{ $data->total_paid }}</td>
                                            <td>{{ $data->total_due }}</td>
                                            <td>
                                                {{ $data->courier_type }}
                                            </td>
                                            <td>
                                                @if ($data->consignment_id != null)
                                                    @if ($data->courier_type == 'Stead Fast')
                                                        {{ status($data->consignment_id)['delivery_status'] }}
                                                    @elseif($data->courier_type == 'Pathao')
                                                        @php
                                                            $token = env('PATHAO_SECRET_TOKEN');
                                                            $orderSummary = getOrderSummary(
                                                                $data->consignment_id,
                                                                $token,
                                                            );
                                                        @endphp
                                                        {{ $orderSummary['data']['order_status'] }}
                                                    @endif
                                                @else
                                                    {{ $data->order_status }}
                                                @endif
                                            </td>
                                            <td>{{ $data->user->name }}</td>
                                            <td class="table_data_style_right">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        {{-- pay button --}}
                                                        @if (check_permission('invoice.pay'))
                                                            @if ($data->total_due > 0)
                                                                <a class="dropdown-item" href="{{ url('invoice/pay/' . $data->id) }}"
                                                                    class="btn btn-success-rgba">
                                                                    <i class="feather icon-dollar-sign"></i> Due
                                                                </a>
                                                            @endif
                                                        @endif
                                                  
                                                            <a class="dropdown-item"
                                                                href="{{ route('invoice.print', $data->id) }}"
                                                                class="btn btn-success-rgba">
                                                                <i class="feather icon-printer"></i> Print
                                                            </a>
                                               
                                                            @php
                                                                $return_tbl = App\Models\ReturnTbl::where(
                                                                    'invoice_id',
                                                                    $data->id,
                                                                )->first();
                                                                $del_invoice = App\Models\Invoice::where('id', $data->id)
                                                                    ->latest()
                                                                    ->first();
                                                                // dd($del_invoice->id);
                                                            @endphp

                                              
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                           
                                        {{-- delete modal --}}
                                        <form action="{{ route('invoice.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-delete-modal title="Invoice" id="{{ $data->id }}" />
                                        </form>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center text-danger no_data_style">No Invoice Found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="text-right header_bg">
                                        <td colspan="7" class="header_style_left text-white "><strong>Total: </strong></td>
                                        <td> <strong class="text-white ">{{ number_format($total_amt, 2) }} </strong></td>
                                        <td> <strong class="text-white ">{{ number_format($total_paid, 2) }} </strong></td>
                                        <td> <strong class="text-white ">{{ number_format($total_due, 2) }} </strong></td>
                                        <td colspan="4" class="header_style_right"></td>

                                    </tr>
                                </tfoot>
                            </table>
                       
                        {{-- {{ $invoices->onEachSide(1)->links() }} --}}
                        {{ $invoices->withQueryString()->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="bulkPrintContainer" class="d-none">
        @foreach ($invoices as $data)
            <div id="printableArea2-{{ $data->id }}" class="print_part2" style="margin-left: -10px">
                <div class="logo_part text-center" style="margin-top: 0px">
                    <span class=" text-black"><strong>
                            <h5 class="text-center" style="font-size:18px; font-weight:800">
                                {{ empty(get_setting('com_name')) ? 'Fast IT' : get_setting('com_name') }}
                            </h5>
                        </strong></span>
                </div>
                <div class="mt-1 text-right text-black container" style="margin-top: 0px;">
                    <strong style="font-size: 12px">Date: {{ $data->date }}
                    </strong>
                </div>

                <div class="container text-black" style="margin-left: -10px">
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10 text-left" style="line-height: 1.1;">
                            <strong> Parcel ID: {{ $data->consignment_id }}
                            </strong> </br>
                            <strong> NAME: {{ $data->customer?->name }} </strong>
                            </br>
                            <strong> MOBILE: {{ $data->customer?->phone }} </strong>
                            <br>
                            <strong> ADDRESS: {{ $data->customer?->address }}
                            </strong>
                        </div>
                        <div class="col-1"></div>
                    </div>
                </div>

                <div class=" container text-black">
                    <div class="row">
                        {{-- <div class="col-1"></div> --}}
                        <div class="col-12">
                            <h5 class="text-center text-black">Product List</h5>
                            <ul class="list" style="list-style:none;">
                                <li class="list-item" style="list-style:none;font-size:14px">
                                    <div class="">
                                        <div class="row text-left product_font">
                                            <div class="col-2 text-left">
                                                <strong style="font-size:14px">Sl</strong>
                                            </div>
                                            <div class="col-7  text-left">
                                                <strong style="font-size:14px">Description</strong>
                                            </div>
                                            <div class="col-3 text-right">
                                                <strong style="font-size:14px">Qty</strong>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @php
                                    $products = App\Models\InvoiceItem::where('invoice_id', $data->id)->get();
                                    $sl = 1;
                                @endphp
                                @foreach ($products as $item)
                                    <li class="list-item" style="font-size:12px">
                                        <div class="">
                                            <div class="row">
                                                <div class="col-2 text-left">
                                                    <strong style="font-size:13px">
                                                        {{ $sl++ }}
                                                    </strong>
                                                </div>
                                                <div class="col-7  text-left">
                                                    <strong style="font-size:13px">
                                                        {{ $item->product->name }}
                                                    </strong>
                                                </div>
                                                <div class="col-3 text-right">
                                                    <strong style="font-size:13px">
                                                        {{ number_format($item->main_qty, 0) }}
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class=" mb-4 mt-2 text-center text-black">
                    <span style="border:1px solid black;font-size: 16px; padding: 15px 20px;font-weight:800;">COD
                        - TK {{ $data->total_due }}</span>
                </div>
            </div>
        @endforeach
    </div>

@endsection
@push('js')
    <script>
        document.getElementById("selectAll").addEventListener("click", function () {
            let checkboxes = document.querySelectorAll(".invoiceCheckbox");
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });

        function printSelectedInvoices() {
            let selectedInvoices = document.querySelectorAll(".invoiceCheckbox:checked");

            if (selectedInvoices.length === 0) {
                alert("Please select at least one invoice to print.");
                return;
            }

            $('.modal').modal('hide'); // Modal বন্ধ করা

            setTimeout(() => {
                let printContents = "";
                selectedInvoices.forEach(invoice => {
                    let invoiceId = invoice.value;
                    let invoiceDiv = document.getElementById("printableArea2-" + invoiceId);
                    if (invoiceDiv) {
                        printContents += invoiceDiv.outerHTML +
                            '<div style="page-break-after: always;"></div>';
                    }
                });

                if (printContents) {
                    let originalContents = document.body.innerHTML;
                    document.body.innerHTML = `
                        <html>
                        <head>
                        <title>Bulk Invoice Print</title>
                        <style>
                            @media print {
                                body { font-size: 14px !important; }
                                .print_part2 { width: 100%; page-break-before: always; }
                                .modal, .modal-backdrop { display: none !important; }
                                .list-item { page-break-inside: avoid; }
                                .logo_part img { max-width: 100px !important; height: auto !important; }
                            }
                        </style>
                        </head>
                        <body>` + printContents + `</body></html>`;

                    window.print(); // প্রিন্ট কমান্ড চালানো

                    document.body.innerHTML = originalContents; // আগের অবস্থায় ফিরিয়ে আনা
                    // location.reload(); // রিফ্রেশ করে আগের UI ফেরত আনা
                }
            }, 500);
        }

$('#acceptBtn').click(function () {
    let ids = [];
    $('.invoiceCheckbox:checked').each(function () {
        ids.push($(this).val());
    });

    if (ids.length === 0) {
        alert("Please select at least one invoice.");
        return;
    }

    $.ajax({
        url: "{{ route('invoice.orderAccept') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            ids: ids
        },
        success: function (res) {
            if (res.status) {
                alert(res.message);
                location.reload();
            } else {
                alert(res.message || 'Something went wrong.');
            }
        },
        error: function (xhr) {
            console.error("Error:", xhr.responseText);
            alert('Something went wrong! Please try again.');
        }
    });
});





        function printDiv(divId) {
            var content = document.getElementById(divId).innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = content;
            window.print();
            document.body.innerHTML = originalContent;
            window.location.reload(); // Reload the page to restore the original content
        }
    </script>
@endpush