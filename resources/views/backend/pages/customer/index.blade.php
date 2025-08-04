@extends('backend.layouts.master')
@section('section-title', 'Customer')
@section('page-title', 'Customer List')
@if (check_permission('customer.store'))
    @section('action-button')
        <a href="#" data-toggle="modal" data-target="#addModal" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Customer
        </a>
    @endsection
@endif
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
                <div class="card-body">
                    <form action="{{ route('customer.index') }}" method="GET">
                        @php
                            $custommer = App\Models\Customer::get();
                        @endphp
                        <div class="row h-hide">
                            
                            <div class="col-md-3 mt-3">
                                <select name="customer_id" id="" class="select2">
                                    <option value="">All Customer</option>
                                    @foreach ($custommer as $item)
                                        <option value="{{ $item->id }}" {{ ($customer_id == $item->id)? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-3">
                                <input type="text" placeholder="Enter Phone No" name="phone_no" value="{{ $phone_no }}" class="form-control">
                            </div>
                            <div class="col-md-6 col-12 mt-3">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-12 col-12 ">
                                        <button type="submit" class="btn add_list_btn">Filter</button>
                                        <a href="{{ route('customer.index') }}" class="btn add_list_btn_reset" >Reset</a>
                                        <a href="" class="btn add_list_btn float-right" onclick="window.print()">Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive mt-3">
                        <table id="datatable-buttons" class="table table-striped text-center">
                            <thead class="header_bg">
                                <tr>
                                    <th class="header_style_left">#SL</th>
                                    <th>Name & Email & Phone</th>
                                    <th>Total Invoice</th>
                                    <th>Paid Invoice</th>
                                    <th>Due Invoice</th>
                                    <th>Personal Balance</th>
                                    <th class="header_style_right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_amount = 0;
                                    $total_paid = 0;
                                    $total_due = 0;
                                    $personal_balance = 0;
                                    $total_count = 0;
                                @endphp
                                @forelse($customers as $data)
                                    @php
                                    $count_cus = App\Models\Invoice::where('customer_id', $data->id)->count();
                                    $count_tra = App\Models\Transaction::where('customer_id', $data->id)->count();
                                    $open_balance = open_balance_customer($data->id, $data->open_receivable, $data->open_payable);
                                    $inv_total = App\Models\Invoice::where('customer_id', $data->id)->sum('total_amount');
                                    $inv_paid = App\Models\Invoice::where('customer_id', $data->id)->sum('total_paid');
                                    // $inv_due = App\Models\Invoice::where('customer_id', $data->id)->sum('total_due');
                                    $inv_due = App\Models\Invoice::where('customer_id', $data->id)->where('status',0)->sum('total_due');
                                    $total_amount += $inv_total;
                                    $total_paid += $inv_paid;
                                    $total_due += $inv_due;
                                    $personal_balance += $open_balance;
                                    
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }} <br> {{ $data->phone }} <br> {{ ($data->email == Null)?'NULL':$data->email; }}</td>
                                        <td class="font-weight-bold">{{ $inv_total }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold">{{ $inv_paid }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold">{{ $inv_due }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold">{{ $open_balance }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle {{ $data->id == 1 ? 'disabled' : '' }}" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @if (check_permission('customers.update'))
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#editModal-{{ $data->id }}"
                                                            class="dropdown-item text-primary">
                                                            <i class="feather icon-edit"></i> Edit
                                                        </a>
                                                    @endif

                                                    @if (check_permission('customers.destroy'))
                                                        @if ($count_cus<1)
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#deleteModal-{{ $data->id }}"
                                                                class="dropdown-item text-danger ">
                                                                <i class="feather icon-trash"></i> Delete
                                                            </a>
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- edit modal  --}}
                                    <form action="{{ route('customer.update', $data->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <x-edit-modal title="Edit Customer" sizeClass="modal-lg" id="{{ $data->id }}">
                                            <x-input label="Name *" type="text" name="name" placeholder="Enter Name" required md="6" value="{{ $data->name }}" />
                                            <x-input label="Email" type="email" name="email" placeholder="Enter Email" md="6" value="{{ $data->email }}" />
                                            <x-input label="Phone *" type="text" name="phone" placeholder="Enter Phone" required md="6" value="{{ $data->phone }}" />
                                            <x-input label="Address" type="text" name="address" placeholder="Enter Address" md="6" value="{{ $data->address }}" />
                                        </x-edit-modal>
                                    </form>

                                    {{-- delete modal --}}
                                    <form action="{{ route('customer.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Customer" id="{{ $data->id }}" />
                                    </form>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center text-danger">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @php
                                
                            @endphp
                            <tfoot>
                                <tr class="header_bg text-right">
                                    <td class="header_style_left" colspan="2"><strong style="font-size: 18px;color:rgb(255, 255, 255);">Total({{count($customers)}}): </strong></td>
                                    <td> <strong style="font-size: 18px;color:rgb(255, 255, 255);">{{ number_format($total_amount, 2) }}{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                    <td> <strong style="font-size: 18px;color:rgb(255, 255, 255);">{{ number_format($total_paid, 2) }}{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                    <td> <strong style="font-size: 18px;color:rgb(255, 255, 255);">{{ number_format($total_due, 2) }}{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                    <td> <strong style="font-size: 18px;color:rgb(255, 255, 255);">{{ number_format($personal_balance, 2) }}{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                    <td class="header_style_right" colspan="1"></td>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $customers->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <form action="{{ route('customer.store') }}" method="POST">
        @csrf
        <x-add-modal title="Add Customer" sizeClass="modal-lg">
            <x-input label="Customer Name *" type="text" name="name" placeholder="Enter Customer Name" required
                md="6" />
            <x-input label="Email" type="email" name="email" placeholder="Enter Email" md="6" />
            <x-input label="Phone *" type="text" name="phone" placeholder="Enter Phone" required md="6" />
            <x-input label="Address" type="text" name="address" placeholder="Enter Address" md="6" />
            <x-input label="Opening Receivable" type="text" name="open_receivable" value="0" md="6" />
            <x-input label="Opening Payable" type="text" name="open_payable" value="0" md="6" />
        </x-add-modal>
    </form>

@endsection
