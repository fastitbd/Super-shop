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

            table,
            table th,
            table td {
                color: black !important;
            }

            .h-hide {
                display: none;
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
                    <form action="{{ route('invoice.index') }}" method="GET">
                        @php
                            $customers = App\Models\Customer::get();
                            $products = App\Models\Product::get();
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
                                        <option
                                            value="{{ $item->id }}"{{ $product_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-12 mt-3">
                                <select name="customer_id" id="" class="select2">
                                    <option value="">Select Customer</option>
                                    @foreach ($customers as $item)
                                        <option
                                            value="{{ $item->id }}"{{ $customer_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }} {{$item->phone}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3 h-hide d-flex justify-content-between">
                            <div class="col-md-12">
                                <button type="submit" class="btn add_list_btn">Filter</button>
                                <a href="{{ route('invoice.index') }}" class="btn add_list_btn_reset">Reset</a>
                                <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive mt-2">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead class="header_bg">
                                <tr class="text-center">
                                    <th class="header_style_left"> SL# </th>
                                    <th> Date </th>
                                    <th> Invoice No </th>
                                    <th> Customer </th>
                                    <th> Product Item(s) </th>
                                    <th> Total Amount </th>
                                    <th> Total Paid </th>
                                    <th> Total Due </th>
                                    <th> Return Amount </th>
                                    <th> Profit </th>
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
                                    $invoiceItem = App\Models\InvoiceItem::where('invoice_id',$data->id)->get();
                                    foreach($invoiceItem as $item){
                                    
                                   $product = App\Models\Product::where('id', $item->product_id)
                                            ->with('unit.related_unit')
                                            ->first();
                                            if ($product->unit?->related_unit == null) {
                                                $qty = number_format($item->main_qty, 0) . ' ' . $product->unit->name;
                                            } else {
                                                $sub_qty = $item->sub_qty == null ? 0 : $item->sub_qty;
                                                $qty =
                                                    number_format($item->main_qty, 0) .
                                                    ' ' .
                                                    $product->unit->name .
                                                    ' ' .
                                                    $sub_qty .
                                                    ' ' .
                                                    $product->unit->related_unit->name;
                                            }
                                            }
                                    $total_paid += $data->total_paid;
                                    $total_amt += $data->total_amount;
                                    $total_due += $data->total_due;
                                    $inv_items = App\Models\InvoiceItem::where('invoice_id',$data->id)->get();
                                @endphp
                                    <tr class="text-center">
                                        <td class="table_data_style_left">{{ $key + 1 }}</td>
                                        <td>{{ $data->date }}</td>
                                        <td>{{ $data->invoice_no }}</td>
                                        <td>{{ $data->customer->name }}</td>
                                        <td>
                                            @foreach ($inv_items as $item)
                                                <ul>
                                                    <li>
                                                        @if($data->status == 2)
                                                                {{ $item->product?->name }}{{$item->qty }} @if(env('APP_SC') == 'yes') ({{ $item->product_variation?->size?->size }}-{{ $item->product_variation?->color?->color }}) @endif
                                                            @else
                                                                {{ $item->product?->name }}{{ $item->qty }} @if($item->is_return == 1) <span class="badge bg-danger">Return</span> @endif  @if(env('APP_SC') == 'yes')  ({{ $item->product_variation?->size?->size }}-{{ $item->product_variation?->color?->color }}) @endif
                                                            @endif
                                                            ({{$qty }})
                                                    </li>
                                                </ul>
                                            @endforeach
                                        </td>
                                        <td>{{ $data->total_amount }}</td>
                                        <td>{{ $data->total_paid }}</td>
                                        <td>{{ $data->total_due }}</td>
                                        <td>
                                            @if($data->return_amount == null)
                                                    0.00
                                            @else
                                                {{$data->return_amount}}
                                            @endif
                                        </td>
                                        <td>{{ profit($data->id) }}</td>
                                        <td>
                                            @if ($data->status == 0)
                                                <span class="badge badge-warning">Due</span>
                                            @elseif($data->status == 1)
                                                <span class="badge badge-success">Paid</span>
                                            @elseif($data->status == 2)
                                                <span class="badge badge-danger">Returned</span>
                                            @endif
                                        </td>
                                        <td>{{ $data->user->name }}</td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" >
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    {{-- pay button  --}}
                                                    @if (check_permission('invoice.pay'))
                                                        @if ($data->total_due > 0)
                                                            <a class="dropdown-item"
                                                                href="{{ url('invoice/pay/' . $data->id) }}"
                                                                class="btn btn-success-rgba">
                                                                <i class="feather icon-dollar-sign"></i> Due
                                                            </a>
                                                        @endif
                                                    @endif
                                                    {{-- return amount --}}
                                                    {{-- @if($data->total_due < 0)
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#editModal-{{ $data->id }}"
                                                            class="dropdown-item text-primary">
                                                            <i class="fa fa-undo"></i> Return amount
                                                        </a>
                                                    @endif --}}
                                                    {{-- return --}}
                                                    @if (check_permission('return.create'))
                                                        <a href="{{ url('return/sale/'.$data->id) }}" class="dropdown-item"
                                                            class="btn btn-danger-rgba">
                                                            <i class="fa fa-undo"></i> Return
                                                        </a>
                                                    @endif
                                                    {{-- exchange --}}
                                                    @if (check_permission('invoice.exchange'))
                                                        <a href="{{ url('invoice/exchange/'.$data->id) }}" class="dropdown-item"
                                                            class="btn btn-danger-rgba">
                                                            <i class="fa fa-pencil-square-o"></i> Exchange / Edit
                                                        </a>
                                                    @endif
                                                    
                                                    {{-- edit --}}
                                                    {{-- @if (check_permission('invoice.edit')) --}}
                                                        {{-- <a href="{{ route('inv.edit',$data->id) }}" class="dropdown-item"
                                                            class="btn btn-danger-rgba">
                                                            <i class="fa fa-pencil-square-o"></i> Edit
                                                        </a> --}}
                                                    {{-- @endif --}}
                                                    {{-- print --}}
                                                    <a class="dropdown-item" href="{{ route('invoice.print', $data->id) }}"
                                                        class="btn btn-success-rgba">
                                                        <i class="feather icon-printer"></i> Print
                                                    </a>
                                                    @php
                                                        $return_tbl = App\Models\ReturnTbl::where('invoice_id',$data->id)->first();
                                                        $del_invoice = App\Models\Invoice::where('id',$data->id)->latest()->first();
                                                        // dd($del_invoice->id);
                                                    @endphp
                                                    
                                                    {{-- delete --}}
                                                    @if (check_permission('invoice.destroy'))
                                                        @if($return_tbl?->invoice_id != $data->id )
                                                        <a href="#" class="dropdown-item" data-toggle="modal"
                                                            data-target="#deleteModal-{{ $data->id }}"
                                                            class="btn btn-danger-rgba">
                                                            <i class="feather icon-trash"></i> Delete 
                                                        </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- return amount modal  --}}
                                    <form action="{{route('invoice.return.amount',$data->id)}}" method="POST">
                                        @csrf
                                        {{-- @method('PUT') --}}
                                        <x-edit-modal title="Payment Amount" sizeClass="modal-md" id="{{ $data->id }}">
                                            <div class="mt-2 col-md-12">
                                                <label class="form-label font-weight-bold">Date</label>
                                                <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="date">
                                                <div class="error">{{ ($errors->has('date'))?$errors->first('date'):''; }}</div>
                                            </div>
                                            <div class="mt-2 col-md-12">
                                                <label class="form-label font-weight-bold">Bank Account *</label>
                                                @php
                                                    $bank_accounts = App\Models\BankAccount::where('status',1)->orderBy('bank_name','asc')->get();
                                                @endphp
                                                <select class="select2" name="bank_id">
                                                    @foreach ($bank_accounts as $bank_account)
                                                        <option value="{{ $bank_account->id }}" >
                                                            {{ $bank_account->bank_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="mt-2 col-md-12">
                                                <input type="text" name="return_cus_amount" id="" value="{{$data->total_paid}}">
                                                <label for="return_paid_amount" class="form-label fw-bold">Amount *</label>
                                                <input type="number" class="form-control" min="1" step="any" required
                                                    placeholder="Enter Amount" name="return_paid_amount" value="{{abs($data->total_paid)}}">
                                                <div class="error">{{ ($errors->has('return_paid_amount'))?$errors->first('return_paid_amount'):''; }}</div>
                                            </div>
                                        </x-edit-modal>
                                    </form>
                                    {{-- delete modal --}}
                                    <form action="{{ route('invoice.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Invoice" id="{{ $data->id }}" />
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center text-danger no_data_style">No Invoice Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="text-right header_bg">
                                    <td colspan="6" class="header_style_left text-white "><strong>Total: </strong></td>
                                    <td> <strong class="text-white ">{{ number_format($total_amt,2) }} </strong></td>
                                    <td> <strong class="text-white ">{{ number_format($total_paid,2) }} </strong></td>
                                    <td> <strong class="text-white ">{{ number_format($total_due,2) }} </strong></td>
                                    <td colspan="4" class="header_style_right"></td>

                                </tr>
                            </tfoot>
                        </table>
                        {{ $invoices->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
