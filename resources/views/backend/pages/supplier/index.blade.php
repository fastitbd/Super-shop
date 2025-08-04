@extends('backend.layouts.master')
@section('section-title', 'Supplier')
@section('page-title', 'Supplier List')
@if (check_permission('supplier.store'))
    @section('action-button')
        <a href="#" data-toggle="modal" data-target="#addModal" class="btn add_list_btn">
            <i class="mr-2 feather icon-plus"></i>
            Add Supplier
        </a>
    @endsection
@endif

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30 card_style">
                <div class="card-body">
                    <form action="{{ route('supplier.index') }}" method="GET">
                        @php
                            $supliers = App\Models\Supplier::get();
                        @endphp
                        <div class="row">
                            
                            <div class="col-md-3 mt-3">
                                <select name="supplier_id" id="" class="select2">
                                    <option value="">All Supplier</option>
                                    @foreach ($supliers as $item)
                                        <option value="{{ $item->id }}" {{ ($supplier_id == $item->id)? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-3">
                                <input type="text" placeholder="Enter Phone No" name="phone_no" value="{{ $phone_no }}" class="form-control">
                            </div>
                            <div class="col-md-6 col-12  mt-3">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-12 col-12">
                                        <button type="submit" class="btn add_list_btn">Filter</button>
                                        <a href="{{ route('supplier.index') }}" class="btn add_list_btn_reset" >Reset</a>
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
                                    <th>Total Purchase</th>
                                    <th>Purchase Paid</th>
                                    <th>Purchase Due</th>
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
                                @forelse($suppliers as $data)
                                    @php
                                    $count_sup = App\Models\Purchase::where('supplier_id', $data->id)->count();
                                    $count_tra = App\Models\Transaction::where('supplier_id', $data->id)->count();
                                    $open_balance = open_balance_supplier($data->id, $data->open_receivable, $data->open_payable);
                                    $pur_total = App\Models\Purchase::where('supplier_id', $data->id)->sum('total_amount');
                                    $pur_paid = App\Models\Purchase::where('supplier_id', $data->id)->sum('total_paid');
                                    $pur_due = App\Models\Purchase::where('supplier_id', $data->id)->sum('total_due');
                                    $total_amount += $pur_total;
                                    $total_paid += $pur_paid;
                                    $total_due += $pur_due;
                                    $personal_balance += $open_balance;
                                    @endphp
                                    <tr>
                                        <td class="table_data_style_left">{{ $loop->index + 1 }}</td>
                                        <td>{{ $data->name }} <br> {{ $data->phone }} <br> {{ ($data->email == Null)?'NULL':$data->email; }}</td>
                                        <td class="font-weight-bold">{{ $pur_total }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold">{{ $pur_paid }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold">{{ $pur_due }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="font-weight-bold">{{ $open_balance }} {{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</td>
                                        <td class="table_data_style_right">
                                            <div class="dropdown">
                                                <button class="btn add_list_btn btn-sm dropdown-toggle {{ $data->id == 1 ? 'disabled' : '' }}" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @if (check_permission('supplier.update'))
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#editModal-{{ $data->id }}"
                                                            class="dropdown-item text-primary">
                                                            <i class="feather icon-edit"></i> Edit
                                                        </a>
                                                    @endif

                                                    @if (check_permission('supplier.destroy'))
                                                        @if ($count_sup<1)
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#deleteModal-{{ $data->id }}"
                                                                class="dropdown-item text-danger">
                                                                <i class="feather icon-trash"></i> Delete
                                                            </a>
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                            
                                        </td>
                                    </tr>

                                    {{-- edit modal  --}}
                                    <form action="{{ route('supplier.update', $data->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <x-edit-modal title="Edit Supplier" sizeClass="modal-lg" id="{{ $data->id }}">
                                            <x-input label="Name *" type="text" name="name" placeholder="Enter Name"
                                                required md="6" value="{{ $data->name }}" />
                                            <x-input label="Email" type="email" name="email" placeholder="Enter Email"
                                                md="6" value="{{ $data->email }}" />
                                            <x-input label="Phone *" type="text" name="phone" placeholder="Enter Phone"
                                                required md="6" value="{{ $data->phone }}" />
                                            <x-input label="Address" type="text" name="address"
                                                placeholder="Enter Address" md="6"
                                                value="{{ $data->address }}" />
                                        </x-edit-modal>
                                    </form>

                                    {{-- delete modal --}}
                                    <form action="{{ route('supplier.destroy', $data->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-delete-modal title="Supplier" id="{{ $data->id }}" />
                                    </form>

                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center no_data_style text-danger">No Data Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="header_bg text-right">
                                    <td class="header_style_left" colspan="2"><strong style="font-size: 18px;color:rgb(255, 255, 255);">Total({{count($suppliers)}}): </strong></td>
                                    <td> <strong style="font-size: 18px;color:rgb(255, 255, 255);">{{ number_format($total_amount, 2) }}{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                    <td> <strong style="font-size: 18px;color:rgb(255, 255, 255);">{{ number_format($total_paid, 2) }}{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                    <td> <strong style="font-size: 18px;color:rgb(255, 255, 255);">{{ number_format($total_due, 2) }}{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                    <td> <strong style="font-size: 18px;color:rgb(255, 255, 255);">{{ number_format($personal_balance, 2) }}{{ empty(get_setting('com_currency')) ? : get_setting('com_currency') }}</strong></td>
                                    <td class="header_style_right" colspan="1"></td>
                                </tr>
                            </tfoot>
                        </table>
                        {{ $suppliers->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <form action="{{ route('supplier.store') }}" method="POST">
        @csrf
        <x-add-modal title="Add Supplier" sizeClass="modal-lg">
            <x-input label="Supplier Name *" type="text" name="name" placeholder="Enter Supplier Name" required
                md="6" />
            <x-input label="Email" type="email" name="email" placeholder="Enter Email"  md="6" />
            <x-input label="Phone *" type="text" name="phone" placeholder="Enter Phone" required md="6" />
            <x-input label="Address" type="text" name="address" placeholder="Enter Address"  md="6" />
            <x-input label="Opening Receivable" type="text" name="open_receivable" value="0" md="6" />
            <x-input label="Opening Payable" type="text" name="open_payable" value="0" md="6" />
        </x-add-modal>
    </form>

@endsection
