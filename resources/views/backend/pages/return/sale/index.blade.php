@extends('backend.layouts.master')
@section('section-title', 'Return Sale')
@section('page-title', 'Return Sale List')
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
</style>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body mb-2 card_style" style="margin-top: -3px" id="h-hide">
                <form action="{{ route('return.sale')}}">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <select class="select2" name="customer_id">
                                <option selected value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{($customer->id == $customer_id)?'selected': ''}}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="date" name="startDate" class="form-control" value="{{ $startDate }}">
                        </div>
                        <div class="form-group col-md-4">
                            <input type="date" name="endDate" class="form-control" value="{{ $endDate }}">
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="form-group col-12">
                            <button class="btn add_list_btn" type="submit">
                                    <i class="fa fa-sliders"></i> Filter
                            </button>
                            <a href="{{ route('return.sale') }}" class="btn add_list_btn_reset">Reset</a>
                            <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card m-b-30 card_style" style="margin-top: -35px">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">#SL</th>
                                    <th>Date</th>
                                    <th>Invoice No</th>
                                    <th>Product</th>
                                    {{-- <th>Qty</th> --}}
                                    <th>Biller</th>
                                    <th>Customer</th>
                                    <th>Price</th>
                                    {{-- <th>Return Price</th> --}}
                                    <th class="header_style_right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_amt = 0;
                                @endphp
                                @forelse ($returns as $key=> $item)
                                    @php
                                        $returnItems = App\Models\ReturnItem::where('return_id',$item->id)->get();
                                        $date = date_create($item->date);
                                        $total_amt += $item->total_return;
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left">{{ $key+1 }}</td>
                                        <td>{{ date('Y-m-d',strtotime($item->date)) }}</td>
                                        <td>{{ $item->invoice?->invoice_no }}</td>
                                        {{-- <td>{{ $item->product?->name }}</td> --}}
                                        <td>
                                            @foreach ($returnItems as $rtnItem)
                                                <ul>
                                                    <li>
                                                        @if ($rtnItem->product->unit->related_unit == null)
                                                            {{ $rtnItem->product->name }} ({{ $rtnItem->main_qty }} {{ $rtnItem->product->unit->name }}) <br>
                                                        @else
                                                            {{ $rtnItem->product->name }}
                                                            (
                                                                {{ $rtnItem->main_qty }} {{ $rtnItem->product->unit->name }} -
                                                                {{ $rtnItem->sub_qty }} {{ $rtnItem->product->unit->related_unit->name }}
                                                            ) <br>
                                                        @endif
                                                    </li>
                                                </ul>
                                            @endforeach
                                        </td>
                                        {{-- <td>{{ $item->main_qty }}</td> --}}
                                        <td>{{ $item->user?->name }}</td>
                                        <td>{{ $item->customer?->name }}</td>
                                        {{-- <td>{{ $item->invoice?->total_amount}}</td> --}}
                                        <td>{{ $item->total_return }}</td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    {{-- delete --}}
                                                    @if (check_permission('return.delete'))
                                                        <a class="dropdown-item text-danger" href="#" data-toggle="modal"
                                                            data-target="#deleteModal-{{ $item->id }}">
                                                            <i class="feather icon-trash"></i> Delete
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- delete modal --}}
                                            <form action="{{ route('return.delete', $item->id) }}" method="GET">
                                                @csrf
                                                <x-delete-modal title="Return" id="{{ $item->id }}" />
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center text-danger no_data_style">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="text-white text-right footer_style"  style=" font-size: 20px; font-width: 700; font-family:sans-serif">
                                    <td colspan="6" class="table_data_style_left text-white"><strong>Total: </strong></td>
                                    <td colspan="2" class="text-white"> <strong>{{ number_format($total_amt,2) }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                    <td colspan="" class="table_data_style_right"></td>
                                </tr>
                            </tfoot>
                        </table>
                        {{-- {{ $returns->onEachSide(1)->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
